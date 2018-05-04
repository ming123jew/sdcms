<!DOCTYPE html>
<!--
Beyond Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>Login Page</title>
    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="http://118.89.26.188:8082/admin/"/>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <!--Fonts-->
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">-->
    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
    <style>
        .logobox{
            text-align: center !important;
            color: red;
            line-height: 38px;
        }
    </style>
    <?php $this->insert('app::Home/head',['data'=>$data]) ?>
</head>
<!--Head Ends-->
<!--Body-->
<body>
    <div class="login-container animated fadeInDown">
        <div class="loginbox bg-white">
            <div class="loginbox-title">Register</div>
            <div class="loginbox-social" style="display: none;">
                <div class="social-title ">Connect with Your Social Accounts</div>
                <div class="social-buttons">
                    <a href="" class="button-facebook">
                        <i class="social-icon fa fa-facebook"></i>
                    </a>
                    <a href="" class="button-twitter">
                        <i class="social-icon fa fa-twitter"></i>
                    </a>
                    <a href="" class="button-google">
                        <i class="social-icon fa fa-google-plus"></i>
                    </a>
                </div>
            </div>
            <div class="loginbox-or" style="margin: 30px 0;">
                <div class="or-line"></div>
                <div class="or">OR</div>
            </div>
            <div class="loginbox-textbox">
                <input type="text" class="form-control" placeholder="Username" id="username" />
            </div>
            <div class="loginbox-textbox">
                <input type="password" class="form-control" placeholder="Password" id="password" />
            </div>
            <div class="loginbox-textbox">
                <input type="text" class="form-control" placeholder="Eamil" id="email" />
            </div>
            <div class="loginbox-forgot">
                <a href="">Forgot Password?</a>
            </div>
            <div class="loginbox-submit">
                <input type="button" class="btn btn-primary btn-block" value="Register">
            </div>
            <div class="loginbox-signup">
                <a href="<?php url('','User','login');?>">Login</a>
            </div>
        </div>
        <div class="logobox">
            SDCMS内容管理系统v1.0.0
        </div>
    </div>

    <!--Basic Scripts-->
    <script src="assets/js/jquery-2.0.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
        var Host =  "<?php  echo ($data['__HOST__']);?>";
        var HostPost = "<?php  echo ($data['__HOST__']);?>";
        $(function(){

            $('.btn-primary').bind('click',function () {
               var username = $('#username');
               var password = $('#password');
               var email = $('#email');
               var logobox = $('.logobox');
                var logoboxhtml= logobox.html();
               if( !username.val() ){
                   username.focus();
                   logobox.html('*用户名不能为空.');
                   setTimeout(function () {
                       logobox.html(logoboxhtml);
                   },4000)
                   return false;
               }
               if( !password.val() ){
                   password.focus();
                   logobox.html('*密码不能为空.');
                   setTimeout(function () {
                       logobox.html(logoboxhtml);
                   },4000)
                   return false;
               }

               $.post(HostPost+'Home/User/register?v=1.0.0',{username:username.val(),password:password.val(),email:email.val()},function (json) {
                   console.log(json);
                  // e = eval("("+json+")");
                   var e = json;
                   if (e.status){
                       try {
                           //浏览器缓存方式
                           sessionStorage.setItem("LoginTokenStorage", e.token);
                           console.log("LoginTokenStorage write success.")
                       }catch (err){
                           //cookie方式
                           $.cookie('LoginTokenStorage', e, { expires: 1, path: '/' });
                       }
                       window.location.href = Host +"Home/User/login";
                   }else{
                       //清空操作
                       try {
                           sessionStorage.setItem("LoginTokenStorage", null);
                       }catch (err){
                           $.cookie('LoginTokenStorage', null, { expires: 1, path: '/' });
                       }
                       logobox.html(e.message)
                   }
               })
            })

                //token方式
                /**
                sendData={username:username.val(),password:password.val()}
                Headers = null;
                if (JSON.stringify(sendData)!=null){
                    $.ajax({
                        contentType: 'application/x-www-form-urlencoded',
                        headers: Headers,
                        url: HostPost+'Admin/Main/login?v=3&p=3',
                        async: true,
                        type: 'post',
                        data: JSON.stringify(sendData),
                        beforeSend: function(xhr) {
                            LoginTokenStorage = sessionStorage.getItem("LoginTokenStorage");
                            if (LoginTokenStorage!=null){
                                xhr.setRequestHeader("Content-Type","application/json")
                                xhr.setRequestHeader("Authorization", LoginTokenStorage);
                            }
                        },
                        success: function(e) {
                            e = eval("("+e+")")
                            if (e.status){
                                try {
                                    sessionStorage.setItem("LoginTokenStorage", e.token);
                                    console.log("LoginTokenStorage write success.")
                                }catch (err){
                                    $.cookie('LoginTokenStorage', e, { expires: 1, path: '/' });
                                }
                                window.location.href = Host + "Admin/Main/index"
                            }else{
                                try {
                                    sessionStorage.setItem("LoginTokenStorage", null);
                                }catch (err){
                                    $.cookie('LoginTokenStorage', null, { expires: 1, path: '/' });
                                }
                                logobox.html(e.message)
                            }
                        },
                        error: function(e) {
                            logobox.html(e)
                        }
                    });
                }
            })**/
        })
    </script>

</body>
<!--Body Ends-->
</html>
