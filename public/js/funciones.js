$("#date_input").on("change", function () {
  $(this)
    .css("color", "rgba(0,0,0,0)")
    .siblings(".datepicker_label")
    .css({
      "text-align": "center",
      position: "absolute",
      left: "10px",
      top: "14px",
      width: $(this).width(),
    })
    .text(
      $(this).val().length == 0 ?
      "" :
      $.datepicker.formatDate(
        $(this).attr("dateformat"),
        new Date($(this).val())
      )
    );
});

function notificacionCorreo() {
  Swal.fire(
    "Completado!",
    "Se ha enviado un correo electrónico para restaurar su contraseña",
    "success"
  );
}

//--------------- DATATABLES ------------------------

// Datatable Usuarios
$(document).ready(function () {
  $("#dtUsuarios")
    .addClass(
      "table table-sm table-hover table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: ["copy", "excel", "csv"],
    });
});
// Datatable horas extras
$(document).ready(function () {
  $("#dthorasExtras")
    .addClass(
      "table table-sm table-hover table table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: ["copy", "excel", "csv"],
    });
});
// Datatable Presupuestos
$(document).ready(function () {
  $("#dtPresupuestos")
    .addClass(
      "table table-sm table-hover table table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: [],
    });
});
// Datatable cargos
$(document).ready(function () {
  $("#dtCargos")
    .addClass(
      "table table-sm table-hover table table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: ["copy", "excel", "csv"],
    });
});

// Datatable Tipo Horas
$(document).ready(function () {
  $("#dtTipoHoras")
    .addClass(
      "table table-sm table-hover table table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: ["copy", "excel", "csv"],
    });
});

// Datatable Fechas
$(document).ready(function () {
  $("#dtFechas")
    .addClass(
      "table table-sm table-hover table table table-bordered"
    )
    .dataTable({
      language: {
        url: "DataTables/Spanish.json",
      },
      responsive: true,
      dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
      buttons: ["copy", "excel", "csv"],
    });
});
//--------- MODULO DE USUARIOS --------------------

// Función enviar correo de restaurar contraseña
function restaurarContrasena() {
  var url = "restaurar_contrasena";
  $correo = $("#email_restaurar").val();


  var obj = new Object();
  obj.Correo = $correo;


  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#email_restaurar").val("");
    $("#modalRestaurar").modal("hide"); //ocultamos el modal
    console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha enviado un correo al email para restablecer su contraseña",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al enviar email, " + data + ".", "error");
    }
  });
}

// Función para el modal de detalles de la cuenta iniciada
function detallesUsuarioSesion(id) {
  var url = "usuarios/detalle";
  $.post(url + "/" + id).done(function (data) {
    // console.log(data);
    $("#documento_user").val(data.usuario.documento);
    $("#nombres_user").val(data.usuario.nombres);
    $("#apellidos_user").val(data.usuario.apellidos);
    $("#cargo_user").val(data.cargo.nombre);
    $("#centro_user").val(data.usuario.centro);
    $("#regional_user").val(data.usuario.regional);
    $("#sueldo_user").val(data.cargo.sueldo);
    $("#email_user").val(data.usuario.email);
    $("#telefono_user").val(data.usuario.telefono);
    $("#tipoDocumento_user").val(data.usuario.tipo_documento);
    $("#updateSesion").attr(
      "onclick",
      "updateUsuarioSesion(" + data.usuario.id + ")"
    );
  });
}

// Función para actualizar usuario sesion ajax
function updateUsuarioSesion(id) {
  var url = "usuarios/actualizar";
  $documento = $("#documento_user").val();
  $nombres = $("#nombres_user").val();
  $apellidos = $("#apellidos_user").val();
  $cargo = $("#cargo_user").val();
  $centro = $("#centro_user").val();
  $regional = $("#regional_user").val();
  $sueldo = $("#sueldo_user").val();
  $correo = $("#email_user").val();
  $telefono = $("#telefono_user").val();
  $tipoDocumento = $("#tipoDocumento_user").val();

  var obj = new Object();
  obj.Id = id;
  obj.Documento = $documento;
  obj.Nombres = $nombres;
  obj.Apellidos = $apellidos;
  obj.Cargo = $cargo;
  obj.Regional = $regional;
  obj.Centro = $centro;
  obj.Sueldo = $sueldo;
  obj.Correo = $correo;
  obj.Telefono = $telefono;
  obj.TipoDocumento = $tipoDocumento;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#documento_user_d").val(data.documento);
    $("#modalCuenta").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se editado el Usuario correctamente",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al el editar Usuario, " + data + ".", "error");
    }
    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Muestra la información del cargo del usuario de la cuenta iniciada
