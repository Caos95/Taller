var tableadm;
function listar_administrador() {
    tableadm=$("#tabla_adm").DataTable({
        "ordering":false,
        "bLengthChange":false,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "processing": true,
        "ajax":{
            "url":"../controllers/administrador/controlador_administrador_listar.php",
            type:'POST'
        },

        "order":[[1,'asc']],
        "columns":[
            {"data":"id_usuario"},
            {"data":"nombre_usuario"},
            {"data":"nombre_completo"},
            {"data":"rut"},
            {"data":"email"},
            {"data":"sexo",
                render: function (data, type, row ) {
                    if(data=='M'){
                        return "MASCULINO";                   
                    }else{
                        return "FEMENINO";                 
                    }
                }
            },
            {"data":"estado",
                render: function (data, type, row ) {
                    if(data=='1'){
                        return "<span class='label label-success'>ACTIVO</span>";
                    }else{
                        return "<span class='label label-danger'>INACTIVO</span>";
                    }
                }
            },
            {"defaultContent":"",
                render: function (data, type, row ) {
                    let status_button;
                    if (row.estado == '1') {
                        // El usuario está activo, mostrar el botón de desactivar (cruz roja)
                        status_button = "<button style='font-size:13px;' type='button' class='status btn btn-danger'><i class='fa fa-times'></i></button>";
                    } else {
                        // El usuario está inactivo, mostrar el botón de activar (verificación verde)
                        status_button = "<button style='font-size:13px;' type='button' class='status btn btn-success'><i class='fa fa-check'></i></button>";
                    }
                    return "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;" + status_button;
                }
            }
        ],

        "language":idioma_espanol,
        select: true
    });

    document.getElementById("tabla_adm_filter").style.display="none";
   $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    });

}

function filterGlobal() {
    $('#tabla_adm').DataTable().search(
        $('#global_filter').val(),
    ).draw();
}

function AbrirModalRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
    $("#txr_usu").val(""); // Corregido en el commit anterior, ahora es consistente.
    $("#txr_rut").val("");
    $("#txr_nombre").val("");
    $("#txr_con1").val("");
    $("#txr_con2").val("");
    $("#txr_email").val("");
}


function registrar_Administrador() {
    var usuario = $("#txr_usu").val(); // Este ya estaba bien
    var email = $("#txr_email").val(); // Este ya estaba bien
    var contra1 = $("#txr_con1").val(); // Este ya estaba bien
    var contra2 = $("#txr_con2").val(); // Este ya estaba bien
    var sexo = $("#cbm_sexo").val();
    var rol = $("#cbm_rol").val();
    // Corregimos los selectores para que coincidan con el HTML (txr_ en lugar de txt_)
    var rut = $("#txr_rut").val();
    var nombre = $("#txr_nombre").val();

    if (!usuario || !email || !contra1 || !contra2 || !sexo || !rol || !rut || !nombre) {
        return Swal.fire("Mensaje de Advertencia", "Por favor, llene todos los campos vacíos", "warning");
    }
    if (contra1 != contra2) {
        return Swal.fire("Mensaje de Advertencia", "Las contraseñas deben coincidir", "warning");
    }
    if ($("#validar_email").val() == "incorrecto") {
        return Swal.fire("Mensaje de Advertencia", "El formato del correo electrónico es incorrecto. Por favor, ingrese un formato válido", "warning");
    }

    $.ajax({
        url: '../controllers/administrador/controlador_registrar_administrador.php',
        type: 'POST',
        data: {
            usuario: usuario,
            email_administrador: email,
            contra: contra1,
            sexo: sexo,
            rut_administrador: rut,
            nombre_administrador: nombre
        }
    }).done(function (resp) {
        if (resp > 0) {
            if (resp == 1) {
                $("#modal_registro").modal('hide');
                Swal.fire("Mensaje de Confirmación", "Datos guardados correctamente, nuevo administrador registrado", "success").then((value) =>{
                    tableadm.ajax.reload();
                });
            } else {
                Swal.fire("Mensaje de Advertencia", "El nombre de usuario o el RUT ya se encuentran registrados.", "warning");
            }
        } else {
            Swal.fire("Mensaje de Error", "No se pudo completar el registro", "error");
        }
    });
}

