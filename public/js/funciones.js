
$("#date_input").on("change", function () {
    $(this).css("color", "rgba(0,0,0,0)").siblings(".datepicker_label").css({ "text-align": "center", position: "absolute", left: "10px", top: "14px", width: $(this).width() }).text($(this).val().length == 0 ? "" : ($.datepicker.formatDate($(this).attr("dateformat"), new Date($(this).val()))));
});
function notificacionCorreo() {
    Swal.fire(
        'Completado!',
        "Se ha enviado un correo electrónico para restaurar su contraseña",
        'success'
    )
}

// DATATABLES

// Datatable Usuarios
$(document).ready(function () {
    $('#dtUsuarios')
        .addClass('table-striped table-sm table-hover table-dark table table-bordered')
        .dataTable({
            "language": {
                "url": "DataTables/Spanish.json"
            },
            responsive: true,
            dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
            buttons: [
                'copy', 'excel', 'csv'
            ]
        });
})
// Datatable horas extras
$(document).ready(function () {
    $('#dthorasExtras')
        .addClass('table-striped table-sm table-hover table-dark table table-bordered')
        .dataTable({
            "language": {
                "url": "DataTables/Spanish.json"
            },
            responsive: true,
            dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
            buttons: [
                'copy', 'excel', 'csv'
            ]
        });
})
// Datatable cargos
$(document).ready(function () {
    $('#dtCargos')
        .addClass('table-striped table-sm table-hover table-dark table table-bordered')
        .dataTable({
            "language": {
                "url": "DataTables/Spanish.json"
            },
            responsive: true,
            dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
            buttons: [
                'copy', 'excel', 'csv'
            ]
        });
})
//------ MODULO DE USUARIOS

