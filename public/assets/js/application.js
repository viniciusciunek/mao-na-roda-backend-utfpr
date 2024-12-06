const btn = document.getElementById('mobile-menu-button');
const sidebar = document.getElementById('sidebar');

btn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
});

document.addEventListener("DOMContentLoaded", () => {
    const flashMessages = document.querySelectorAll('.flash-message');

    flashMessages.forEach((message) => {
        setTimeout(() => {
            message.remove();
        }, 5000);
    });
});
