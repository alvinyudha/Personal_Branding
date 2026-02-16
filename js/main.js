const menu = document.querySelector('.menu');
const navDropdown = document.querySelector('.nav-dropdown');
const iconBars = document.querySelector('.icon-bars');
const iconClose = document.querySelector('.icon-close');

function displayMenu() {
    if(menu.classList.contains('show')) {
        menu.classList.remove('show');
        iconBars.style.display = 'inline';
        iconClose.style.display = 'none';
    } else {
        menu.classList.add('show');
        iconBars.style.display = 'none';
        iconClose.style.display = 'inline';
    }
}