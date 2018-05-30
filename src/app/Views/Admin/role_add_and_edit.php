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
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','role_lists');?>"><i class="typcn typcn-lightbulb"></i>角色列表</a></h5>
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','role_add');?>"><i class="typcn typcn-lightbulb"></i>添加角色</a></h5>

                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <div class="widget radius-bordered">
                                <div class="widget-header">
                                    <span class="widget-caption"><?php echo isset($data['d_role_model']['id'])?'编辑角色':'添加角色'; ?></span>
                                </div>
                                <div class="widget-body">
                                    <form id="Form" method="post" class="form-horizontal">
                                        <input type="hidden" id="role_id" name="info[id]" value="<?php echo $data['d_role_model']['id']??0;?>">
                                        <div class="form-title" style="display: none">
                                            Basic Validator With HTML Attributes
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">角色名称</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="info[role_name]" value="<?php echo $data['d_role_model']['role_name']??'';?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">角色描述</label>
                                            <div class="col-lg-8">
                                                <textarea name="info[description]" class="form-control" rows="3"><?php echo $data['d_role_model']['description']??'';?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">状态</label>
                                            <div class="col-lg-8">
                                                <input style="position: initial;opacity: inherit;" type="radio" name="info[status]" <?php echo  isset( $data['d_role_model']['status'])&&$data['d_role_model']['status']==1 ? 'checked':'';?> value="1">显示
                                                <input style="position: initial;opacity: inherit;" type="radio" name="info[status]" <?php echo  isset( $data['d_role_model']['status'])&&$data['d_role_model']['status']==0 ? 'checked':'';?> value="0">隐藏
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-offset-4 col-lg-8">
                                                <button class="btn btn-palegreen" type="submit">提交</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
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
<!--Page Related Scripts-->
<script src="assets/js/validation/bootstrapValidator.js"></script>

<script>

    $(document).ready(function () {
        var role_id =  $('#role_id').val();
        console.log(role_id)
        $("#Form").bootstrapValidator({
            /**
             *  指定不验证的情况
             *  值可设置为以下三种类型：
             *  1、String  ':disabled, :hidden, :not(:visible)'
             *  2、Array  默认值  [':disabled', ':hidden', ':not(:visible)']
             *  3、带回调函数
             [':disabled', ':hidden', function($field, validator) {
            // $field 当前验证字段dom节点
            // validator 验证实例对象
            // 可以再次自定义不要验证的规则
            // 必须要return，return true or false;
            return !$field.is(':visible');
        }]
             */
            excluded: [ ':hidden', ':not(:visible)'],
            /**
             * 指定验证后验证字段的提示字体图标。（默认是bootstrap风格）
             * Bootstrap 版本 >= 3.1.0
             * 也可以使用任何自定义风格，只要引入好相关的字体文件即可
             * 默认样式
             .form-horizontal .has-feedback .form-control-feedback {
            top: 0;
            right: 15px;
        }
             * 自定义该样式覆盖默认样式
             .form-horizontal .has-feedback .form-control-feedback {
            top: 0;
            right: -15px;
        }
             .form-horizontal .has-feedback .input-group .form-control-feedback {
            top: 0;
            right: -30px;
        }
             */
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            /**
             * 生效规则（三选一）
             * enabled 字段值有变化就触发验证
             * disabled,submitted 当点击提交时验证并展示错误信息
             */
            live: 'enabled',
            /**
             * 为每个字段指定通用错误提示语
             */
            message: 'This value is not valid',
            /**
             * 指定提交的按钮，例如：'.submitBtn' '#submitBtn'
             * 当表单验证不通过时，该按钮为disabled
             */
            submitButtons: 'button[type="submit"]',
            /**
             * submitHandler: function(validator, form, submitButton) {
             *   //validator: 表单验证实例对象
             *   //form  jq对象  指定表单对象
             *   //submitButton  jq对象  指定提交按钮的对象
             * }
             * 在ajax提交表单时很实用
             *   submitHandler: function(validator, form, submitButton) {
            // 实用ajax提交表单
            $.post(form.attr('action'), form.serialize(), function(result) {
                // .自定义回调逻辑
            }, 'json');
         }
             *
             */
            submitHandler: function (validator, form, submitButton) {
                // Do nothing
                //alert('here.')
                if(role_id==0){
                    var url = '<?php echo url('','','role_add');?>';
                }else{
                    var url = '<?php echo url('','','role_edit');?>';
                }

                // 实用ajax提交表单
                $.post(url, form.serialize(), function(result) {
                    // .自定义回调逻辑
                    if(result.status==1){
                        $("#modal-success").find(".modal-body").html(result.message);
                        $("#modal-success").modal("show");

                    }else{
                        $("#modal-warning").find(".modal-body").html(result.message);
                        $("#modal-warning").modal("show");
                    }
                }, 'json');
            },
            /**
             * 为每个字段设置统一触发验证方式（也可在fields中为每个字段单独定义），默认是live配置的方式，数据改变就改变
             * 也可以指定一个或多个（多个空格隔开） 'focus blur keyup'
             */
            trigger: null,
            /**
             * Number类型  为每个字段设置统一的开始验证情况，当输入字符大于等于设置的数值后才实时触发验证
             */
            threshold: null,

            /**
             * 表单域配置
             */
            fields: {
                //多个重复
                'info[role_name]': {
                    //隐藏或显示 该字段的验证
                    enabled: true,
                    //错误提示信息
                    message: 'This value is not valid',
                    /**
                     * 定义错误提示位置  值为CSS选择器设置方式
                     * 例如：'#firstNameMeg' '.lastNameMeg' '[data-stripe="exp-month"]'
                     */
                    container: null,
                    /**
                     * 定义验证的节点，CSS选择器设置方式，可不必须是name值。
                     * 若是id，class, name属性，<fieldName>为该属性值
                     * 若是其他属性值且有中划线链接，<fieldName>转换为驼峰格式  selector: '[data-stripe="exp-month"]' =>  expMonth
                     */
                    selector: null,
                    /**
                     * 定义触发验证方式（也可在fields中为每个字段单独定义），默认是live配置的方式，数据改变就改变
                     * 也可以指定一个或多个（多个空格隔开） 'focus blur keyup'
                     */
                    trigger: null,
                    // 定义每个验证规则
                    validators: {
                    //多个重复
                    //官方默认验证参照  http://bv.doc.javake.cn/validators/
                    // 注：使用默认前提是引入了bootstrapValidator-all.js
                    // 若引入bootstrapValidator.js没有提供常用验证规则，需自定义验证规则哦
                        /**
                         *                                                        data-bv-message="The username is not valid"
                         data-bv-notempty="true"
                         data-bv-notempty-message="名称不能为空."/>
                         <!--   data-bv-regexp="true"
                         data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                         data-bv-regexp-message="The username can only consist of alphabetical, number, dot and underscore"
                         data-bv-stringlength="true"
                         data-bv-stringlength-min="6"
                         data-bv-stringlength-max="30"
                         data-bv-stringlength-message="The username must be more than 6 and less than 30 characters long"
                         data-bv-different="true"
                         data-bv-different-field="password"
                         data-bv-different-message="The username and password cannot be the same as each other"-->
                         */
                    //<validatorName>: <validatorOptions>
                        notEmpty:{message:"请输入角色名称."},
                    }
                },
            }
        });

    })



</script>

</body>
<!--  /Body -->
</html>
