(function(){
  const toggle = document.getElementById('togglePwd');
  const input = document.getElementById('password');
  if (toggle && input) toggle.addEventListener('click', function(){
    const showing = input.type === 'text';
    input.type = showing ? 'password' : 'text';
    toggle.textContent = showing ? 'Hiện' : 'Ẩn';
  });

  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(function(form){
    form.addEventListener('submit', function(e){
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    }, false);
  });
})();
