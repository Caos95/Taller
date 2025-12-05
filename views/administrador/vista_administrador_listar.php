<script type="text/javascript" src="../js/administrador.js?rev=<?php echo time(); ?>"></script>
<div class="row">
</div>
<div class="col-md-12">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">BIENVENIDO AL CONTENIDO DEL ADMINISTRADOR</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter"
                            placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i
                            class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
                </div>
            </div>
            <table id="tabla_adm" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Rut</th>
                        <th>Email</th>
                        <th>Sexo</th>
                        <th>Estatus</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Registro De Administrador</b></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <label for="">Usuario</label>
                        <input type="text" class="form-control" id="txr_usu" placeholder="Ingrese usuario"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">RUT</label>
                        <input type="text" class="form-control" id="txr_rut" placeholder="Ingrese RUT"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" id="txr_nombre" placeholder="Ingrese nombre"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="txr_email" placeholder="Ingrese email">
                        <label for="" id="emailOK" style="color:red;"></label>
                        <input type="text" id="validar_email" hidden>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="txr_con1"
                            placeholder="Ingrese contrase&ntilde;a"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Repita la Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="txr_con2"
                            placeholder="Repita contrase&ntilde;a"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Sexo</label>
                        <select class="js-example-basic-single" name="state" id="cbm_sexo" style="width:100%;">
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select><br><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Rol</label>
                        <select class="js-example-basic-single" name="state" id="cbm_rol" style="width:100%;">
                        </select><br><br>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="registrar_Administrador()"><i
                            class="fa fa-check"></i><b>&nbsp;Registrar</b></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-close"></i><b>&nbsp;Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>
</form>


<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Editar Datos Del Administrador</b></h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <input type="text" id="txtidusuario" hidden>
                    <label for="">Usuario</label>
                    <input type="text" class="form-control" id="txtusu_editar" placeholder="Ingrese usuario" disabled><br>
                </div>
                <div class="col-lg-12">
                    <label for="">RUT</label>
                    <input type="text" class="form-control" id="txt_rut_editar" placeholder="Ingrese RUT" disabled><br>
                </div>
                <div class="col-lg-12">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" id="txt_nombre_editar" placeholder="Ingrese nombre"><br>
                </div>
                <div class="col-lg-12">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="txt_email_editar" placeholder="Ingrese email">
                    <label for="" id="emailOK_editar" style="color:red;"></label>
                    <input type="text" id="validar_email_editar" hidden>
                </div>
                <div class="col-lg-12">
                    <label for="">Contrase&ntilde;a (Opcional)</label>
                    <input type="password" class="form-control" id="txt_con1_editar"
                        placeholder="Dejar en blanco para no modificar"><br>
                </div>
                <div class="col-lg-12">
                    <label for="">Repita la Contrase&ntilde;a</label>
                    <input type="password" class="form-control" id="txt_con2_editar"
                        placeholder="Repita contrase&ntilde;a"><br>
                </div>
                <div class="col-lg-12">
                    <label for="">Sexo</label>
                    <select class="js-example-basic-single" name="state" id="cbm_sexo_editar" style="width:100%;">
                        <option selected disabled>Seleccione Sexo</option>
                        <option value="M">MASCULINO</option>
                        <option value="F">FEMENINO</option>
                    </select><br><br>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Modificar_Usuario()"><i class="fa fa-check"><b>&nbsp;Modificar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
        </div>
    </div>
</form>

<script>

$(document).ready(function () {
        listar_administrador();
        $('.js-example-basic-single').select2();
        listar_combo_rol();
        $("#modal_registro").on('shown.bs.modal', function () {
            $("#txt_usu").focus();
        })

    });

       $('.box').boxWidget({
        animationSpeed: 500,
        collapseTrigger: '[data-widget="collapse"]',
        removeTrigger: '[data-widget="remove"]',
        collapseIcon: 'fa-minus',
        expandIcon: 'fa-plus',
        removeIcon: 'fa-times'
    })

    document.getElementById('txr_email').addEventListener('input', function () {
        campo = event.target;//asdsadsa
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;//asdasd21321@gmail.com
        if (emailRegex.test(campo.value)) {
            $(this).css("border", "");
            $("#emailOK").html("");
            $("#validar_email").val("correcto");
        } else {
            $(this).css("border", "1px solid red");
            $("#emailOK").html("Email Incorrecto");
            $("#validar_email").val("incorrecto");
        }

    });

    document.getElementById('txt_email_editar').addEventListener('input', function () {
        campo = event.target;
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if (emailRegex.test(campo.value)) {
            $(this).css("border", "");
            $("#emailOK_editar").html("");
            $("#validar_email_editar").val("correcto");
        } else {
            $(this).css("border", "1px solid red");
            $("#emailOK_editar").html("Email Incorrecto");
            $("#validar_email_editar").val("incorrecto");
        }
    });

 
</script>