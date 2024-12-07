document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');

    const btnCollapse = document.querySelector('.btn-collapse');
    const btnCollapsed = document.querySelector('.btn-collapsed');

    btnCollapse.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebar.classList.remove('lg:relative');
        sidebar.classList.remove('lg:translate-x-0');
    });

    btnCollapsed.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebar.classList.add('lg:relative');
        sidebar.classList.add('lg:translate-x-0');
    });

    const flashMessages = document.querySelectorAll('.flash-message');

    flashMessages.forEach((message) => {
        setTimeout(() => {
            message.remove();
        }, 5000);
    });

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
});
