window.addEventListener( 'DOMContentLoaded', (evt) => {
  document.body.classList.remove('no-js');

  const wrapper = document.querySelector('#customer_login');
  const login = wrapper.querySelector('.col-1');
  const register = wrapper.querySelector('.col-2');

  login.id = 'login';
  register.id = 'register';

  toogleForms(false);
  window.addEventListener('hashchange', (evt) => toogleForms());

  function toogleForms (scroll = true ) {
    const current = '#register' === window.location.hash ? register : login;
    const other = login === current ? register : login;
    current.style.display = 'block';
    other.style.display = 'none';
    if (scroll) current.scrollIntoView({ behavior: 'smooth' });
  }
} );
