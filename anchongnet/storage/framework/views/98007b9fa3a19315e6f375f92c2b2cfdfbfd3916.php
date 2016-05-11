<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加商品</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/dist/dfonts/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/admin/dist/dfonts/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/admin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/admin/css/diyUpload.css">
    <link rel="stylesheet" href="/admin/css/webuploader.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        *{margin: 0;padding: 0;}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php echo $__env->make('inc.admin.mainHead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php echo $__env->make('inc.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>添加商品</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach($errors->all() as $error): ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php
                                if(isset($mes)){
                                    echo "<div class='alert alert-info' role='alert'>$mes</div>";
                                };
                            ?>
                            <form role="form" class="form-horizontal" action="/commodity" method="post">
                                <input type="hidden" name="sid" id="sid" value="<?php echo e($sid); ?>">
                                <input type="hidden" name="gid" id="gid" value="<?php echo e($gid); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品分类</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <select class="form-control" id="mainselect" name="mainselect" required>
                                                    <option value="">请选择</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <select class="form-control" id="midselect" name="midselect" required>
                                                    <option value="">请选择</option>
                                                </select>
                                            </div>
                                        </div><!--end row-->
                                    </div><!--end col-sm-10-->
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">商品名称</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="name" id="name" class="form-control" required value="<?php echo e(old('name')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">属性</label>
                                    <div class="col-sm-8">
                                        <table class="table text-center">
                                            <thead>
                                            <tr>
                                                <th class="text-center col-sm-1">属性名</th>
                                                <th class="text-center col-sm-2">属性值</th>
                                                <th class="text-center col-sm-1">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody id="stock">
                                            <tr class="line">
                                                <td>
                                                    <input type="text" name="attrname[]" class="form-control" required placeholder="如：颜色" />
                                                </td>
                                                <td>
                                                    <textarea name="attrvalue[]" class="form-control" required rows="5" placeholder="多个属性值之间请用空格隔开，如：红色 绿色 蓝色"></textarea>
                                                </td>
                                                <td>
                                                    <button type="button" class="addcuspro btn-sm btn-link" title="添加">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    <button type="button" class="delcuspro btn-sm btn-link" title="删除">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <ul class="form-group hidden" id="img">
                                </ul>
                                <div class="gal form-group">
                                    <label class="col-sm-2 control-label text-right">商品详情图片<br></label>
                                    <div id="detailbox" class="col-sm-10">
                                        <div id="detail"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <br><br>
                                <div class="gal form-group">
                                    <label class="col-sm-2 control-label text-right">相关参数图片<br></label>
                                    <div id="parambox" class="col-sm-10">
                                        <div id="param"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <br><br>
                                <div class="gal form-group">
                                    <label class="col-sm-2 control-label text-right">相关资料图片<br></label>
                                    <div id="databox" class="col-sm-10">
                                        <div id="data"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="description">描述</label>
                                    <div class="col-sm-3">
                                        <textarea name="description" id="description" class="form-control" rows="5"><?php echo e(old('description')); ?></textarea>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group text-center">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info">添加商品</button>
                                    </div>
                                </div><!--end form-group text-center-->
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <input type="hidden" id="activeFlag" value="treegood">
    <?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/webuploader.html5only.min.js"></script>
<script src="/admin/js/diyUpload.js"></script>
<script src="/admin/js/createcommodity.js"></script>
</body>
</html>