$('#tabla_adm').on('click', '.status', function () {
    var data = tableadm.row($(this).parents('tr')).data();
    if (tableadm.row(this).child.isShown()) {
        data = tableadm.row(this).data();
    }

    if (data.estado == '1') {
        // Lógica para desactivar
        Swal.fire({
            title: '¿Está seguro de que desea desactivar al usuario?',
            text: "Una vez hecho esto, el usuario no tendrá acceso al sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.value) {
                modificar_Estado(data.id_usuario, 'INACTIVO');
            }
        });
    } else {
        // Lógica para activar
        Swal.fire({
            title: '¿Está seguro de que desea activar al usuario?',
            text: "Una vez hecho esto, el usuario tendrá acceso al sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.value) {
                modificar_Estado(data.id_usuario, 'ACTIVO');
            }
        });
    }
});

$('#tabla_adm').on('click','.editar',function(){
    var data = tableadm.row($(this).parents('tr')).data();
    if(tableadm.row(this).child.isShown()){
        var data = tableadm.row(this).data();
    }
    
    $("#modal_editar").modal({backdrop:'static',keyboard:false});
    $("#modal_editar").modal('show');
    
    $("#txtidusuario").val(data.id_usuario); // Corregido de usu_id a id_usuario para consistencia
    
    $("#txtusu_editar").val(data.nombre_usuario); // Corregido de usu_nombre a nombre_usuario
    /*
    $("#txt_email_editar").val(data.email); // Asumiendo que el email se traerá en la consulta
    $("#cbm_sexo_editar").val(data.sexo).trigger("change"); // Corregido de usu_sexo a sexo
    $("#cbm_rol_editar").val(data.id_rol).trigger("change"); // Corregido de rol_id a id_rol
*/
    })

function listar_combo_rol(){
    $.ajax({
        "url":"../controllers/administrador/controlador_combo_rol_adm.php",
        type:'POST'
    }).done(function(resp){  
            var data = JSON.parse(resp);
            var cadena="";

            if (data.length > 0){
                for (var i = 0; i < data.length; i++){
                    cadena += "<option value='" + data[i].id_rol + "'>" + data[i].nombre_rol + "</option>";
                }
                $("#cbm_rol").html(cadena);
                $("#cbm_rol_editar").html(cadena);
            } else{
                cadena+="<option value=''>NO SE ENCONTRARON REGISTROS</option>";
                $("#cbm_rol").html(cadena);
                $("#cbm_rol_editar").html(cadena);
            }
    }  ) 
}
function modificar_Estado(idusuario, estado) {
    var mensaje = "";
    if(estado == 'ACTIVO') {
        mensaje="activó";
    } else {
        mensaje="desactivó";
    }

    console.log("Intentando modificar estado para id_usuario:", idusuario, "a estado:", estado);

    $.ajax({
        url:"../controllers/administrador/controlador_status_administrador.php",
        type:'POST',
        data:{
            id_usuario: idusuario,
            estado: estado
        }
    }).done(function(resp){
        console.log("Respuesta del servidor (resp):", resp);
        if (resp > 0) {
            Swal.fire("Mensaje de Confirmación", "El estado del usuario se "+ mensaje +" con éxito", "success")
            .then((value) => {
                tableadm.ajax.reload();
            });
        } else {
            // Opcional: Manejar el caso en que la consulta no afectó filas.
            Swal.fire("Mensaje de Advertencia", "No se pudo cambiar el estado del usuario", "warning");
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // Opcional: Manejar errores de conexión o del servidor.
        Swal.fire("Error", "No se pudo conectar con el servidor: " + textStatus, "error");
    })
}
