(function () {
  /**
   * Schema del formulario del register
   */
  var addTeamValues = {
    name: '',
    region: '',
  };

  /**
   * Schema del formulario del register
   */
  var addPlayerValues = {
    first_name: '',
    last_name: '',
    year_old: '',
    country: '',
  };

  /**
   * Schema del formulario del register
   */
  var reportTeamValues = {
    team1: '',
    team2: '',
    team3: '',
  };

  /**
   * Schema del formulario del register
   */
  var reportPlayerValue = {
    team: '',
  };

  /**
   * Almacenar valores de los formularios
   */

  var inputsValues = {};

  /**
   * Mostrar errores en los formularios
   */

  var showErrors = function (errors) {
    var errorsUnique = errors.reduce(function (unique, o) {
      if (!unique.some((obj) => obj.type === o.type)) {
        unique.push(o);
      }
      return unique;
    }, []);

    errorsUnique.forEach((error) => {
      var input = document.querySelector(`[name="${error.type}"]`);
      input.classList.add('error');
      var div = document.createElement('small');
      div.textContent = error.message;
      div.classList.add('invalid-feedback', 'd-block', 'm-0');
      input.parentNode.appendChild(div);
      var time = setTimeout(function () {
        input.classList.remove('error');
        div.remove();
        clearTimeout(time);
      }, 2000);
    });
  };

  /**
   * Captura valores de los formularios
   */

  var getValues = function (valuesCapture) {
    var inputs = document.querySelectorAll('input');
    var selects = document.querySelectorAll('select');
    inputsValues = valuesCapture;
    inputs.forEach(function (input) {
      inputsValues = {
        ...inputsValues,
        [input.name]: input.value,
      };

      input.addEventListener('input', function (e) {
        inputsValues = {
          ...inputsValues,
          [e.target.name]: e.target.value,
        };
      });
    });

    selects.forEach(function (select) {
      inputsValues = {
        ...inputsValues,
        [select.name]: select.value,
      };
      select.addEventListener('change', function (e) {
        inputsValues = {
          ...inputsValues,
          [e.target.name]: e.target.value,
        };
      });
    });
  };

  /**
   * Validar los datos del formulario de añadir Equipo
   */

  var validationAddTeam = function () {
    var formTeam = document.querySelector('.addTeam form');
    if (!formTeam) {
      return;
    }
    getValues(addTeamValues);
    formTeam.addEventListener('submit', function (e) {
      e.preventDefault();
      var errors = [];
      if (!inputsValues.name) {
        errors = [
          ...errors,
          { message: 'El nombre del equipo es requerido', type: 'name' },
        ];
      }

      if (
        inputsValues.name.trim().length < 3 ||
        inputsValues.name.trim().length > 50
      ) {
        errors = [
          ...errors,
          {
            message:
              'El nombre debe de tener al menos 3 caracteres y máximo 50',
            type: 'name',
          },
        ];
      }

      if (!inputsValues.region) {
        errors = [
          ...errors,
          { message: 'La región es requerida', type: 'region' },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formTeam.submit();
    });
  };

  /**
   * Validar los datos del formulario de añadir jugador
   */

  var validationAddPlayer = function () {
    var formPlayer = document.querySelector('.addPlayer form');
    if (!formPlayer) {
      return;
    }
    getValues(addPlayerValues);
    formPlayer.addEventListener('submit', function (e) {
      e.preventDefault();
      var errors = [];
      if (!inputsValues.first_name) {
        errors = [
          ...errors,
          { message: 'El primer nombre es requerido', type: 'first_name' },
        ];
      }

      if (
        inputsValues.first_name.trim().length < 3 ||
        inputsValues.first_name.trim().length > 10
      ) {
        errors = [
          ...errors,
          {
            message:
              'El nombre debe de tener al menos 3 caracteres y máximo 10',
            type: 'first_name',
          },
        ];
      }

      if (!inputsValues.last_name) {
        errors = [
          ...errors,
          { message: 'El primer nombre es requerido', type: 'last_name' },
        ];
      }

      if (
        inputsValues.last_name.trim().length < 3 ||
        inputsValues.last_name.trim().length > 10
      ) {
        errors = [
          ...errors,
          {
            message:
              'El nombre debe de tener al menos 3 caracteres y máximo 10',
            type: 'last_name',
          },
        ];
      }

      if (!inputsValues.year_old) {
        errors = [
          ...errors,
          { message: 'La edad es requerida', type: 'year_old' },
        ];
      }

      if (inputsValues.year_old < 18 || inputsValues.year_old > 36) {
        errors = [
          ...errors,
          {
            message: 'La edad minima debe ser de 18 y máximo 36',
            type: 'year_old',
          },
        ];
      }

      if (!inputsValues.country) {
        errors = [
          ...errors,
          { message: 'El pais es requerido', type: 'country' },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formPlayer.submit();
    });
  };

  /**
   * Validar los datos del formulario de reporte por equipo
   */

  var validationReportTeam = function () {
    var formReportTeam = document.querySelector('.reportTeam form');
    if (!formReportTeam) {
      return;
    }
    getValues(reportTeamValues);
    formReportTeam.addEventListener('submit', function (e) {
      e.preventDefault();
      var errors = [];

      if (!inputsValues.team1) {
        errors = [
          ...errors,
          { message: 'El equipo es requerido', type: 'team1' },
        ];
      }

      if (!inputsValues.team2) {
        errors = [
          ...errors,
          { message: 'El equipo es requerido', type: 'team2' },
        ];
      }

      if (!inputsValues.team3) {
        errors = [
          ...errors,
          { message: 'El equipo es requerido', type: 'team3' },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formReportTeam.submit();
    });
  };

  /**
   * Validar los datos del formulario de reporte por jugador
   */

  var validationReportPlayer = function () {
    var formReportPlayer = document.querySelector('.reportPlayer form');
    if (!formReportPlayer) {
      return;
    }
    getValues(reportPlayerValue);
    formReportPlayer.addEventListener('submit', function (e) {
      e.preventDefault();
      var errors = [];

      if (!inputsValues.team) {
        errors = [
          ...errors,
          { message: 'El equipo es requerido', type: 'team' },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formReportPlayer.submit();
    });
  };

  /**
   * Remover alerta despues de 3 segundos
   */

  var removeAlert = function () {
    var alert = document.querySelector('.alert:not(.alert-info)');
    if (!alert) {
      return;
    }

    var time = setTimeout(() => {
      alert.remove();
      clearInterval(time);
    }, 3000);
  };

  /**
   * Inicializar cada evento
   */

  var events = function () {
    removeAlert();
    validationAddPlayer();
    validationAddTeam();
    validationReportTeam();
    validationReportPlayer();
  };

  /**
   * Inicializar Todos los eventos
   */

  var init = function () {
    events();
  };

  /**
   * Inicializar los eventos cuando el DOM este cargado
   */

  window.addEventListener('DOMContentLoaded', function () {
    init();
  });
})();
