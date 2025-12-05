<script type="text/javascript" src="../js/rol.js?rev=<?php echo time(); ?>"></script>
<div class="row">
</div>
<div class="col-md-12">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">BIENVENIDO AL CONTENIDO ROLES</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-widget="remove"><i
                        class="fa fa-minus"></i>
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
            <table id="tabla_rol" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rol</th>
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
                    <h4 class="modal-title"><b>Registro De Rol</b></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <label for="">Nombre rol</label>
                        <input type="text" class="form-control" id="txt_rol" placeholder="Ingrese rol"><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Registrar_Rol()"><i
                            class="fa fa-check"></i><b>&nbsp;Registrar</b></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-close"></i><b>&nbsp;Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        listar_rol();
        $('.js-example-basic-single').select2();
        listar_rol();
        $("#modal_registro").on('shown.bs.modal', function() {
            $("#txt_rol").focus();
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
</script>