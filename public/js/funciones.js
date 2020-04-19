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
      $(this).val().length == 0
        ? ""
        : $.datepicker.formatDate(
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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
      "table-striped table-sm table-hover table-dark table table-bordered"
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

// Función para el modal de detalles de la cuenta iniciada
function detallesUsuarioSesion(id) {
  var url = "usuarios/detalle";
  $.post(url + "/" + id).done(function (data) {
    console.log(data);
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
        .addClass("table-striped table-bordered")
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
    $("#documento_user_d").val(data.documento);
    $("#nombres_user_d").val(data.nombres);
    $("#apellidos_user_d").val(data.apellidos);
    $("#email_user_d").val(data.email);
    $("#centro_user_d").val(data.centro);
    $("#regional_user_d").val(data.regional);
    $("#cargo_user_d").val(data.cargo);
    $("#sueldo_user_d").val(data.sueldo);
    $("#telefono_user_d").val(data.telefono);
    $("#tipoDocumento_user_d").val(data.tipo_documento);
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
        .addClass("table-striped table-bordered")
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
        .addClass("table-striped table-bordered")
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
        .addClass("table-striped table-bordered")
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
        .addClass("table-striped table-bordered")
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
// Mensaje en caso que no tenga permiso
function Nopermiso() {
  Swal.fire("Error!", "Usted no tiene permiso para editar esto", "error");
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
    $("#documento_user").val(data.documento);
    $("#nombres_user").val(data.nombres);
    $("#apellidos_user").val(data.apellidos);
    $("#email_user").val(data.email);
    $("#eps_user").val(data.eps);
    $("#telefono_user").val(data.telefono);
    $("#tipoDocumento_user").val(data.tipo_documento);
    $("#rol_user").val(data.rol_id);
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
        .addClass("table-striped table-bordered")
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
    $("#nombre_cargo_d").val(data.nombre);
    $("#sueldo_cargo_d").val(data.sueldo);
    $("#diurna_cargo_d").val(data.valor_diurna);
    $("#nocturna_cargo_d").val(data.valor_nocturna);
    $("#dominical_cargo_d").val(data.valor_dominical);
    $("#nocturno_cargo_d").val(data.valor_recargo);
    $("#modalDetalleCargo").modal("hide"); //ocultamos el modal
    // console.log(data);
    if (data == 1) {
      Swal.fire("Completado!", "Se editado el Cargo correctamente", "success");
    } else {
      Swal.fire("Error!", "Error al editar Cargo, " + data + ".", "error");
    }
    $("#table_div_cargos").load(" #dtCargos", function () {
      $("#dtCargos")
        .addClass("table-striped table-bordered")
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
        .addClass("table-striped table-bordered")
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

// ------------MODULO DE HORAS EXTRAS ----------------

// Guarda las horas extras
function guardarHoras() {
  var url = "horas/guardar";
  $funcionario = $("#funcionario_cargo_user").val();
  $fecha = $("#date").val();
  $tipoHora = $("[name = 'tipohoras_h']").children("option:selected").val();
  $horaInicio = $("#hora_inicio").val();
  $horaFin = $("#hora_fin").val();
  $justificacion = $("#justificacion").val();

  var obj = new Object();
  obj.Id = $funcionario;
  obj.Fecha = $fecha;
  obj.Inicio = $horaInicio;
  obj.Fin = $horaFin;
  obj.TipoHora = $tipoHora;
  obj.Justificacion = $justificacion;

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

// Función para el modal de detalles
function detallesHora(id) {
  var url = "horas/detalle";
  $.post(url + "/" + id).done(function (data) {
    console.log(data);
    $("#funcionario_h").val(data.user.nombres + " " + data.user.apellidos);
    $("#cargo_h").val(data.cargo.nombre);
    $("#fecha_h").val(data.hora.fecha);
    $("#th_h").val(data.tipoHora.id);
    $("#hora_inicio_h").val(data.hora.hi_solicitada);
    $("#hora_fin_h").val(data.hora.hf_solicitada);
    $("#horas_h").val(data.cantidadHoras);
    $("#valor_hora_h").val(data.valor);
    $("#valor_total_h").val(data.valorTotal);
    $("#cargo_user_h").val(data.cargoUser.id);
    $("#justificacion_h").val(data.hora.justificacion);
    if (data.autorizado === 0) {
      $("#autorizado_h").val("No ha sido autorizado");
    } else {
      $("#autorizado_h").val(
        data.autorizado.nombres + " " + data.autorizado.apellidos
      );
    }
    $("#update_h").attr("onclick", "updateHoras(" + data.hora.id + ")");
  });
}

// Función para actualizar horas ajax
function updateHoras(id) {
  var url = "horas/update";
  $fecha = $("#fecha_h").val();
  $th = $("#th_h").val();
  $hora_inicio = $("#hora_inicio_h").val();
  $hora_fin = $("#hora_fin_h").val();
  $cargoUser = $("#cargo_user_h").val();
  console.log($th);

  $justificacion = $("#justificacion_h").val();

  var obj = new Object();
  obj.Id = id;
  obj.Fecha = $fecha;
  obj.Th = $th;
  obj.CargoUser = $cargoUser;
  obj.Inicio = $hora_inicio;
  obj.Fin = $hora_fin;
  obj.Justificacion = $justificacion;

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
    } else {
      Swal.fire("Error!", "Error al editar horas; " + data + ".", "error");
    }
    $("#div_horas").load(" #dthorasExtras", function () {
      $("#dthorasExtras")
        .addClass("table-striped table-bordered")
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
function autorizar(id, idUser) {
  // console.log(id);
  // console.log(idUser);
  Swal.fire({
    title: "¿Estas seguro que quieres autorizar estas horas?",
    text: "No se puede revertir esta acción",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Autorizar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      var url = "horas/autorizar";
      var obj = new Object();
      obj.Id = id;
      obj.Id_user = idUser;
      var datos = JSON.stringify(obj);
      $.post(url + "/" + datos).done(function (data) {
        if (data == 1) {
          Swal.fire("Completado!", "Se han autorizado las horas", "success");

          $("#div_horas").load(" #dthorasExtras", function () {
            $("#dthorasExtras")
              .addClass("table-striped table-bordered")
              .dataTable({
                language: {
                  url: "DataTables/Spanish.json",
                },
                destroy: true,
                responsive: true,
                dom:
                  'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                buttons: ["copy", "excel", "csv"],
              });
          });
        } else {
          Swal.fire("Error!", "Error al autorizar; " + data + ".", "error");
        }
      });
    }
  });
}

// ------------MODULO DE REPORTES ----------------

function solicitudAutorizacion() {
  var url = "reportes/solicitudAutorizacion";
  $funcionario = $("[name = 'select_f']").children("option:selected").val();
  $mes = $("[name = 'select_mes']").children("option:selected").val();
  var obj = new Object();
  obj.Id = $funcionario;
  obj.Mes = $mes;
  var datos = JSON.stringify(obj);
  $.get(url + "/" + datos).done(function (data) {
    // console.log(data);
  });
}

// ---------- MODULO TIPO DE HORAS ---------

// Función para el modal de detalles
function detallesTipoHora(id) {
  var url = "tipo_horas/detalle";
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
        .addClass("table-striped table-bordered")
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

// ------------MODULO DE REPORTES ----------------

function solicitudAutorizacion() {
  var url = "reportes/solicitudAutorizacion";
  $funcionario = $("[name = 'select_f']").children("option:selected").val();
  $mes = $("[name = 'select_mes']").children("option:selected").val();
  var obj = new Object();
  obj.Id = $funcionario;
  obj.Mes = $mes;
  var datos = JSON.stringify(obj);
  $.get(url + "/" + datos).done(function (data) {
    // console.log(data);
  });
}

// ----------- MODULO DE FECHAS ------------------

// Función para el modal de detalles
function detallesFecha(id) {
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
        .addClass("table-striped table-bordered")
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
        .addClass("table-striped table-bordered")
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
  console.log($mes);

  var obj = new Object();
  obj.Presupuesto = $presupuesto;
  obj.Mes = $mes;
  obj.Año = $año;

  var datos = JSON.stringify(obj);
  console.log(datos);
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
        .addClass("table-striped table-bordered")
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
  $presupuesto  = $("#presupuesto_u").val();
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
      Swal.fire("Error!", "Error al editar Presupuesto; " + data + ".", "error");
    }
    $("#div_horas").load(" #dthorasExtras", function () {
      $("#dthorasExtras")
        .addClass("table-striped table-bordered")
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

// Carga la tabla de presupuesto y muestra las horas que han usado dicho presupuesto
function tabla_de_presupuestos() {
    
  var seleccion = document.getElementById("seleccionar_presupuesto");
  var id = seleccion.options[seleccion.selectedIndex].value;
  var url = "presupuesto/tabla";
  var  boton_presupuesto= `<button class="btn btn-secondary" data-toggle="modal" data-target="#modalDetallePresupuesto" 
    onclick="detallesPresupuesto(`+ id +`)">Detalles de presupuesto</button>`;
  
  $.post(url + "/" + id).done(function (data) {
    if (data.horas.length>=1){
      $("#informacion_presupuesto").html("");
      $("#informacion_presupuesto").append(boton_presupuesto);
    }
    else{
      $("#informacion_presupuesto").html("");
    }
    $("#cuerpo_presupuesto").html("");
    // console.log(data);
    for (var i = 0; i < data.horas.length; i++) {
      var id = data.horas;
      console.log(id);
      var tr =
        `<tr>
        <td>` + data.horas[i].id +`</td>
        <td>` +
        data.horas[i].id +
        `</td>
        <td>` +
        data.horas[i].fecha +
        `</td>
        <td>` +
        data.horas[i].hi_solicitada +
        `</td>
        <td>` +
        data.horas[i].hf_solicitada +
        `</td>
        <td>` +
        data.horas[i].tipo_hora +
        `</td>
        <td> 
            <button class="btn btn-secondary" onclick="detallesHoraP(`+ data.horas[i].id +`)" data-toggle="modal" data-target="#modalDetallesHoraP">Detalles
            </button>
            
      </tr>`;

      $("#cuerpo_presupuesto").append(tr);
    }
  });
}

// Función para el modal de detalles de hora en presupuesto
function detallesHoraP(id) {
  console.log(id);
  var url = "horas/detalle";
  $("#funcionario_p").val('');
    $("#cargo_p").val('');
    $("#fecha_p").val('');
    $("#th_p").val('');
    $("#hora_inicio_p").val('');
    $("#hora_fin_p").val('');
    $("#horas_p").val('');
    $("#valor_hora_p").val('');
    $("#valor_total_p").val('');
    $("#cargo_user_p").val('');
    $("#justificacion_p").val('');
    $("#autorizado_p").val('');
  $.post(url + "/" + id).done(function (data) {
    $("#funcionario_p").val(data.user.nombres + " " + data.user.apellidos);
    $("#cargo_p").val(data.cargo.nombre);
    $("#fecha_p").val(data.hora.fecha);
    $("#th_p").val(data.tipoHora.id);
    $("#hora_inicio_p").val(data.hora.hi_solicitada);
    $("#hora_fin_p").val(data.hora.hf_solicitada);
    $("#horas_p").val(data.cantidadHoras);
    $("#valor_hora_p").val(data.valor);
    $("#valor_total_p").val(data.valorTotal);
    $("#cargo_user_p").val(data.cargoUser.id);
    $("#justificacion_p").val(data.hora.justificacion);
    if (data.autorizado === 0) {
      $("#autorizado_p").val("No ha sido autorizado");
    } else {
      $("#autorizado_p").val(
        data.autorizado.nombres + " " + data.autorizado.apellidos
      );
    }
    $("#update_p").attr("onclick", "updateHoras(" + data.hora.id + ")");
  });
}