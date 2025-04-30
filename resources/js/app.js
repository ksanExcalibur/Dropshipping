import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');
const messagesContainer = document.getElementById('messages');

// Listen for messages
window.Echo.private(`chat.${authUserId}`)
    .listen('MessageSent', (data) => {
        const messageElement = document.createElement('div');
        messageElement.className = 'message received';
        messageElement.innerHTML = `
            <img src="${data.sender.image}" alt="${data.sender.name}">
            <div>
                <strong>${data.sender.name}</strong>
                <p>${data.message}</p>
                <small>${new Date(data.created_at).toLocaleTimeString()}</small>
            </div>
        `;
        messagesContainer.appendChild(messageElement);
    });

// Send message
sendButton.addEventListener('click', () => {
    const message = messageInput.value.trim();
    
    if (message) {
        axios.post('/message', {
            message: message,
            receiver_id: receiverId
        }).then(response => {
            messageInput.value = '';
        }).catch(error => {
            console.error(error);
        });
    }
});