function detallesUsuarioCargoSesion(id) {
  var url = "usuarios/detalleCargo";
  $.post(url + "/" + id).done(function (data) {
    // console.log(data.cargo);
    $("#cargov_s").val(data.cargo.nombre);
    $("#sueldov_s").val(data.cargo.sueldo);
    $("#diurna_s").val(data.cargo.valor_diurna);
    $("#nocturna_s").val(data.cargo.valor_nocturna);
    $("#dominical_s").val(data.cargo.valor_dominical);
    $("#nocturno_s").val(data.cargo.valor_recargo);
    // $('#cargov').val('');
    // $("#updatecv_s").attr('onclick', 'cambiarCargo(' + data.usuario.id + ')');
  });
}

// Función para el modal de detalles
function detallesUsuario(id) {
  var url = "usuarios/detalle";
  $("#documento_user_d").val("");
  $("#nombres_user_d").val("");
  $("#apellidos_user_d").val("");
  $("#cargo_user_d").val("");
  $("#centro_user_d").val("");
  $("#regional_user_d").val("");
  $("#sueldo_user_d").val("");
  $("#email_user_d").val("");
  $("#telefono_user_d").val("");
  $("#tipoDocumento_user_d").val("");
  $.post(url + "/" + id).done(function (data) {
    // console.log(data);
    $("#documento_user_d").val(data.usuario.documento);
    $("#nombres_user_d").val(data.usuario.nombres);
    $("#apellidos_user_d").val(data.usuario.apellidos);
    $("#cargo_user_d").val(data.cargo.nombre);
    $("#centro_user_d").val(data.usuario.centro);
    $("#regional_user_d").val(data.usuario.regional);
    $("#sueldo_user_d").val(data.cargo.sueldo);
    $("#email_user_d").val(data.usuario.email);
    $("#telefono_user_d").val(data.usuario.telefono);
    $("#tipoDocumento_user_d").val(data.usuario.tipo_documento);
    $("#update").attr("onclick", "updateUsuario(" + data.usuario.id + ")");
  });
}

// Función para actualizar usuario ajax
function updateUsuario(id) {
  var url = "usuarios/actualizar";
  $documento = $("#documento_user_d").val();
  $nombres = $("#nombres_user_d").val();
  $apellidos = $("#apellidos_user_d").val();
  $cargo = $("#cargo_user_d").val();
  $centro = $("#centro_user_d").val();
  $regional = $("#regional_user_d").val();
  $sueldo = $("#sueldo_user_d").val();
  $correo = $("#email_user_d").val();
  $telefono = $("#telefono_user_d").val();
  $tipoDocumento = $("#tipoDocumento_user_d").val();

  var obj = new Object();
  obj.Id = id;
  obj.Documento = $documento;
  obj.Nombres = $nombres;
  obj.Apellidos = $apellidos;
  obj.Cargo = $cargo;
  obj.Regional = $regional;
  obj.Centro = $centro;
  obj.Sueldo = $sueldo;
  obj.Correo = $correo;
  obj.Telefono = $telefono;
  obj.TipoDocumento = $tipoDocumento;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetalle").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se editado el Usuario correctamente",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al el editar Usuario, " + data + ".", "error");
    }
    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}
// Muestra la información del cargo del usuario
function detallesUsuarioCargo(id) {
  var url = "usuarios/detalleCargo";
  $("#cargov_d").val("");
  $("#sueldov_d").val("");
  $("#diurna_d").val("");
  $("#nocturna_d").val("");
  $("#dominical_d").val("");
  $("#nocturno_d").val("");
  $.post(url + "/" + id).done(function (data) {
    // console.log(data.cargo);
    $("#cargov_d").val(data.cargo.nombre);
    $("#sueldov_d").val(data.cargo.sueldo);
    $("#diurna_d").val(data.cargo.valor_diurna);
    $("#nocturna_d").val(data.cargo.valor_nocturna);
    $("#dominical_d").val(data.cargo.valor_dominical);
    $("#nocturno_d").val(data.cargo.valor_recargo);
    $("#cargov").val("");
    $("#updatecv").attr("onclick", "cambiarCargo(" + data.usuario.id + ")");
  });
}

