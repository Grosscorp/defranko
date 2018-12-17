import '../scss/index.scss';

/**
 *
 * Toggle class function
 *
 * @param element
 * @param className
 */
function toggleClass(element, className) {
  document.querySelector(element).classList.toggle(className);
}

// TODO: Find a better solution for navigation toggle on small screens
// Home page mobile menu toggle
document.querySelector('.hamburger').addEventListener('click', () => {
  toggleClass('.home-nav', 'show');
  toggleClass('.hamburger', 'is-active');
  toggleClass('.mobile-title', 'show');
});

// Mobile menu toggle
document.querySelector('.hamburger').addEventListener('click', () => {
  toggleClass('.nav', 'show');
  toggleClass('.hamburger', 'is-active');
});