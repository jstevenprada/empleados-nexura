$(document).ready(function () {
  $('#formEmpleado').validate({
    rules: {
      nombre: {
        required: true
      },
      email: {
        required: true,
        email: true
      },
      sexo: {
        required: true
      },
      area: {
        required: true
      },
      descripcion: {
        required: true
      },
      'roles[]': {
        required: true,
        minlength: 1
      }
    },
    messages: {
      nombre: {
        required: 'El campo nombre es requerido',
      },
      correo: {
        required: 'El campo nombre es requerido',
        email: 'Ingresa un correo válido'
      },
      sexo: {
        required: 'Por favor selecciona el sexo'
      },
      area: {
        required: 'Por favor selecciona un área'
      },
      descripcion: {
        required: 'El campo descripción es requerido'
      },
      'roles[]': {
        required: 'Selecciona al menos un rol',
        minlength: 'Selecciona al menos un rol'
      }
    },
    errorElement: 'div',
    errorClass: 'text-danger',
    highlight: function (element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
      $(element).removeClass('is-invalid');
    }
  });
});