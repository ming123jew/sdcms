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

    <link rel="stylesheet" href="../layui-v2.2.45/layui/css/layui.css?t=1512984638002"  media="all">
    <link rel="stylesheet" href="../layui-v2.2.45/layui/css/global.css?t=1512984638002" media="all">

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

                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','content_list');?>"><i class="typcn typcn-lightbulb"></i>内容列表</a></h5>
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','content_add');?>"><i class="typcn typcn-lightbulb"></i>添加内容</a></h5>

                    <div class="col-xs-12">
                        <div class="widget flat radius-bordered">
                            <div class="widget-header bg-themeprimary">
                                <span class="widget-caption">添加文章</span>
                            </div>

                            <div class="widget-body">
                                <form id="form" method="post" class="form-horizontal">
                                    <input name="info[id]" id="id" type="hidden" value="<?php echo $data['d_content_model']['id']??0;?>"/>
                                    <div class="widget-main ">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs tabs-flat" id="myTab11">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#tab1">
                                                        基本选项
                                                    </a>
                                                </li>
                                                <li>
                                                    <a data-toggle="tab" href="#tab2">
                                                        内容
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content tabs-flat">
                                                <div id="tab1" class="tab-pane active">
                                                    <div class="widget radius-bordered">
                                                        <div class="widget-header" style="display: none;">
                                                            <span class="widget-caption">基本选项</span>
                                                        </div>
                                                        <div class="widget-body">

                                                            <div class="form-title">
                                                                基本选项
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">请选择栏目：</label>
                                                                <div class="col-lg-4">
                                                                    <input type="hidden" name="info[oldcatid]" value="<?php echo $data['d_content_model']['catid']??'';?>"/>
                                                                    <select class="form-control" name="info[catid]" style="">
                                                                        <option value="">≡ 请选择 ≡</option>
                                                                        <?php echo $data['selectCategorys'];?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">标题：</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" name="info[title]" value="<?php echo $data['d_content_model']['title']??'';?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">来源：</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" name="info[copyfrom]" type="text" value="<?php echo $data['d_content_model']['copyfrom']??'';?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">关键词：</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" name="info[keywords]" type="text" value="<?php echo $data['d_content_model']['keywords']??'';?>"/> * 多个使用空格分开
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">缩略图：</label>
                                                                <div class="col-lg-8">
                                                                    <div class="layui-upload-drag" id="test10" style="float: left;">
                                                                        <i class="layui-icon">&#xe67c;</i>
                                                                        <p>点击上传，或将文件拖拽到此处</p>
                                                                    </div>
                                                                    <div style="float: left;">
                                                                        <img src="<?php echo $data['d_content_model']['thumb']??'';?>" id="show_img" width="200" style="width: 200px;margin: 0 18px;"/>
                                                                    </div>
                                                                    <div style="clear: both;padding-top: 6px;"></div>
                                                                    <input class="form-control" id="thumb" name="info[thumb]" type="text" value="<?php echo $data['d_content_model']['thumb']??'';?>"/>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">简要：</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="info[description]" class="form-control" rows="3"><?php echo $data['d_content_model']['description']??'';?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">跳转：</label>
                                                                <div class="col-lg-8">
                                                                    <input style="position: initial;opacity: inherit;" name="info[isgourl]" type="checkbox" id="isgourl" onclick="rusegourl();" <?php if(isset($data['d_content_model']['gourl'])&&$data['d_content_model']['gourl']){?>checked="checked"<?php } ?>>
                                                                    <input class="form-control" id="gourl" name="info[gourl]" type="text" value=""  <?php if(empty($data['d_content_model']['gourl'])){?>disabled="disabled"<?php } ?>/>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">状态：</label>
                                                                <div class="col-lg-8">
                                                                    <input style="position: initial;opacity: inherit;" type="radio" name="info[status]" checked="checked" value="1">开启
                                                                    <input style="position: initial;opacity: inherit;" type="radio" name="info[status]" checked="" value="0">禁用
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-4 control-label">推荐：</label>
                                                                <div class="col-lg-8">
                                                                    <input style="position: initial;opacity: inherit;" name="info[flag][]" value="p" type="checkbox"  <?php if(isset($data['d_content_model']['flag'])&&strpos($data['d_content_model']['flag'],'p')!==false){?>checked="checked"<?php } ?>>幻灯&nbsp;&nbsp;
                                                                    <input style="position: initial;opacity: inherit;" name="info[flag][]" value="t" type="checkbox" <?php if(isset($data['d_content_model']['flag'])&&strpos($data['d_content_model']['flag'],'t')){?>checked="checked"<?php } ?>>头条&nbsp;&nbsp;
                                                                    <input style="position: initial;opacity: inherit;" name="info[flag][]" value="r" type="checkbox"  <?php if(isset($data['d_content_model']['flag'])&&strpos($data['d_content_model']['flag'],'r')){?>checked="checked"<?php } ?>>推荐&nbsp;&nbsp;
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-offset-4 col-lg-8">
                                                                    <button class="btn btn-palegreen" type="submit">Validate</button>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="tab2" class="tab-pane">
                                                    <div class="widget radius-bordered">
                                                        <div class="widget-header" style="display: none;">
                                                            <span class="widget-caption">编辑内容</span>
                                                        </div>
                                                        <div class="widget-body">

                                                            <div class="form-title">
                                                                文章内容
                                                            </div>

                                                            <div class="form-group">

                                                                <div class="editor">
                                                                    <script id="editor" type="text/plain">
                                                                        <?php
                                                                        if(isset($data['d_content_model']['body'])){
                                                                            echo  htmlspecialchars_decode($data['d_content_model']['body']);
                                                                        }
                                                                        ?></script>
                                                                    <button type="button" onclick="getLocalData()" >获取草稿箱内容</button>
                                                                    <button type="button" onclick="clearLocalData()" >清空草稿箱</button>
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-lg-offset-4 col-lg-8">
                                                                    <button class="btn btn-palegreen" type="submit">Validate</button>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
