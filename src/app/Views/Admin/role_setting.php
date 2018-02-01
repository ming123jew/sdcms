<!DOCTYPE html>
<!--
BeyondAdmin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>首页</title>

    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <base href="<?php echo ($data['HTML_URL']);?>"/>
    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/weather-icons.min.css" rel="stylesheet" />

    <!--Fonts-->
<!--    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">-->

    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/typicons.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
    <style>
        .table_full{

        }
        .checkmod{
            margin-bottom:20px;
            border: 1px solid #ebebeb;padding-bottom: 5px;
        }
        .checkmod dt{
            padding-left:10px;
            height:40px;
            line-height:40px;
            font-weight:bold;
            border-bottom: 1px solid #ebebeb;
            background-color:#ECECEC;
        }
        .checkmod dt{
            margin-bottom: 5px;
            border-bottom-color:#ebebeb;
            background-color:#ECECEC;
        }
        .checkbox , .radio{
            display:inline-block;
            height:20px;
            line-height:20px;
        }
        .checkmod dd{
            padding-left:10px;
            line-height:30px;
        }
        .checkmod dd .checkbox{
            margin:0 10px 0 0;
        }
        .checkmod dd .divsion{
            margin-right:20px;
        }
        .checkmod dt{
            line-height:30px;
            font-weight:bold;
        }

        .rule_check{border: 1px solid #ebebeb;margin: auto;padding: 5px 10px;}
        .menu_parent{margin-bottom: 5px;}
        .radio, .checkbox{margin-top: 0px;}
    </style>
</head>
<!-- /Head -->
<!-- Body -->
<!-- Navbar -->
<?php $this->insert('app::Admin/public_navbar',['data'=>$data]) ?>
<!-- /Navbar -->
<!-- Main Container -->
<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">
            <!-- Page Sidebar Header-->
            <div class="sidebar-header-wrapper">
                <input type="text" class="searchinput" />
                <i class="searchicon fa fa-search"></i>
                <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
            </div>
            <!-- /Page Sidebar Header -->
            <!-- Sidebar Menu -->
            <?php $this->insert('app::Admin/public_menu_db',['data'=>$data]) ?>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Home</a>
                    </li>
                    <li class="active"><?php isset($anchors) ?? '>';?></li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->
            <!-- Page Header -->
            <?php $this->insert('app::Admin/public_page_header',['data'=>$data]) ?>
            <!-- /Page Header -->
            <!-- Page Body -->
            <div class="page-body">

                <!-- 菜单列表 -->
                <div class="row">

                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','role_lists');?>"><i class="typcn typcn-lightbulb"></i>角色列表</a></h5>
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','role_add');?>"><i class="typcn typcn-lightbulb"></i>添加角色</a></h5>
                    <div class="col-xs-12">
                        <form id="form" method="post" class="form-horizontal">
                            <input type="hidden" name="role_id" value="<?php echo $data['cur_role_id'];?>">
                        <div class="well with-header  with-footer">
                            <div class="header bg-blue">
                                权限设置
                            </div>

                            <div class="row">
                                <div class="table_full">
                                    <?php echo $data['html']?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <button class="btn btn-palegreen" type="button" id="save">保存</button>

                                </div>
                            </div>

                            <div class="footer">
                                <code>class="table table-hover"</code>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- //菜单列表end -->


            </div>
            <!-- /Page Body -->

        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

</div>

<!--Basic Scripts-->
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="assets/js/beyond.min.js"></script>

<script>
    $(document).ready(function () {

        $("#save").bind('click',function () {
            // 实用ajax提交表单
            $.post('<?php echo url('','','role_setting');?>', $('#form').serialize(), function(result) {
                // .自定义回调逻辑
                if(result.status==1){
                    $("#modal-success").find(".modal-body").html(result.message);
                    $("#modal-success").modal("show");
                }else{
                    $("#modal-warning").find(".modal-body").html(result.message);
                    $("#modal-warning").modal("show");
                }
                console.log(result);
            }, 'json');
        })
    })
</script>

<script type="text/javascript">

            function checknode(obj) {

                var chk = $("input[type='checkbox']");
                var count = chk.length;
                var num = chk.index(obj);
                var level_top = level_bottom = chk.eq(num).attr('level');

                for (var i = num; i >= 0; i--) {
                    var le = chk.eq(i).attr('level');
                    if (eval(le) < eval(level_top)) {
                        chk.eq(i).prop("checked", true);
                        var level_top = level_top - 1;
                    }
                }

                for (var j = num + 1; j < count; j++) {
                    var le = chk.eq(j).attr('level');
                    if (chk.eq(num).prop("checked")) {
                        if (eval(le) > eval(level_bottom)) {

                            chk.eq(j).prop("checked", true);
                        }
                        else if (eval(le) == eval(level_bottom)) {
                            break;
                        }
                    } else {
                        if (eval(le) > eval(level_bottom)) {
                            chk.eq(j).prop("checked", false);
                        } else if (eval(le) == eval(level_bottom)) {
                            break;
                        }
                    }
                }
            }
</script>
</body>
<!--  /Body -->
</html>
