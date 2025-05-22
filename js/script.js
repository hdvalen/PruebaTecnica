document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registroForm');
  const alerta = document.getElementById('alerta');

  // Cargar países con AJAX
  fetch('php/obtener_pais.php')
    .then(res => res.json())
    .then(data => {
      const paisSelect = document.getElementById('pais');
      paisSelect.innerHTML = '<option value="">Selecciona un país</option>';
      data.forEach(pais => {
        const option = document.createElement('option');
        option.value = pais;
        option.textContent = pais;
        paisSelect.appendChild(option);
      });
    });

  // Validaciones en tiempo real
  const contrasenaInput = document.getElementById('contrasena');
  const confirmarInput = document.getElementById('confirmarContrasena');

  contrasenaInput.addEventListener('input', () => {
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    contrasenaInput.setCustomValidity(regex.test(contrasenaInput.value) ? '' : 'Inválida');
  });

  confirmarInput.addEventListener('input', () => {
    confirmarInput.setCustomValidity(confirmarInput.value === contrasenaInput.value ? '' : 'No coincide');
  });

  // Envío del formulario
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    if (!form.checkValidity()) {
      form.classList.add('was-validated');
      return;
    }

    const datos = new FormData(form);

    fetch('php/procesar_registro.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alerta.innerHTML = `
        <div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">
          ${data.mensaje}
        </div>
      `;
      if (data.status === 'success') {
        form.reset();
        form.classList.remove('was-validated');
      }
    })
    .catch(() => {
      alerta.innerHTML = `<div class="alert alert-danger">Error en la conexión.</div>`;
    });
  });
});
