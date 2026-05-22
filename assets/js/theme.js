const html = document.documentElement;
const toggle = document.getElementById('themeToggle');
const icon = document.getElementById('themeIcon');

const savedTheme =
    localStorage.getItem('theme') || 'dark';

setTheme(savedTheme);

toggle.addEventListener('click', () => {
    const current = html.getAttribute('data-theme');
    const newTheme = current === 'dark' ? 'light' : 'dark';

    setTheme(newTheme);
});

function setTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);

    icon.style.transform = 'rotate(180deg)';

    setTimeout(() => {
        icon.style.transform = 'rotate(0deg)';
    }, 300);
    if (theme === 'dark') {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        toggle.classList.add('btn-outline-light');
        toggle.classList.remove('btn-outline-dark');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        toggle.classList.remove('btn-outline-light');
        toggle.classList.add('btn-outline-dark');
    }
}