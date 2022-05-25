window.addEventListener( 'DOMContentLoaded', (evt) => {
  document.body.classList.remove('no-js');

  const wrapper = document.querySelector('#customer_login');
  const login = wrapper.querySelector('.col-1');
  const register = wrapper.querySelector('.col-2');
  let current = null;

  login.id = 'login';
  register.id = 'register';

  toogleForms(false);
  window.addEventListener('hashchange', (evt) => toogleForms());

  function toogleForms (scroll = true ) {
    if ( '#register' === window.location.hash  ) {
      register.style.display = 'block';
      login.style.display = 'none';
      if (scroll) register.scrollIntoView({ behavior: 'smooth' });
    } else {
      login.style.display = 'block';
      register.style.display = 'none';
      if (scroll) login.scrollIntoView({ behavior: 'smooth' });
    }
  }
} );
