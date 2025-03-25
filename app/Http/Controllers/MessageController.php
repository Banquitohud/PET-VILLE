<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;

class MessageController extends Controller
{
    // Mostrar vista de mensajes
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('auth.message', compact('users'));
    }

    // Obtener mensajes con un usuario específico
    public function getMessages(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // Enviar un mensaje
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'text' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->text = $request->text;

        // Guardar imagen si se envía
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('messages', 'public');
            $message->image = $path;
        }

        $message->save();

        // Emitir el evento MessageSent
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'user_id' => $message->sender_id,
            'text' => $message->text,
            'image' => $message->image ? asset('storage/' . $message->image) : null
        ]);
    }
}
