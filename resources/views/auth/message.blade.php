@extends('layouts.app')

@section('titulo', 'Mensajes')

@section('contenido')
<style>
    .chat-container {
        height: 80vh;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .sidebar {
        width: 280px;
        background-color: #f8f9fa;
        border-right: 1px solid #dee2e6;
        overflow-y: auto;
    }

    .chat-box {
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }

    .messages {
        padding: 1rem;
        overflow-y: auto;
        flex-grow: 1;
        background-color: #e9ecef;
    }

    .message {
        max-width: 60%;
        padding: 10px 15px;
        border-radius: 20px;
        margin-bottom: 10px;
        word-break: break-word;
    }

    .message.sent {
        background-color: #0d6efd;
        color: white;
        align-self: flex-end;
    }

    .message.received {
        background-color: #ffffff;
        color: #000;
        align-self: flex-start;
    }

    .input-area {
        border-top: 1px solid #dee2e6;
        padding: 10px;
    }

    .user-item {
        cursor: pointer;
    }

    .user-item:hover {
        background-color: #e2e6ea;
    }

    .user-item.active {
        background-color: #d6d8db;
        font-weight: bold;
    }
</style>

<div class="chat-container d-flex">
    <div class="sidebar p-3">
        <h5>Conversaciones</h5>
        <ul id="conversation-list" class="list-group">
            @foreach($users as $user)
                <li class="list-group-item user-item" data-id="{{ $user->id }}">
                    {{ $user->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="chat-box flex-grow-1 d-flex flex-column">
        <div class="messages" id="messages"></div>
        <div class="input-area d-flex align-items-center">
            <input type="text" id="message-input" class="form-control me-2" placeholder="Escribe un mensaje...">
            <input type="file" id="image-input" class="form-control me-2">
            <button class="btn btn-primary" onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</div>

<script>
    const userId = {{ auth()->id() }};
    let selectedUserId = null;
    const messagesContainer = document.getElementById('messages');
    const userItems = document.querySelectorAll('.user-item');

    userItems.forEach(item => {
        item.addEventListener('click', function () {
            userItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            selectedUserId = this.getAttribute('data-id');
            loadMessages(selectedUserId);
        });
    });

    function loadMessages(toUserId) {
        axios.get(/messages/${toUserId})
            .then(response => {
                messagesContainer.innerHTML = '';
                response.data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(msg.user_id === userId ? 'sent' : 'received');
                    messageDiv.textContent = msg.text;
                    messagesContainer.appendChild(messageDiv);
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }

    function sendMessage() {
        if (!selectedUserId) return;

        const text = document.getElementById('message-input').value;
        const imageInput = document.getElementById('image-input').files[0];

        let formData = new FormData();
        formData.append('text', text);
        formData.append('receiver_id', selectedUserId);
        if (imageInput) formData.append('image', imageInput);

        axios.post('/messages/send', formData)
            .then(() => {
                document.getElementById('message-input').value = '';
                document.getElementById('image-input').value = '';
                loadMessages(selectedUserId);
            });
    }
</script>
@endsection
