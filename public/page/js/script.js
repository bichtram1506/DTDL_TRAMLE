const notificationIcon = document.querySelector('.notification-icon');
const notificationModal = document.querySelector('.notification-modal');
const closeButton = document.querySelector('.close-button');

notificationIcon.addEventListener('click', () => {
    notificationModal.style.display = 'block';
});

closeButton.addEventListener('click', () => {
    notificationModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === notificationModal) {
        notificationModal.style.display = 'none';
    }
});