<script type="text/javascript">
    <!--
    var ueditor_server_url = '<?php echo url("Admin","Ueditor","index",['token'=>$data['token']]);?>';
    //-->
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['__HOST__'];?>ueditor1_4_3_3/utf8/ueditor.config.js?v=1.3"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $data['__HOST__'];?>ueditor1_4_3_3/utf8/ueditor.all.min.js?v=1.7"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="<?php echo $data['__HOST__'];?>ueditor1_4_3_3/utf8/lang/zh-cn/zh-cn.js"></script>

<script>
    function rusegourl() {
        var test = document.getElementById("isgourl").checked;
        if(test) {
            $('#gourl').attr('disabled',false);
            //var oEditor = CKEDITOR.instances.content;
            // oEditor.insertHtml('　');
            //return false;
        } else {
            $('#gourl').attr('disabled','true');
        }
    }
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例

    var ue = UE.getEditor('editor');
    function getLocalData () {
        //alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
        UE.getEditor('editor').setContent(UE.getEditor('editor').execCommand( "getlocaldata" ));
    }

    function clearLocalData () {
        UE.getEditor('editor').execCommand( "clearlocaldata" );
        alert("已清空草稿箱")
    }

    function catchRemoteImage(){
        UE.fireEvent("catchRemoteImage"); //editor换成你自己在实例化编辑器时候定义的名字

    }
    $(document).ready(function () {

        $("#form").bootstrapValidator({
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
            excluded: [],//':hidden', ':not(:visible)'
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
                var id=parseInt($('#id').val());
                // 实用ajax提交表单
                if(id==0){
                    var post_url = '<?php echo  url('','','content_add');?>';
                }else{
                    var post_url = '<?php echo  url('','','content_edit');?>';
                }
                $.post(post_url, form.serialize(), function(result) {
                    // .自定义回调逻辑
                    if(result.status==1){
                        $("#modal-success").find(".modal-body").html(result.message);
                        $("#modal-success").modal("show");
                        setTimeout(function () {
                            window.location.href = '<?php echo url('','','content_list');?>';
                        },2000)

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
                'info[catid]': {
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
                        notEmpty:{message:"请选择分类."},
                    }
                },
                'info[title]': {
                    //隐藏或显示 该字段的验证
                    enabled: true,
                    //错误提示信息
                    message: 'This value is not valid',
                    validators: {
                        notEmpty:{message:"标题不能为空."},
                    }
                },
                'info[catname]': {
                    //隐藏或显示 该字段的验证
                    enabled: true,
                    //错误提示信息
                    message: 'This value is not valid',
                    validators: {
                        notEmpty:{message:"内容名称不能为空."},
                    }
                }
            }
        });

    })


</script>
<div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>
<script src="../layui-v2.2.45/layui/layui.js?t=1512984638002" charset="utf-8"></script>
<script>


    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        //layui上传
        //拖拽上传
        upload.render({
            elem: '#test10'
            ,field:'upfile'
            ,url: ueditor_server_url+'&action=uploadimage&thumb=1'
            ,size: 1024 //限制文件大小，单位 KB
            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.load(); //上传loading
                this.data={oldfile:$('input[name="info[thumb]"]').val()};
            }
            ,done: function(res, index, upload){
                //console.log(res)
                if(res.state=='SUCCESS'){
                    $('input[name="info[thumb]"]').val(res.url);
                    $('#show_img').attr('src',res.url);
                }
                layer.closeAll('loading'); //关闭loading
            }
            ,error: function(index, upload){
                layer.closeAll('loading'); //关闭loading
            }

        });
    })
</script>
</body>
<!--  /Body -->
</html>
