document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registroForm");
  const alerta = document.getElementById("alerta");

  // Cargar países con AJAX
  fetch("php/obtener_paises.php")
    .then(res => res.json())
    .then(data => {
      const paisSelect = document.getElementById("pais");
      paisSelect.innerHTML = '<option value="">Selecciona un país</option>';
      data.forEach(pais => {
        const option = document.createElement("option");
        option.value = pais;
        option.textContent = pais;
        paisSelect.appendChild(option);
      });
    });

  // Validaciones en tiempo real
  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
  const contrasena = document.getElementById("contrasena");
  const confirmarContrasena = document.getElementById("confirmarContrasena");

  nombre.addEventListener("input", () => {
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,}$/;
    setValid(nombre, regex.test(nombre.value));
  });

  email.addEventListener("input", () => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    setValid(email, regex.test(email.value));
  });

  contrasena.addEventListener("input", () => {
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;
    setValid(contrasena, regex.test(contrasena.value));
  });

  confirmarContrasena.addEventListener("input", () => {
    setValid(confirmarContrasena, confirmarContrasena.value === contrasena.value);
  });

  function setValid(element, isValid) {
    if (isValid) {
      element.classList.remove("is-invalid");
      element.classList.add("is-valid");
    } else {
      element.classList.add("is-invalid");
      element.classList.remove("is-valid");
    }
  }

  // Envío por AJAX
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    fetch("php/procesar_registro.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        alerta.innerHTML = `<div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
        if (data.status === "success") {
          form.reset();
          document.querySelectorAll(".is-valid").forEach(el => el.classList.remove("is-valid"));
        }
      })
      .catch(error => {
        alerta.innerHTML = `<div class="alert alert-danger">Error en el servidor.</div>`;
        console.error("Error:", error);
      });
  });
});


// Validación de campos al enviar el formulario
form.addEventListener("submit", function (e) {
  e.preventDefault(); // Evita que se recargue la página

  const formData = new FormData(form); // Captura los datos del formulario

  fetch("php/procesar_registro.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      // Muestra mensaje de éxito o error
      alerta.innerHTML = `<div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;

      // Si fue exitoso, limpiamos el formulario
      if (data.status === "success") {
        form.reset();
        document.querySelectorAll(".is-valid").forEach(el => el.classList.remove("is-valid"));
      }
    })
    .catch(error => {
      alerta.innerHTML = `<div class="alert alert-danger">Error del servidor</div>`;
      console.error("Error:", error);
    });
});

