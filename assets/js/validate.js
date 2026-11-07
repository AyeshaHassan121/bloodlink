document.addEventListener('DOMContentLoaded', function () {
  var PHONE = /^[0-9+\- ]{7,20}$/;

  document.querySelectorAll('form').forEach(function (form) {
    form.addEventListener('submit', function (ev) {
      var errors = [];

      form.querySelectorAll('input[required], select[required]').forEach(function (f) {
        if (f.value.trim() === '') { errors.push('Please fill in all required fields.'); }
      });

      ['phone', 'contact'].forEach(function (n) {
        var f = form.querySelector('input[name="' + n + '"]');
        if (f && f.value.trim() !== '' && !PHONE.test(f.value.trim())) {
          errors.push('Enter a valid phone number (7 to 20 digits, + and - allowed).');
        }
      });

      var pw = form.querySelector('input[name="password"]');
      var isSignup = form.querySelector('input[name="name"]') && form.querySelector('input[name="email"]');
      if (isSignup && pw && pw.value.length < 6) {
        errors.push('Password must be at least 6 characters.');
      }

      var box = form.querySelector('.js-error');
      if (errors.length) {
        ev.preventDefault();
        if (!box) {
          box = document.createElement('p');
          box.className = 'msg err js-error';
          form.insertBefore(box, form.firstChild);
        }
        box.textContent = errors.filter(function (e, i) { return errors.indexOf(e) === i; }).join(' ');
      } else if (box) {
        box.remove();
      }
    });
  });
});
