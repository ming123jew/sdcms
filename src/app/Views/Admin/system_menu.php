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

                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','menu');?>"><i class="typcn typcn-lightbulb"></i>菜单列表</a></h5>
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','menu_add');?>"><i class="typcn typcn-lightbulb"></i>添加菜单</a></h5>
                    <div class="col-xs-12">
                        <div class="well with-header  with-footer">
                            <div class="header bg-blue">
                                菜单列表
                            </div>
                            <table class="table table-hover">
                                <thead class="bordered-darkorange">
                                <tr>
                                    <th>
                                        排序
                                    </th>
                                    <th>
                                        菜单名称
                                    </th>
                                    <th>
                                        应用
                                    </th>
                                    <th>
                                        控制器
                                    </th>
                                    <th>
                                        方法
                                    </th>
                                    <th>
                                        请求
                                    </th>
                                    <th>
                                        状态
                                    </th>
                                    <th>
                                        操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php echo $data['allmenu'];?>
                                </tbody>
                            </table>

                            <div class="footer">
                                <code>class="table table-hover"</code>
                            </div>
                        </div>

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
<script src="assets/js/bootbox/bootbox.js"></script>
<script>
    function menu_delete(menu_id) {
        var url = '<?php echo url('','',"menu_delete");?>';
        bootbox.confirm({
            message: '您确认要删除该选项吗？(*其子菜单也将被删除)',
            buttons: {
                confirm: {
                    label: "确认"
                },
                cancel:{
                    label:"取消"
                }
            },
            callback: function(yes) {
                if(yes) {
                    $.post(url, {menu_id:menu_id}, function(result) {
                        if(result.status==1){
                            window.location.reload();
                        }
                    })
                }
            }
        });
    }
</script>

</body>
<!--  /Body -->
</html>
