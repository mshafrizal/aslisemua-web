/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
// require('../../public/js/slick/slick.min')
// const Handlebars = require("handlebars");

const userMenuButton = document.getElementById('user-menu');
const userMenuDropdown = document.getElementById('user-menu-list');
const signOutButton = document.getElementById('sign-out-button');

if (userMenuButton && userMenuDropdown) {
    userMenuButton.addEventListener('click', () => {
        if (userMenuDropdown.classList.contains('hidden')) userMenuDropdown.classList.replace('hidden', 'block');
        else userMenuDropdown.classList.replace('block', 'hidden');
    });
}

if (signOutButton) {
    signOutButton.addEventListener('click', function () {
        localStorage.setItem('google_id', '');
        localStorage.setItem('gender', '');
        localStorage.setItem('district', '');
        localStorage.setItem('email_verified_at', '');
        localStorage.setItem('id', '');
        localStorage.setItem('address', '');
        localStorage.setItem('status', '');
        localStorage.setItem('level', '');
        localStorage.setItem('city', '');
        localStorage.setItem('name', '');
        localStorage.setItem('is_verified', '');
        localStorage.setItem('created_at', '');
        localStorage.setItem('updated_at', '');
        localStorage.setItem('postal_code', '');
        localStorage.setItem('phone_number', '');
        localStorage.setItem('is_first_time', '');
        localStorage.setItem('email', '');
        localStorage.setItem('token', '');
        window.location.href = '/sign-in'
    });
}