// Cambia el cargo de un usuario, solo puede tener uno vigente por usuario
function cambiarCargo(id) {
  var url = "usuarios/cambiarCargo";

  $cambioCargo = $("#cargov").val();

  var obj = new Object();
  obj.Id = id;
  obj.Cargo = $cambioCargo;
  var datos = JSON.stringify(obj);
  // console.log(datos);

  $.post(url + "/" + datos).done(function (data) {
    $("#modalCargo").modal("hide"); //ocultamos el modal
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se cambio el cargo del usuario correctamente.",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al cambiar el cargo, " + data, "error");
    }

    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Activa el estado del Usuario
function activar(id) {
  var url = "usuarios/activar";
  $.post(url + "/" + id).done(function (data) {
    Swal.fire("Completado!", "el Usuario se ACTIVO correctamente", "success");

    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Inactiva el estado del usuario
function inactivar(id) {
  var url = "usuarios/inactivar";
  $.post(url + "/" + id).done(function (data) {
    Swal.fire("Completado!", "el Usuario se INACTIVO correctamente", "success");

    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: ".DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Guarda usuario en la base de datos
function crearUsuario() {
  var url = "registrar/guardar";
  $documento = $("#documento_user_g").val();
  $nombres = $("#nombres_user_g").val();
  $apellidos = $("#apellidos_user_g").val();
  $correo = $("#email_user_g").val();
  $telefono = $("#telefono_user_g").val();
  $tipoDocumento = $("[name = 'select_tipoDocumento_g']")
    .children("option:selected")
    .val();
  $rol = $("[name = 'select_rol_g']").children("option:selected").val();
  $centro = $("[name = 'select_centro_g']").children("option:selected").val();
  $regional = $("[name = 'select_regional_g']")
    .children("option:selected")
    .val();
  $cargo = $("[name = 'select_cargo_g']").children("option:selected").val();

  var obj = new Object();
  obj.Documento = $documento;
  obj.Nombres = $nombres;
  obj.Apellidos = $apellidos;
  obj.Correo = $correo;
  obj.Telefono = $telefono;
  obj.TipoDocumento = $tipoDocumento;
  obj.Rol = $rol;
  obj.Centro = $centro;
  obj.Regional = $regional;
  obj.cargo = $cargo;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalRegistrarUsuario").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha guardado exitosamente a " + $nombres,
        "success"
      );
    } else {
      Swal.fire(
        "Error!",
        "Error al guardar el Usuario, " + data + ".",
        "error"
      );
    }
    $("#table_div_user").load(" #dtUsuarios", function () {
      $("#dtUsuarios")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: ".DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}
// Cambia la clave del usuario
$("#passReset").click(function () {
  var url = "passreset";
  var id = $("#userid").val();
  var pass1 = $("#password").val();
  var pass2 = $("#confirmPassword").val();
  var dato;
  if (pass1 == pass2) {
    if (pass1 != null && pass1.trim() != "" && pass1.length >= 6) {
      var obj = new Object();
      obj.id = id;
      obj.contraseña = pass1;
      var data = JSON.stringify(obj);
      $.post(url + "/" + data, function (data2) {
        dato = JSON.parse(data2);
      }).done(function () {
        $("#modalLoginAvatar").modal("hide"); //ocultamos el modal
        Swal.fire(
          "Completado!",
          "El usuario " + dato.nombres + " ha cambiado su contraseña",
          "success"
        );
      });
    } else {
      Swal.fire(
        "Error!",
        "La clave debe tener mínimo 6 caracteres y no se aceptan espacios en blanco",
        "error"
      );
    }
  } else {
    Swal.fire("Error!", "Las claves deben coincidir", "error");
  }
});

// ----------MODULO CARGOS----------------

// Función para el modal de detalles
function detallesCargo(id) {
  $("#nombre_cargo_d").val("");
  $("#sueldo_cargo_d").val("");
  $("#diurna_cargo_d").val("");
  $("#nocturna_cargo_d").val("");
  $("#dominical_cargo_d").val("");
  $("#nocturno_cargo_d").val("");
  var url = "cargos/detalle";
  $.post(url + "/" + id).done(function (data) {
    $("#nombre_cargo_d").val(data.nombre);
    $("#sueldo_cargo_d").val(data.sueldo);
    $("#diurna_cargo_d").val(data.valor_diurna);
    $("#nocturna_cargo_d").val(data.valor_nocturna);
    $("#dominical_cargo_d").val(data.valor_dominical);
    $("#nocturno_cargo_d").val(data.valor_recargo);
    $("#updateCargo").attr("onclick", "updateCargo(" + data.id + ")");
  });
}

// Función para actualizar cargo ajax
function updateCargo(id) {
  var url = "cargos/update";

  $nombre = $("#nombre_cargo_d").val();
  $sueldo = $("#sueldo_cargo_d").val();
  $diurna = $("#diurna_cargo_d").val();
  $nocturna = $("#nocturna_cargo_d").val();
  $dominical = $("#dominical_cargo_d").val();
  $recargo = $("#nocturno_cargo_d").val();

  var obj = new Object();
  obj.Id = id;
  obj.Nombre = $nombre;
  obj.Sueldo = $sueldo;
  obj.Diurna = $diurna;
  obj.Nocturna = $nocturna;
  obj.Dominical = $dominical;
  obj.Recargo = $recargo;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetalleCargo").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire("Completado!", "Se editado el Cargo correctamente", "success");
    } else {
      Swal.fire("Error!", "Error al editar Cargo, " + data + ".", "error");
    }
    $("#table_div_cargos").load(" #dtCargos", function () {
      $("#dtCargos")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}
// Guarda la información de un cargo nuevo
function crearCargo() {
  var url = "cargos/guardar";
  $nombre = $("#nombre_cargo_g").val();
  $sueldo = $("#sueldo_cargo_g").val();
  $diurna = $("#diurna_cargo_g").val();
  $nocturna = $("#nocturna_cargo_g").val();
  $dominical = $("#dominical_cargo_g").val();
  $nocturno = $("#nocturno_cargo_g").val();

  var obj = new Object();
  obj.Nombre = $nombre;
  obj.Sueldo = $sueldo;
  obj.Diurna = $diurna;
  obj.Nocturna = $nocturna;
  obj.Dominical = $dominical;
  obj.Nocturno = $nocturno;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalRegistrarCargo").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (Number(data)) {
      $("#nombre_cargo_g").val("");
      $("#sueldo_cargo_g").val("");
      $("#diurna_cargo_g").val("");
      $("#nocturna_cargo_g").val("");
      $("#dominical_cargo_g").val("");
      $("#nocturno_cargo_g").val("");
      Swal.fire(
        "Completado!",
        "Se ha Guardado el Cargo correctamente",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al Guardar Cargo, " + data + ".", "error");
    }
    $("#table_div_cargos").load(" #dtCargos", function () {
      $("#dtCargos")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// -------------- MODULO DE SOLICITUDES -----------

// Guarda las horas extras
function guardarSolicitud() {
  var url = "solicitud/guardar";
  $funcionario = $("#funcionario_cargo_user_s").val();
  $año = $("[name = 'año_solicitud']").children("option:selected").val();
  $mes = $("[name = 'mes_solicitud']").children("option:selected").val();
  $tipoHora = $("[name = 'tipohoras_s']").children("option:selected").val();
  $horaInicio = $("#hora_inicio_s").val();
  $horaFin = $("#hora_fin_s").val();
  $horas = $("#horas_s").val();
  $actividades = $("#actividades_s").val();

  var obj = new Object();
  obj.Id = $funcionario;
  obj.Año = $año;
  obj.Mes = $mes;
  obj.Inicio = $horaInicio;
  obj.Fin = $horaFin;
  obj.Horas = $horas;
  obj.TipoHora = $tipoHora;
  obj.Actividad = $actividades;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    // console.log(data);
    if (data == 1) {
      Swal.fire("Completado!", "Se ha Guardado la Solicitud", "success");
      $("#tipohoras_h").val("");
      $("#hora_inicio_s").val("");
      $("#hora_fin_s").val("");
      $("#horas_s").val("");
      $("#actividades_s").val("");
      $("#justificacion").val("");
      $("#mes_s").val("");
      $("#año_s").val("");
      $("#tipohoras_s").val("");
    } else {
      Swal.fire("Error!", "Error al Guardar Solicitud, " + data + ".", "error");
    }
  });
}

// Modal de detalles de solicitud
function detallesSolicitud(id) {
  var url = "solicitudes/detalles";
  $("#funcionario_s").val("");
  $("#cargo_s").val("");
  $("#th_solicitud_s").val("");
  $("#año_solicitud_s").val("");
  $("#mes_solicitud_sd").val("");
  $("#hora_inicio_s").val("");
  $("#hora_fin_s").val("");
  $("#valor_total_s").val("");
  $("#valor_hora_s").val("");
  $("#horas_s").val("");
  $("#horas_restantes_s").val("");
  $("#autorizado_s").val("");
  $("#actividades_s").val("");
  $.post(url + "/" + id).done(function (data) {
    $("#funcionario_s").val(data.nombres + " " + data.apellidos);
    $("#cargo_s").val(data.nombre);
    $("#cargo_user_s").val(data.cargo_user_id);
    $("#th_solicitud_s").val(data.tipo_hora_id);
    $("#año_solicitud_s").val(data.año);
    $("#mes_solicitud_sd").val(data.mes);
    $("#hora_inicio_s").val(data.hora_inicio);
    $("#hora_fin_s").val(data.hora_fin);
    $("#valor_total_s").val(data.valor_total);
    $("#valor_hora_s").val(data.valor_hora);
    $("#horas_s").val(data.total_horas);
    $("#horas_restantes_s").val(data.horas_restantes);
    $("#autorizado_s").val(data.autorizacion);
    $("#actividades_s").val(data.actividades);
    $("#update_solicitud").attr("onclick", "updateSolicitud(" + id + ")");
  });
}

// Función para actualizar solicitud
function updateSolicitud(id) {
  var url = "solicitudes/update";

  $cargo_user = $("#cargo_user_s").val();
  $th = $("#th_solicitud_s").val();
  $año = $("#año_solicitud_s").val();
  $mes = $("#mes_solicitud_sd").val();
  $inicio = $("#hora_inicio_s").val();
  $fin = $("#hora_fin_s").val();
  $horas = $("#horas_s").val();
  $actividades = $("#actividades_s").val();

  var obj = new Object();
  obj.Id = id;
  obj.CargoUser = $cargo_user;
  obj.Th = $th;
  obj.Año = $año;
  obj.Mes = $mes;
  obj.Inicio = $inicio;
  obj.Fin = $fin;
  obj.Horas = $horas;
  obj.Actividades = $actividades;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetallesSolicitud").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha editado la solicitud correctamente",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al editar la fecha, " + data + ".", "error");
    }
    $("#div_horas").load(" #dthorasExtras", function () {
      $("#dthorasExtras")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Autoriza la solicitud
function autorizarSolicitud(id) {
  // console.log(id);
  // console.log(idUser);
  Swal.fire({
    title: "¿Deseas Autorizar esta solicitud?",
    text: "No se puede revertir esta acción",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Autorizar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      var url = "solicitudes/autorizar";
      var obj = new Object();
      obj.Id = id;
      var datos = JSON.stringify(obj);
      $.post(url + "/" + datos).done(function (data) {
        if (data == 1) {
          Swal.fire("Completado!", "Se ha autorizado la solicitud", "success");
          $("#botonSolicitud").html("");
          var boton =
            `<button style="margin-right:1%"  data-toggle="modal" data-target="#modalDetallesSolicitud" class="btn btn-success" onclick="detallesSolicitud(` +
            id +
            `);">Detalles de Solicitud</button> <button class="btn btn-primary"> Autorizado </button>`;
          $("#botonSolicitud").append(boton);
        } else {
          Swal.fire("Error!", "Error al autorizar; " + data + ".", "error");
        }
      });
    }
  });
}

// ------------MODULO DE HORAS EXTRAS ----------------

// Función para mostrar la solicitud
function selectSolicitud() {
  var seleccion = document.getElementById("seleccionar_usuario");
  var id = seleccion.options[seleccion.selectedIndex].value;
  var url = "solicitudes";
  $.post(url + "/" + id).done(function (data) {
    var t = $("#dthorasExtras").DataTable();
    t.clear().draw();
    $("#select_presupuesto").html("");
    if (data.length > 0) {
      var divSolicitud = `<div class="col-md-6">
      <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccionar Solicitud</label>
      <select class="form-control validate" id="seleccionar_solicitud" name="" onchange="tabla_de_horas();">
      <option value="0"></option>`;
      $("#select_presupuesto").html("");

      for (var i = 0; i < data.length; i++) {
        var options =
          `<option value="` +
          data[i].id +
          `">` +
          data[i].actividades +
          `/ ` +
          data[i].presupuesto.año +
          `-` +
          data[i].presupuesto.mes +
          ` / ` +
          data[i].tipo_horas.nombre_hora +
          `</option>`;
        var divSolicitud = divSolicitud + options;
      }

      divSolicitud =
        divSolicitud +
        `</select></div><div style="margin-top:2%"id="botonSolicitud" class="col-md-6"></div>`;
      $("#select_presupuesto").append(divSolicitud);
    } else {
      var divSolicitud = `<div class="col-md-6"><p>El cargo vigente del usuario no tiene ninguna solicitud.</p></div>`;
      $("#select_presupuesto").append(divSolicitud);
    }
  });
}

// Carga la tabla de horas
function tabla_de_horas() {
  var seleccion = document.getElementById("seleccionar_solicitud");
  var id = seleccion.options[seleccion.selectedIndex].value;

  $("#botonSolicitud").html("");
  var url = "horas/tabla";
  var obj = new Object();
  obj.Id = id;

  var datos = JSON.stringify(obj);
  $.post(url + "/" + datos).done(function (data) {
    if (data.solicitud == null) {
      var t = $("#dthorasExtras").DataTable();
      t.clear().draw();
    } else {

      var boton = 0;
      var boton =
        `<button style="margin-right:1%"  data-toggle="modal" data-target="#modalDetallesSolicitud" class="btn btn-success" onclick="detallesSolicitud(` +
        data.solicitud.id +
        `);">Detalles de Solicitud</button>`;
      if (data.solicitud.autorizacion == 0) {
        var boton =
          boton +
          `<button class="btn btn-danger" onclick="autorizarSolicitud(` + data.solicitud.id + `)"> No Autorizado </button>`;
      }
      if (data.solicitud.autorizacion != 0) {
        var boton =
          boton +
          `<button class="btn btn-primary"> Autorizado </button>`;
      }
      $("#botonSolicitud").append(boton);
      var t = $("#dthorasExtras").DataTable();
      t.clear().draw();
      // console.log(data);
      for (var i = 0; i < data.horas.length; i++) {
        var botonEditar =
          `<button class="btn btn-success" data-toggle="modal" data-target="#modalDetallesHora" onclick="detallesHora(` +
          data.horas[i].id +
          `)">Detalles</button>`;
        t.row
          .add([
            data.horas[i].nombres + " " + data.horas[i].apellidos,
            data.horas[i].nombre,
            data.horas[i].fecha,
            data.horas[i].hi_registrada,
            data.horas[i].hf_registrada,
            data.horas[i].nombre_hora,
            botonEditar,
          ])
          .draw(false);
      }
    }
  });
}

// Guarda las horas extras
function guardarHoras() {
  var url = "horas/guardar";
  $funcionario = $("#funcionario_cargo_user").val();
  $fecha = $("#date").val();
  $solicitud = $("[name = 'solicitud_h']").children("option:selected").val();
  $horaInicio = $("#hora_inicio").val();
  $horaFin = $("#hora_fin").val();
  $horasT = $("#horas_trabajadas").val();

  var obj = new Object();
  obj.Id = $funcionario;
  obj.Fecha = $fecha;
  obj.Inicio = $horaInicio;
  obj.Fin = $horaFin;
  obj.Solicitud = $solicitud;
  obj.Horas = $horasT;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se han Guardado las Horas Extras correctamente",
        "success"
      );
      $("#tipohoras_h").val("");
      $("#date").val("");
      $("#alt").val("");
      $("#hora_inicio").val("");
      $("#hora_fin").val("");
      $("#justificacion").val("");
    } else {
      Swal.fire(
        "Error!",
        "Error al Guardar Horas extras, " + data + ".",
        "error"
      );
    }
  });
}

// Función para mostrar la solicitud
function inputsRegistrarHora() {
  var seleccion = document.getElementById("solicitud_h");
  var id = seleccion.options[seleccion.selectedIndex].value;
  var url = "solicitudes/detalles";
  $("#inputs_solicitud").html("");
  $.post(url + "/" + id).done(function (data) {
    $("#inputs_solicitud").html("");
    var inputs = `<div class="col-md-6">
      <label data-error="wrong" data-success="right" for="orangeForm-name">Hora Inicio Solicitada</label>
      <input readonly class="form-control bfh-timepicker" type="time" id="hora_inicio_solicitada">
      </div>
      <div class="col-md-6">
      <label data-error="wrong" data-success="right" for="orangeForm-name">Hora Fin Solicitada</label>
      <input readonly class="form-control bfh-timepicker" type="time" id="hora_fin_solicitada">
      </div>`;
    $("#inputs_solicitud").append(inputs);
    $("#hora_inicio_solicitada").val(data.hora_inicio);
    $("#hora_fin_solicitada").val(data.hora_fin);

  });
}

// Función para el modal de detalles
function detallesHora(id) {
  var url = "horas/detalle";
  $("#funcionario_h").val("");
  $("#cargo_h").val("");
  $("#fecha_h").val("");
  $("#th_h").val("");
  $("#hora_inicio_h").val("");
  $("#hora_fin_h").val("");
  $("#horas_h").val("");
  $("#valor_hora_h").val("");
  $("#valor_total_h").val("");
  $.post(url + "/" + id).done(function (data) {
    // console.log(data);
    $("#funcionario_h").val(data.user.nombres + " " + data.user.apellidos);
    $("#cargo_h").val(data.cargo.nombre);
    $("#fecha_h").val(data.hora.fecha);
    $("#th_h").val(data.tipoHora.id);
    $("#hora_inicio_h").val(data.hora.hi_registrada);
    $("#hora_fin_h").val(data.hora.hf_registrada);
    $("#horas_h").val(data.hora.horas_trabajadas);
    $("#valor_hora_h").val(data.valor);
    $("#valor_total_h").val(data.valorTotal);
    $("#update_h").attr("onclick", "updateHoras(" + data.hora.id + ")");
  });
}

// Función para actualizar horas ajax
function updateHoras(id) {
  var url = "horas/update";
  $fecha = $("#fecha_h").val();
  $horas = $("#horas_h").val();
  $hora_inicio = $("#hora_inicio_h").val();
  $hora_fin = $("#hora_fin_h").val();
  // console.log($th);
  var obj = new Object();
  obj.Id = id;
  obj.Fecha = $fecha;
  obj.Inicio = $hora_inicio;
  obj.Horas = $horas;
  obj.Fin = $hora_fin;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetallesHora").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha editado correctamente las Horas Extras ",
        "success"
      );
      $("#div_horas").load(" #dthorasExtras", function () {
        $("#dthorasExtras")
          .addClass("table table-bordered")
          .dataTable({
            language: {
              url: "DataTables/Spanish.json",
            },
            destroy: false,
            responsive: true,
            dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
            buttons: ["copy", "excel", "csv"],
          });
      });
    } else {
      Swal.fire("Error!", "Error al editar horas; " + data + ".", "error");
    }
  });
}

// ---------- MODULO TIPO DE HORAS ---------

// Función para el modal de detalles
function detallesTipoHora(id) {
  var url = "tipo_horas/detalle";
  $("#nombre_hora_t").val("");
  $("#hora_inicio_t").val("");
  $("#hora_fin_t").val("");
  $.post(url + "/" + id).done(function (data) {
    $("#nombre_hora_t").val(data.nombre_hora);
    $("#hora_inicio_t").val(data.hora_inicio);
    $("#hora_fin_t").val(data.hora_fin);
    $("#updateTipoHora").attr("onclick", "updateTipoHora(" + data.id + ")");
  });
}

// Función para actualizar tipo de hora
function updateTipoHora(id) {
  var url = "tipo_horas/update";
  $nombre = $("#nombre_hora_t").val();
  $inicio = $("#hora_inicio_t").val();
  $fin = $("#hora_fin_t").val();

  var obj = new Object();
  obj.Id = id;
  obj.Nombre = $nombre;
  obj.Inicio = $inicio;
  obj.Fin = $fin;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetalleTipoHora").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha editado el Tipo de Hora correctamente",
        "success"
      );
    } else {
      Swal.fire(
        "Error!",
        "Error al editar el Tipo de Hora, " + data + ".",
        "error"
      );
    }
    $("#table_div_tipoHoras").load(" #dtTipoHoras", function () {
      $("#dtTipoHoras")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// ----------- MODULO DE FECHAS ------------------

// Función para el modal de detalles
function detallesFecha(id) {
  $("#nombre_fecha_t").val("");
  $("#fecha_inicio_t").val("");
  $("#fecha_fin_t").val("");
  var url = "fechas_especiales/detalle";
  $.post(url + "/" + id).done(function (data) {
    $("#nombre_fecha_t").val(data.descripcion);
    $("#fecha_inicio_t").val(data.fecha_inicio);
    $("#fecha_fin_t").val(data.fecha_fin);
    $("#updateFecha").attr("onclick", "updateFecha(" + data.id + ")");
  });
}

// Función para actualizar fecha
function updateFecha(id) {
  var url = "fechas_especiales/update";
  $nombre = $("#nombre_fecha_t").val();
  $inicio = $("#fecha_inicio_t").val();
  $fin = $("#fecha_fin_t").val();

  var obj = new Object();
  obj.Id = id;
  obj.Nombre = $nombre;
  obj.Inicio = $inicio;
  obj.Fin = $fin;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetalleFecha").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha editado la fecha correctamente correctamente",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al editar la fecha, " + data + ".", "error");
    }
    $("#table_div_fechas").load(" #dtFechas", function () {
      $("#dtFechas")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: "DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Guarda la fecha
function saveFecha() {
  var url = "fechas_especiales/save";
  $nombre = $("#nombre_fecha_g").val();
  $inicio = $("#fecha_inicio_g").val();
  $fin = $("#fecha_fin_g").val();

  var obj = new Object();
  obj.Nombre = $nombre;
  obj.Inicio = $inicio;
  obj.Fin = $fin;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalRegistrarFecha").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      $("#nombre_fecha_g").val("");
      $("#fecha_inicio_g").val("");
      $("#fecha_fin_g").val("");
      Swal.fire(
        "Completado!",
        "Se ha guardado exitosamente la fecha.",
        "success"
      );
    } else {
      Swal.fire("Error!", "Error al guardar la fecha; " + data + ".", "error");
    }
    $("#table_div_fechas").load(" #dtFechas", function () {
      $("#dtFechas")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: ".DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// ----------- MODULO DE PRESUPUESTO ------------------

// Guarda el presupuesto
function savePresupuesto() {
  var url = "presupuesto/save";
  $presupuesto = $("#presupuesto_p").val();
  $mes = $("#mes_presupuesto").val();
  $año = $("#año_p").val();
  // console.log($mes);

  var obj = new Object();
  obj.Presupuesto = $presupuesto;
  obj.Mes = $mes;
  obj.Año = $año;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalRegistrarPresupuesto").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      $("#presupuesto_p").val("");
      $("#mes_p").val("");
      $("#año_p").val("");
      Swal.fire(
        "Completado!",
        "se ha guardado exitosamente el presupuesto.",
        "success"
      );
    } else {
      Swal.fire(
        "Error!",
        "Error al guardar el presupuesto; " + data + ".",
        "error"
      );
    }
    $("#div_presupuesto").load(" #dtPresupuestos", function () {
      $("#dtPresupuestos")
        .addClass("table table-bordered")
        .dataTable({
          language: {
            url: ".DataTables/Spanish.json",
          },
          destroy: true,
          responsive: true,
          dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
          buttons: ["copy", "excel", "csv"],
        });
    });
  });
}

// Carga la tabla de presupuesto y muestra las horas que han usado dicho presupuesto
function tabla_de_presupuestos() {
  var seleccion = document.getElementById("seleccionar_presupuesto");
  var id = seleccion.options[seleccion.selectedIndex].value;
  var url = "presupuesto/tabla";
  var boton_presupuesto =
    `<div class="col-md-12">
    <button class="btn btn-success" data-toggle="modal" data-target="#modalDetallePresupuesto" 
    onclick="detallesPresupuesto(` +
    id +
    `)">Detalles de presupuesto</button>
    </div>
    <div style="margin-top:2%" class="col-md-6"><label data-error="wrong" data-success="right" for="orangeForm-name">Presupuesto restante</label>
    <input readonly type="text" id="presupuesto_restantes" class="form-control validate"></div>`;

  $.post(url + "/" + id).done(function (data) {
    var t = $("#dtPresupuestos").DataTable();
    t.clear().draw();
    if (id > 0) {
      $("#informacion_presupuesto").html("");
      $("#informacion_presupuesto").append(boton_presupuesto);
      $("#presupuesto_restantes").val(data.restante);
    } else {
      $("#informacion_presupuesto").html("");
    }
    $("#cuerpo_presupuesto").html("");
    // console.log(data);
    var t = $("#dtPresupuestos").DataTable();
    for (var i = 0; i < data.solicitudes.length; i++) {
      var boton =
        `<button class="btn btn-success" onclick="detallesSolicitudP(` +
        data.solicitudes[i].id +
        `)" data-toggle="modal" data-target="#modalDetallesSolicitudPresupuesto">Detalles
      </button>`;
      t.row
        .add([
          data.solicitudes[i].nombres + " " + data.solicitudes[i].apellidos,
          data.solicitudes[i].nombre,
          data.solicitudes[i].total_horas,
          data.solicitudes[i].hora_inicio,
          data.solicitudes[i].hora_fin,
          data.solicitudes[i].nombre_hora,
          boton,
        ])
        .draw(false);
    }
  });
}

// Modal de detalles de solicitud
function detallesSolicitudP(id) {
  var url = "solicitudes/detalles";
  $("#funcionario_pre").val("");
  $("#cargo_pre").val("");
  $("#th_solicitud_pre").val("");
  $("#año_solicitud_pre").val("");
  $("#mes_solicitud_pre").val("");
  $("#hora_inicio_pre").val("");
  $("#hora_fin_pre").val("");
  $("#valor_total_pre").val("");
  $("#valor_hora_pre").val("");
  $("#horas_pre").val("");
  $("#horas_restantes_pre").val("");
  $("#autorizado_pre").val("");
  $("#actividades_pre").val("");
  $.post(url + "/" + id).done(function (data) {
    $("#funcionario_pre").val(data.nombres + " " + data.apellidos);
    $("#cargo_pre").val(data.nombre);
    $("#cargo_user_pre").val(data.cargo_user_id);
    $("#th_solicitud_pre").val(data.tipo_hora_id);
    $("#año_solicitud_pre").val(data.año);
    $("#mes_solicitud_pre").val(data.mes);
    $("#hora_inicio_pre").val(data.hora_inicio);
    $("#hora_fin_pre").val(data.hora_fin);
    $("#valor_total_pre").val(data.valor_total);
    $("#valor_hora_pre").val(data.valor_hora);
    $("#horas_pre").val(data.total_horas);
    $("#horas_restantes_pre").val(data.horas_restantes);
    $("#autorizado_pre").val(data.autorizacion);
    $("#actividades_pre").val(data.actividades);
  });
}

// Función para el modal de detalle de presupuesto
function detallesPresupuesto(id) {
  var url = "presupuesto/detalle";
  $.post(url + "/" + id).done(function (data) {
    // console.log(data);
    $("#presupuesto_u").val(data.presupuesto_inicial);
    $("#presupuesto_r").val(data.restante);
    $("#mes_u").val(data.mes);
    $("#año_u").val(data.año);
    $("#updatePresupuesto").attr(
      "onclick",
      "updatePresupuesto(" + data.id + ")"
    );
  });
}

// Función para actualizar cargo ajax
function updatePresupuesto(id) {
  var url = "presupuesto/update";
  $presupuesto = $("#presupuesto_u").val();
  $año = $("#año_u").val();
  $mes = $("#mes_u").val();

  var obj = new Object();
  obj.Id = id;
  obj.Presupuesto = $presupuesto;
  obj.Año = $año;
  obj.Mes = $mes;

  var datos = JSON.stringify(obj);
  // console.log(datos);
  $.post(url + "/" + datos).done(function (data) {
    $("#modalDetallePresupuesto").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire(
        "Completado!",
        "Se ha editado correctamente el Presupuesto",
        "success"
      );
    } else {
      Swal.fire(
        "Error!",
        "Error al editar Presupuesto; " + data + ".",
        "error"
      );
    }
  });
}