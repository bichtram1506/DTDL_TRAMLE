// Lấy tham chiếu đến các phần tử HTML
const chatbotButton = document.getElementById('chatbot-button');
const chatbotContainer = document.getElementById('chatbot-container');

// Function để mở chatbot
function openChatbot() {
    chatbotContainer.style.display = 'block';
    chatbotButton.style.display = 'none';
}

// Function để đóng chatbot
function closeChatbot() {
    chatbotContainer.style.display = 'none';
    chatbotButton.style.display = 'block';
}

// Event listener cho nút chatbot
chatbotButton.addEventListener('click', openChatbot);

// Event listener cho nút đóng chatbot (nếu cần)
// const closeButton = document.getElementById('chatbot-close');
// closeButton.addEventListener('click', closeChatbot);
