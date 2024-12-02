const btn = document.getElementById('mobile-menu-button');
const sidebar = document.getElementById('sidebar');

btn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
});