// Función para el modal de detalles
function detallesUsuario(id) {
    var url = "usuarios/detalle";
    $.post(url + "/" + id).done(function (data) {
        console.log(data);
        $("#documento_user_d").val(data.usuario.documento);
        $("#nombres_user_d").val(data.usuario.nombres);
        $("#apellidos_user_d").val(data.usuario.apellidos);
        $("#cargo_user_d").val(data.cargo.nombre);
        $("#centro_user_d").val(data.usuario.centro);
        $("#regional_user_d").val(data.usuario.regional);
        $("#sueldo_user_d").val(data.cargo.sueldo);
        $("#email_user_d").val(data.usuario.email);
        $("#telefono_user_d").val(data.usuario.telefono);
        $('#tipoDocumento_user_d').val(data.usuario.tipo_documento);
        $("#update").attr('onclick', 'updateUsuario(' + data.usuario.id + ')');
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
    $tipoDocumento = $('#tipoDocumento_user_d').val();

    var obj = new Object();
    obj.Id = id;
    obj.Documento = $documento;
    obj.Nombres = $nombres;
    obj.Apellidos = $apellidos;
    obj.Cargo = $cargo;
    obj.Regional = $regional
    obj.Centro = $centro;
    obj.Sueldo = $sueldo;
    obj.Correo = $correo;
    obj.Telefono = $telefono;
    obj.TipoDocumento = $tipoDocumento;


    var datos = JSON.stringify(obj);
    console.log(datos);
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
        $('#tipoDocumento_user_d').val(data.tipo_documento);
        $("#modalDetalle").modal('hide');//ocultamos el modal 
        // console.log(data);
        if (Number(data)) {
            Swal.fire(
                'Completado!',
                "Se editado el Usuario correctamente",
                'success'
            )
        } else {
            Swal.fire(
                'Error!',
                "Error al editar Usuario",
                'error'
            )

        }
        $("#table_div_user").load(" #dtUsuarios", function () {
            $('#dtUsuarios')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": "DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });

}
// Activa el estado del Usuario
function activar(id, color) {
    var estado = $(color).html();
    var url = "usuarios/activar";
    $.post(url + "/" + id).done(function (data) {

        Swal.fire(
            'Completado!',
            "el Usuario se ACTIVO correctamente",
            'success'
        )

        $("#table_div_user").load(" #dtUsuarios", function () {
            $('#dtUsuarios')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": "DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });
}

// Inactiva el estado del usuario
function inactivar(id, color) {
    var estado = $(color).html();
    var url = "usuarios/inactivar";
    $.post(url + "/" + id).done(function (data) {

        Swal.fire(
            'Completado!',
            "el Usuario se INACTIVO correctamente",
            'success'
        )

        $("#table_div_user").load(" #dtUsuarios", function () {
            $('#dtUsuarios')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": ".DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });
}
// Mensaje en caso que no tenga permiso
function Nopermiso() {
    Swal.fire(
        'Error!',
        "Usted no tiene permiso para editar esto",
        'error'
    )
}
// Guarda usuario en la base de datos
function crearUsuario() {
    var url = "registrar/guardar";
    $documento = $("#documento_user_g").val();
    $nombres = $("#nombres_user_g").val();
    $apellidos = $("#apellidos_user_g").val();
    $correo = $("#email_user_g").val();
    $telefono = $("#telefono_user_g").val();
    $tipoDocumento = $("[name = 'select_tipoDocumento_g']").children("option:selected").val();
    $rol = $("[name = 'select_rol_g']").children("option:selected").val();
    $centro = $("[name = 'select_centro_g']").children("option:selected").val();
    $regional = $("[name = 'select_regional_g']").children("option:selected").val();
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
    console.log(datos);
    $.post(url + "/" + datos).done(function (data) {
        $("#documento_user").val(data.documento);
        $("#nombres_user").val(data.nombres);
        $("#apellidos_user").val(data.apellidos);
        $("#email_user").val(data.email);
        $("#eps_user").val(data.eps);
        $("#telefono_user").val(data.telefono);
        $('#tipoDocumento_user').val(data.tipo_documento);
        $('#rol_user').val(data.rol_id);
        $("#modalRegistrarUsuario").modal('hide');//ocultamos el modal 
        // console.log(data);
        if (Number(data)) {
            Swal.fire(
                'Completado!',
                "Se ha guardado exitosamente a " + $nombres,
                'success'
            )
        } else {
            Swal.fire(
                'Error!',
                "Error al guardar el Usuario",
                'error'
            )

        }
        $("#table_div_user").load(" #dtUsuarios", function () {
            $('#dtUsuarios')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": ".DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });
}
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
                $("#modalLoginAvatar").modal('hide');//ocultamos el modal
                Swal.fire(
                    'Completado!',
                    "El usuario " + dato.nombres + " ha cambiado su contraseña",
                    'success'
                );
            });
        } else {
            Swal.fire(
                'Error!',
                "La clave debe tener mínimo 6 caracteres y no se aceptan espacios en blanco",
                'error'
            );
        }
    } else {
        Swal.fire(
            'Error!',
            "Las claves deben coincidir",
            'error'
        );
    }

});

// MODULO CARGOS

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
        $("#updateCargo").attr('onclick', 'updateCargo(' + data.id + ')');
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
    console.log(datos);
    $.post(url + "/" + datos).done(function (data) {
        $("#nombre_cargo_d").val(data.nombre);
        $("#sueldo_cargo_d").val(data.sueldo);
        $("#diurna_cargo_d").val(data.valor_diurna);
        $("#nocturna_cargo_d").val(data.valor_nocturna);
        $("#dominical_cargo_d").val(data.valor_dominical);
        $("#nocturno_cargo_d").val(data.valor_recargo);
        $("#modalDetalleCargo").modal('hide');//ocultamos el modal 
        // console.log(data);
        if (Number(data)) {
            Swal.fire(
                'Completado!',
                "Se editado el Cargo correctamente",
                'success'
            )
        } else {
            Swal.fire(
                'Error!',
                "Error al editar Cargo",
                'error'
            )

        }
        $("#table_div_cargos").load(" #dtCargos", function () {
            $('#dtCargos')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": "DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
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
    console.log(datos);
    $.post(url + "/" + datos).done(function (data) {
        $("#nombre_cargo_d").val(data.nombre);
        $("#sueldo_cargo_d").val(data.sueldo);
        $("#diurna_cargo_d").val(data.valor_diurna);
        $("#nocturna_cargo_d").val(data.valor_nocturna);
        $("#dominical_cargo_d").val(data.valor_dominical);
        $("#nocturno_cargo_d").val(data.valor_recargo);
        $("#modalRegistrarCargo").modal('hide');//ocultamos el modal 
        // console.log(data);
        if (Number(data)) {
            Swal.fire(
                'Completado!',
                "Se ha Guardado el Cargo correctamente",
                'success'
            )
        } else {
            Swal.fire(
                'Error!',
                "Error al Guardar Cargo",
                'error'
            )

        }
        $("#table_div_cargos").load(" #dtCargos", function () {
            $('#dtCargos')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": "DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });

}

// Guarda la información de un cargo nuevo
function guardarHoras() {
    var url = "horas/guardar";
    $funcionario = $("[name = 'select_user_h']").children("option:selected").val();
    $fecha = $("#date").val();
    $tipoHora = $("[name = 'tipohoras_h']").children("option:selected").val();
    $horaInicio = $("#hora_inicio").val();
    $horaFin = $("#hora_fin").val();
  
    var obj = new Object();
    obj.Funcionario = $funcionario;
    obj.Fecha = $fecha;
    obj.TipoHora = $tipoHora;
    obj.Inicio = $horaInicio;
    obj.Fin = $horaFin;

    var datos = JSON.stringify(obj);
    console.log(datos);
    $.post(url + "/" + datos).done(function (data) {
        if (Number(data)) {
            Swal.fire(
                'Completado!',
                "Se han Guardado las Horas Extras correctamente",
                'success'
            )
        } else {
            Swal.fire(
                'Error!',
                "Error al Guardar Horas Extras",
                'error'
            )

        }
        $("#table_div_cargos").load(" #dtCargos", function () {
            $('#dtCargos')
                .addClass('table-striped table-bordered')
                .dataTable({
                    "language": {
                        "url": "DataTables/Spanish.json"
                    },
                    destroy: true,
                    responsive: true,
                    dom: 'B<"salto"><"panel-body"<"row"<"col-sm-6"l><"col-sm-6"f>>>rtip',
                    buttons: [
                        'copy', 'excel', 'csv'
                    ]
                });
        });

    });

}