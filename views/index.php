<?php
  session_start();
  if(!isset($_SESSION['S_IDUSUARIO'])){
  	header('Location: ../login/index.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Taller | Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Plantilla/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../Plantilla/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Plantilla/dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="../css/custom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../Plantilla/dist/css/skins/_all-skins.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../Plantilla/plugins/DataTables/datatables.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
.swal2-popup{
  font-size:1.6rem !important;
}
body { padding-right: 0 !important }
  .box-title,.btn{
    font-weight: bold;
  }
  a{
    cursor: pointer;
  }
</style>
<body class="hold-transition skin-blue sidebar-mini" style="padding-right: 0px !important;">
<div class="wrapper">

  <header class="main-header">
    <a href="index.php" style="background-color: white;color: black" class="logo">
      <span class="logo-mini"><i class="fa fa-wrench icon text-primary"></i></span>
      <span class="logo-lg"><i class="fa fa-wrench icon text-primary fa-2x"></i>&nbsp;<b>Taller</b></span>
    </a>
    <nav class="navbar navbar-static-top" style="background-color: #1b27d1">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img id="img_nav" class="user-image" alt="User Image">
              <span class="hidden-xs"><b><?php echo $_SESSION['S_NOMBRECOMPLETO']; ?></b></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header" style="background-color: #1b27d1; color: white;">
                <img id="img_subnav" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['S_NOMBRECOMPLETO']; ?>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" onclick="AbrirModalEditarContra()" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="../controllers/usuario/controlador_cerrar_sesion.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      </nav>
  </header>

  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img id="img_lateral" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="user-name"><?php echo $_SESSION['S_NOMBRECOMPLETO']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['S_ROL'] ?></a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">PANEL DE NAVEGACIÓN</li>
        <?php if (strtoupper($_SESSION['S_ROL']) === "ADMINISTRADOR") { ?>
            <li>
                <a onclick="cargar_contenido('contenido_principal','usuario/vista_usuario_listar.php')">
                    <i class="fa fa-user-secret"></i> <span>Usuario</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
            <li>
                <a onclick="cargar_contenido('contenido_principal','mecanico/vista_mecanico.php')">
                    <i class="fa fa-users"></i> <span>Mecanico</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
             <li>
                <a onclick="cargar_contenido('contenido_principal','rol/vista_rol.php')">
                    <i class="fa fa-refresh"></i> <span>Roles</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
        <?php } ?>
        
        <?php if (strtoupper($_SESSION['S_ROL']) === "MECANICO") { ?>
             <li>
                <a onclick="cargar_contenido('contenido_principal','reparacion/vista_reparacion_listar.php')">
                    <i class="fa fa-wrench"></i> <span>Reparaciones</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
        <?php } ?>
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    <section class="content">
      <input type="text" id="txtidprincipal" value="<?php echo $_SESSION['S_IDUSUARIO'] ?>" hidden>
      <input type="text" id="usuarioprincipal" value="<?php echo $_SESSION['S_USUARIO'] ?>" hidden>
      <div class="row">
      <div id= "contenido_principal">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">BIENVENIDO AL SISTEMA</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <p>Seleccione una opción del menú lateral para comenzar a trabajar.</p>
            </div>
          </div>
        </div>
    </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Todos los derechos reservados &copy; <?php echo date('Y')?> <a href="">Taller</a>.</strong>
  </footer>
  <div class="control-sidebar-bg"></div>
</div>

<!-- Modal para editar contraseña -->
<div class="modal fade" id="modal_editar_contra" role="dialog">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Modificar Contraseña</b></h4>
        </div>
        <form onsubmit="return false;">
            <div class="modal-body">
                <div class="col-lg-12">
                    <input type="text" id="txtcontra_bd" hidden autocomplete="off">
                    <label for="txtcontraactual_editar">Contraseña Actual</label>
                    <input type="password" class="form-control" id="txtcontraactual_editar" placeholder="Contraseña Actual" autocomplete="current-password"><br>
                </div>
                <div class="col-lg-12">
                    <label for="txtcontranu_editar">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="txtcontranu_editar" placeholder="Nueva Contraseña" autocomplete="new-password"><br>
                </div>
                <div class="col-lg-12">
                    <label for="txtcontrare_editar">Repetir Contraseña</label>
                    <input type="password" class="form-control" id="txtcontrare_editar" placeholder="Repetir Contraseña" autocomplete="new-password"><br>
                </div>
            </div>
        </form>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="Editar_Contra()"><i class="fa fa-check"></i><b>&nbsp;Modificar</b></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i><b>&nbsp;Cerrar</b></button>
        </div>
    </div>
    </div>
</div>

<script src="../Plantilla/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../Plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
	var idioma_espanol = {
			select: {
			rows: "%d fila seleccionada"
			},
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
			"sInfo":           "Registros del (_START_ al _END_) total de _TOTAL_ registros",
			"sInfoEmpty":      "Registros del (0 al 0) total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "<b>No se encontraron datos</b>",
			"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
			},
			"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
	}
  function cargar_contenido(contenedor,contenido){
      $("#"+contenedor).load(contenido);
  }
  $.widget.bridge('uibutton', $.ui.button);
  function soloNumeros(e){
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla==8){
          return true;
      }
      patron =/[0-9]/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
  }
  function soloLetras(e){
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
      especiales = "8-37-39-46";
      tecla_especial = false
      for(var i in especiales){
          if(key == especiales[i]){
              tecla_especial = true;
              break;
          }
      }
      if(letras.indexOf(tecla)==-1 && !tecla_especial){
          return false;
      }
  }
  function filterFloat(evt,input){
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {
              return true;
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
        return false;
    }
}
</script>
<script src="../Plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../Plantilla/bower_components/raphael/raphael.min.js"></script>
<script src="../Plantilla/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="../Plantilla/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="../Plantilla/bower_components/moment/min/moment.min.js"></script>
<script src="../Plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../Plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../Plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="../Plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../Plantilla/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../Plantilla/dist/js/adminlte.min.js"></script>
<script src="../Plantilla/dist/js/demo.js"></script>
<script src="../Plantilla/plugins/DataTables/datatables.min.js"></script>
<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script src="../Plantilla/plugins/sweetalert2/sweetalert2.js"></script>
<script src="../js/usuario.js"></script> 
<script>
    TraerDatosUsuario();
</script>
</body>
</html>
