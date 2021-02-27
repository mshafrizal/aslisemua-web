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
if (userMenu) {
  userMenu.addEventListener('click', function () {
    if (userMenuList.classList.contains('hidden')) showMenuList()
    else hideMenuList()
  })
}

// Mobile Navigation
const navMenu = document.getElementById('navigation-menu');
const navMenuList = document.getElementById('')
function showNavList() {
  
}

function hideNavList() {

}
if (navMenu) {
  navMenu.addEventListener('click', function () {
    if (navMenuList.classList.contains('hidden')) showNavList()
    else hideNavList()
  })
}

// Alert

window.closeAlert = (id) => {
  const alertEl = document.getElementById(id);
  alertEl.classList.remove('flex');
  alertEl.classList.add('hidden');
  clearTimeout();
}

window.showAlert = (id, payload) => {
  const alertEl = document.getElementById(id);
  const messageEl = document.getElementById('snackbarMessage') || null
  if (messageEl) {
    if (payload) {
      messageEl.textContent = payload.message
      if (payload.type === 'warning') {
        alertEl.classList.add('bg-white', 'border', 'border-yellow-500', 'text-yellow-500', 'absolute', 'top-4', 'left-0', 'right-0', 'ml-auto', 'mr-auto')
      } else if (payload.type === 'error') {
        alertEl.classList.add('bg-white', 'border', 'border-red-500', 'text-red-500', 'absolute', 'top-4', 'left-0', 'right-0', 'ml-auto', 'mr-auto')
      } else if (payload.type === 'success') {
        alertEl.classList.add('bg-white', 'border', 'border-green-500', 'text-green-500', 'absolute', 'top-4', 'left-0', 'right-0', 'ml-auto', 'mr-auto')
      } else {
        alertEl.classList.add('bg-white', 'border', 'border-gray-500', 'text-gray-500', 'absolute', 'top-4', 'left-0', 'right-0', 'ml-auto', 'mr-auto')
      }
    }
  }
  alertEl.classList.remove('hidden');
  alertEl.classList.add('flex');
  setTimeout(() => {
    closeAlert(id);
  }, 10000);
}