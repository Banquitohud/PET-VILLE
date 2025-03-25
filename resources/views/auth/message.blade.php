<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Pet Ville</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <style>
        .chat-container { display: flex; height: 100vh; }
        .sidebar { width: 25%; border-right: 1px solid #ddd; overflow-y: auto; }
        .chat-box { flex: 1; display: flex; flex-direction: column; }
        .messages { flex: 1; padding: 15px; overflow-y: auto; }
        .message { padding: 10px; border-radius: 10px; margin-bottom: 10px; }
        .sent { background-color: #d1e7dd; align-self: flex-end; }
        .received { background-color: #f8d7da; align-self: flex-start; }
        .input-area { display: flex; padding: 10px; border-top: 1px solid #ddd; }
        .input-area input, .input-area button { margin-right: 10px; }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="sidebar p-3">
            <h5>Conversaciones</h5>
            <ul id="conversation-list" class="list-group">
                <!-- Lista de contactos cargada dinámicamente -->
            </ul>
        </div>
        <div class="chat-box">
            <div class="messages" id="messages"></div>
            <div class="input-area">
                <input type="text" id="message-input" class="form-control" placeholder="Escribe un mensaje...">
                <input type="file" id="image-input" class="form-control">
                <button class="btn btn-primary" onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>

    <script>
        const userId = {{ auth()->id() }};
        const messagesContainer = document.getElementById('messages');

        function sendMessage() {
            const text = document.getElementById('message-input').value;
            const imageInput = document.getElementById('image-input').files[0];

            let formData = new FormData();
            formData.append('text', text);
            if (imageInput) formData.append('image', imageInput);

            axios.post('/messages/send', formData)
                .then(response => {
                    document.getElementById('message-input').value = '';
                    document.getElementById('image-input').value = '';
                });
        }

        Pusher.logToConsole = true;
        const pusher = new Pusher('PUSHER_APP_KEY', { cluster: 'PUSHER_CLUSTER', encrypted: true });
        const channel = pusher.subscribe('chat');

        channel.bind('message-sent', function(data) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', data.user_id === userId ? 'sent' : 'received');
            messageDiv.textContent = data.text;
            messagesContainer.appendChild(messageDiv);
        });
    </script>
</body>
</html>
