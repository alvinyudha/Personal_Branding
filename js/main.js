const menu = document.querySelector('.menu');
const navDropdown = document.querySelector('.dropbtn');
const iconBars = document.querySelector('.icon-bars');
const iconClose = document.querySelector('.icon-close');

function displayMenu() {
    if(menu.classList.contains('show')) {
        menu.classList.remove('show');
      
    } else {
        menu.classList.add('show');
    }
}
