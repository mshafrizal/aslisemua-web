require('./bootstrap');
// ==============================
//
//  PROFILE
//
// ==============================


// User Menu
const userMenu = document.getElementById('user-menu');
const userMenuList = document.getElementById('user-menu-list');

function showMenuList () {
  userMenuList.classList.remove('hidden');
}

function hideMenuList () {
  userMenuList.classList.add('hidden');
}

userMenu.addEventListener('click', function () {
  if (userMenuList.classList.contains('hidden')) showMenuList()
  else hideMenuList()
})

// Mobile Navigation
const navMenu = document.getElementById('navigation-menu');
const navMenuList = document.getElementById('')
function showNavList() {
  
}

function hideNavList() {

}

navMenu.addEventListener('click', function () {
  if (navMenuList.classList.contains('hidden')) showNavList()
  else hideNavList()
})

// Alert

window.closeAlert = (id) => {
  const alertEl = document.getElementById(id);
  alertEl.remove()
}

window.showAlert = (id) => {
  const alertEl = document.getElementById(id);
  alertEl.classList.remove('hidden');
  alertEl.classList.add('flex');
}