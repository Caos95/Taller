var tablerol;

function listar_rol() {
  tablerol = $("#tabla_rol").DataTable({
    ordering: false,
    bLengthChange: false,
    searching: { regex: false },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../controllers/rol/controlador_rol_listar.php",
      type: "POST",
    },
    columns: [
        { defaultContent: "" },
        { data: "nombre_rol" },
        {
            defaultContent:
            "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='eliminar btn btn-danger'><i class='fa fa-trash'></i></button>",
        },
    ],
    language: idioma_espanol,
    select: true,
  });

  document.getElementById("tabla_rol_filter").style.display = "none";

  $("input.global_filter").on("keyup click", function () {
    filterGlobal();
  });
  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });

  tablerol.on("draw.dt", function () {
    var PageInfo = $("#tabla_rol").DataTable().page.info();
    tablerol
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
      });
  });
  
}
function filterGlobal() {
    $("#tabla_rol").DataTable().search(
        $("#global_filter").val(),
    ).draw();
}

// Abrir Modal de Registro
function AbrirModalRegistro() {
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

// Registrar Rol
function Registrar_Rol() {
    var rol = $("#txt_rol").val();
    if(rol.length == 0) {
        return Swal.fire("Mensaje de Advertencia", "El campo de rol no puede estar vacío.", "warning");
    }

    $.ajax({
        url: "../controllers/rol/controlador_registro_rol.php",
        type: "POST",
        data: {
            nombre_rol: rol
        }
    }).done(function(resp) {
        if(resp > 0) {
            if(resp == 1) {
                $("#modal_registro").modal("hide");
                Swal.fire("Mensaje de Confirmación", "Nuevo rol registrado exitosamente.", "success")
                .then((value) => {
                    tablerol.ajax.reload();
                });
            } else {
                Swal.fire("Mensaje de Advertencia", "El rol ingresado ya se encuentra en la base de datos.", "warning");
            }
        } else {
            Swal.fire("Mensaje de Error", "No se pudo completar el registro.", "error");
        }
    });
}

// Abrir Modal de Edición y Cargar Datos
$('#tabla_rol').on('click', '.editar', function() {
    var data = tablerol.row($(this).parents('tr')).data();
    if(tablerol.row(this).child.isShown()){
        var data = tablerol.row(this).data();
    }
    $("#modal_editar").modal({ backdrop: "static", keyboard: false });
    $("#modal_editar").modal("show");
    $("#txt_idrol").val(data.id_rol);
    $("#txt_rol_editar").val(data.nombre_rol);
});

// Modificar Rol
function Modificar_Rol() {
    var id = $("#txt_idrol").val();
    var rol = $("#txt_rol_editar").val();
    if(rol.length == 0) {
        return Swal.fire("Mensaje de Advertencia", "El campo de rol no puede estar vacío.", "warning");
    }

    $.ajax({
        url: "../controllers/rol/controlador_modificar_rol.php",
        type: "POST",
        data: {
            id: id,
            rol: rol
        }
    }).done(function(resp) {
        if(resp > 0) {
            if(resp == 1) {
                $("#modal_editar").modal("hide");
                Swal.fire("Mensaje de Confirmación", "Rol actualizado exitosamente.", "success")
                .then((value) => {
                    tablerol.ajax.reload();
                });
            } else {
                Swal.fire("Mensaje de Advertencia", "El rol ingresado ya se encuentra en la base de datos.", "warning");
            }
        } else {
            Swal.fire("Mensaje de Error", "No se pudo completar la actualización.", "error");
        }
    });
}

// Eliminar Rol
$('#tabla_rol').on('click', '.eliminar', function() {
    var data = tablerol.row($(this).parents('tr')).data();
    if(tablerol.row(this).child.isShown()){
        var data = tablerol.row(this).data();
    }
    Swal.fire({
        title: '¿Está seguro de eliminar el rol "' + data.nombre_rol + '"?',
        text: "Una vez eliminado, no podrá recuperarlo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "../controllers/rol/controlador_eliminar_rol.php",
                type: "POST",
                data: {
                    id: data.id_rol
                }
            }).done(function(resp) {
                if(resp > 0) {
                    Swal.fire("Mensaje de Confirmación", "Rol eliminado exitosamente.", "success")
                    .then((value) => {
                        tablerol.ajax.reload();
                    });
                } else {
                    Swal.fire("Mensaje de Error", "No se pudo eliminar el rol.", "error");
                }
            })
        }
      })
});