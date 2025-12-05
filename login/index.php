<?php
session_start();
// Es una buena práctica usar 'exit()' después de una redirección para asegurar que no se ejecute más código.
if(isset($_SESSION['S_IDUSUARIO'])){
    header('Location: ../views/index.php');
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Taller</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('css/bg2.png');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form">
                    <div class="col-lg-12" style="text-align:center">
                        <span class="login100-form-title p-b-49">
                            <b>TALL</b>ER
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Usuario es requerido">
                        <span class="label-input100">Usuario</span>
                        <input class="input100" type="text" name="usu" placeholder="Escriba el usuario" id="txt_usuario" autocomplete="username">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Contraseña es requerida">
                        <span class="label-input100">Contrase&ntilde;a</span>
                        <input class="input100" type="password" onkeyup="if(event.keyCode == 13) VerificarUsuario()" name="con" placeholder="Escriba la contrase&ntilde;a" id="txt_contra" autocomplete="current-password">
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="text-right p-t-8 p-b-31">
                        <a href="#" onclick="abrirModalRestablecer()">
                            Olvidaste la contrase&ntilde;a?
                        </a>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="button" class="login100-form-btn" onclick="VerificarUsuario()">
                                ENTRAR
                            </button>
                        </div>
                    </div><br>

                    <div class="flex-col-c p-t-20">
                        <span class="txt1 p-b-1">
                            O
                        </span>
                        <a href="#" class="txt2" onclick="abrirmodalRegistrate()">
                            Regístrate
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <div class="modal fade" id="modal_restablecer_contra" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="text-align:left;">
                    <h4 class="modal-title"><b>Restablecer Contrase&ntilde;a</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <label for=""><b>Ingrese el email registrado en el usuario para enviarle su contrase&ntilde;a restablecida</b></label>
                        <input type="text" class="form-control" id="txt_email" placeholder="Ingrese Email"><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Restablecer_Contra()"><i class="fa fa-check"><b>&nbsp;Enviar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/sweetalert2/sweetalert2.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/main.js"></script>
    <script src="../js/usuario.js"></script>

</body>
<script>
    txt_usuario.focus();
</script>
</html>