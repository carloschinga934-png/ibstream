<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot AMPARO</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .chatbot-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .chatbot-toggle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #00ff88 0%, #00cc6a 100%);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 8px 32px rgba(0, 255, 136, 0.4);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .chatbot-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(0, 255, 136, 0.6);
        }

        .chatbot-toggle.active {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        }

        .chat-icon {
            font-size: 32px;
            color: white;
            transition: all 0.3s ease;
        }

        .chat-icon.rotate {
            transform: rotate(180deg);
        }

        .notification-dot {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #00ff88, #00cc6a);
            border-radius: 50%;
            animation: pulse 2s infinite;
            border: 2px solid white;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .chatbot-container {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 380px;
            max-width: 90vw;
            height: 500px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            transform: translateY(20px) scale(0.9);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .chatbot-container.active {
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .chat-header {
            background: linear-gradient(135deg, #00ff88 0%, #00cc6a 100%);
            padding: 20px;
            color: white;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .chat-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a" cx="50%" cy="0%" r="100%"><stop offset="0%" stop-color="white" stop-opacity="0.1"/><stop offset="100%" stop-color="white" stop-opacity="0"/></radialGradient></defs><rect width="100" height="20" fill="url(%23a)"/></svg>');
            pointer-events: none;
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #7bed9f, #70a1ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .chat-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .chat-status {
            font-size: 12px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #7bed9f;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .chat-messages {
            height: 340px;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            scroll-behavior: smooth;
        }

        .chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 2px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #00ff88, #00cc6a);
            border-radius: 2px;
        }

        .message {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            flex-direction: row-reverse;
            align-self: flex-end;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .bot-avatar {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .user-avatar {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .message-bubble {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            position: relative;
        }

        .bot-message {
            background: linear-gradient(135deg, #f8f9ff, #e8ecff);
            color: #2c3e50;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .user-message {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 12px 16px;
            background: linear-gradient(135deg, #f8f9ff, #e8ecff);
            border-radius: 18px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #667eea;
            border-radius: 50%;
            animation: typing 1.4s ease-in-out infinite;
        }

        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.4;
            }
            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        .chat-input {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .input-container {
            display: flex;
            gap: 10px;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .input-container:focus-within {
            box-shadow: 0 4px 25px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        .chat-input input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px 16px;
            font-size: 14px;
            background: transparent;
            color: #2c3e50;
        }

        .chat-input input::placeholder {
            color: #95a5a6;
        }

        .send-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .send-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #5a6fd8, #6a4190);
            transform: scale(1.05);
        }

        .send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quick-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .quick-action {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quick-action:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .success-animation {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            color: #2ecc71;
            animation: successPop 0.6s ease;
            pointer-events: none;
        }

        @keyframes successPop {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.5);
            }
            50% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1.2);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @media (max-width: 480px) {
            .chatbot-container {
                width: 95vw;
                height: 80vh;
                bottom: 10px;
                right: 2.5vw;
            }
        }
    </style>
</head>
<body>
    <div id="chatbot-widget" class="chatbot-widget">
        <!-- Toggle Button -->
        <button class="chatbot-toggle" onclick="toggleChat()">
            <span class="chat-icon">💬</span>
            <div class="notification-dot"></div>
        </button>

        <!-- Chat Container -->
        <div id="chatbot-container" class="chatbot-container">
            <!-- Header -->
            <div class="chat-header">
                <div class="chat-avatar">🤖</div>
                <div class="chat-title">AMPARO</div>
                <div class="chat-status">
                    <div class="status-dot"></div>
                    Asesora Virtual Online
                </div>
                <button class="close-btn" onclick="closeChat()">×</button>
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="chat-messages">
                <div class="message">
                    <div class="message-avatar bot-avatar">🤖</div>
                    <div class="message-bubble bot-message">
                        ¡Hola! Soy AMPARO, tu Asesora Virtual. ¿Cómo puedo ayudarte hoy?
                    </div>
                </div>
                <div class="quick-actions">
                    <button class="quick-action" onclick="startConversation()">Empezar conversación</button>
                    <button class="quick-action" onclick="showInfo()">Información</button>
                </div>
            </div>

            <!-- Input -->
            <div class="chat-input">
                <div class="input-container">
                    <input type="text" id="chat-input" placeholder="Escribe tu mensaje..." onkeypress="handleKeyPress(event)">
                    <button class="send-btn" id="send-btn" onclick="sendMessage()">
                        <span>→</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chatState = 'initial';
        let userData = {};
        let isOpen = false;

        function toggleChat() {
            const container = document.getElementById('chatbot-container');
            const toggle = document.querySelector('.chatbot-toggle');
            const icon = document.querySelector('.chat-icon');
            const dot = document.querySelector('.notification-dot');
            
            isOpen = !isOpen;
            
            if (isOpen) {
                container.classList.add('active');
                toggle.classList.add('active');
                icon.classList.add('rotate');
                icon.innerHTML = '×';
                dot.style.display = 'none';
                
                // Focus input
                setTimeout(() => {
                    document.getElementById('chat-input').focus();
                }, 400);
            } else {
                closeChat();
            }
        }

        function closeChat() {
            const container = document.getElementById('chatbot-container');
            const toggle = document.querySelector('.chatbot-toggle');
            const icon = document.querySelector('.chat-icon');
            
            isOpen = false;
            container.classList.remove('active');
            toggle.classList.remove('active');
            icon.classList.remove('rotate');
            icon.innerHTML = '💬';
        }

        function startConversation() {
            addMessage('user', '¡Hola!');
            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    addMessage('bot', '¡Perfecto! Para poder ayudarte mejor, necesito algunos datos. ¿Cuál es tu nombre completo?');
                    chatState = 'asking_name';
                    enableInput();
                }, 1500);
            }, 500);
        }

        function showInfo() {
            addMessage('user', 'Información');
            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    addMessage('bot', 'Soy AMPARO, tu asesora virtual especializada en ayudarte con consultas y servicios. Puedo registrar tus datos para brindarte un mejor servicio personalizado.');
                    enableInput();
                }, 1500);
            }, 500);
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (!message) return;
            
            addMessage('user', message);
            input.value = '';
            disableInput();
            
            setTimeout(() => {
                processMessage(message);
            }, 500);
        }

        function processMessage(message) {
            showTyping();
            
            setTimeout(() => {
                hideTyping();
                
                switch (chatState) {
                    case 'asking_name':
                        userData.nombre = message;
                        addMessage('bot', `Gracias, ${message}. Ahora necesito tu número de teléfono (9 dígitos).`);
                        chatState = 'asking_phone';
                        enableInput();
                        break;
                        
                    case 'asking_phone':
                        const phoneRegex = /^[0-9]{9}$/;
                        if (phoneRegex.test(message)) {
                            userData.telefono = message;
                            addMessage('bot', '¡Excelente! Estoy guardando tu información...');
                            saveToDatabase();
                            chatState = 'completed';
                            disableInput();
                        } else {
                            addMessage('bot', 'Por favor, ingresa un número de teléfono válido (9 dígitos numéricos).');
                            enableInput();
                        }
                        break;
                        
                    default:
                        if (message.toLowerCase().includes('hola')) {
                            startConversation();
                        } else {
                            addMessage('bot', 'Para comenzar, escribe "hola" o usa los botones de acción rápida.');
                            enableInput();
                        }
                }
            }, Math.random() * 1000 + 1000);
        }

        function addMessage(sender, text) {
            const messagesContainer = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender === 'user' ? 'user' : ''}`;
            
            const avatar = document.createElement('div');
            avatar.className = `message-avatar ${sender === 'user' ? 'user-avatar' : 'bot-avatar'}`;
            avatar.innerHTML = sender === 'user' ? '👤' : '🤖';
            
            const bubble = document.createElement('div');
            bubble.className = `message-bubble ${sender === 'user' ? 'user-message' : 'bot-message'}`;
            bubble.textContent = text;
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(bubble);
            
            // Remove quick actions if they exist
            const quickActions = messagesContainer.querySelector('.quick-actions');
            if (quickActions && sender === 'user') {
                quickActions.remove();
            }
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTyping() {
            const messagesContainer = document.getElementById('chat-messages');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message';
            typingDiv.id = 'typing-indicator';
            
            const avatar = document.createElement('div');
            avatar.className = 'message-avatar bot-avatar';
            avatar.innerHTML = '🤖';
            
            const typingBubble = document.createElement('div');
            typingBubble.className = 'typing-indicator';
            typingBubble.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
            
            typingDiv.appendChild(avatar);
            typingDiv.appendChild(typingBubble);
            
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function hideTyping() {
            const typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        function enableInput() {
            const input = document.getElementById('chat-input');
            const button = document.getElementById('send-btn');
            input.disabled = false;
            button.disabled = false;
            input.focus();
        }

        function disableInput() {
            const input = document.getElementById('chat-input');
            const button = document.getElementById('send-btn');
            input.disabled = true;
            button.disabled = true;
        }

        function saveToDatabase() {
            // Obtener token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/guardar-contacto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(userData),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Éxito:', data);
                if (data.success) {
                    showSuccessAnimation();
                    setTimeout(() => {
                        addMessage('bot', '¡Perfecto! Tus datos han sido guardados exitosamente. ¡Gracias por confiar en AMPARO! 🎉');
                        setTimeout(() => {
                            addMessage('bot', '¿Hay algo más en lo que pueda ayudarte?');
                            enableInput();
                            chatState = 'completed';
                        }, 1000);
                    }, 600);
                } else {
                    addMessage('bot', 'Hubo un problema al guardar tus datos. Por favor intenta nuevamente.');
                    chatState = 'asking_phone';
                    enableInput();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                addMessage('bot', 'Error de conexión. Por favor verifica tu conexión a internet e intenta nuevamente.');
                chatState = 'asking_phone';
                enableInput();
            });
        }

        function showSuccessAnimation() {
            const container = document.getElementById('chatbot-container');
            const successIcon = document.createElement('div');
            successIcon.className = 'success-animation';
            successIcon.innerHTML = '✅';
            container.appendChild(successIcon);
            
            setTimeout(() => {
                successIcon.remove();
            }, 600);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            disableInput();
            
            // Show notification after some time if chat hasn't been opened
            setTimeout(() => {
                if (!isOpen) {
                    const dot = document.querySelector('.notification-dot');
                    if (dot) {
                        dot.style.animation = 'pulse 1s infinite';
                    }
                }
            }, 5000);
        });
    </script>
</body>
</html>