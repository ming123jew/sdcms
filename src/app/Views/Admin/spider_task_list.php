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

                <!-- 爬虫任务列表 -->
                <div class="row">

                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','content_list');?>"><i class="typcn typcn-lightbulb"></i>爬虫任务列表</a></h5>
                    <h5 class="row-title" style="margin-left: 20px;"><a href="<?php echo url('','','content_add');?>"><i class="typcn typcn-lightbulb"></i>添加爬虫任务</a></h5>
                    <div class="col-xs-12">
                        <div class="well with-header  with-footer">
                            <div class="header bg-blue">
                                爬虫任务列表
                            </div>
                            <table class="table table-hover">
                                <thead class="bordered-darkorange">
                                <tr>
                                    <th>
                                        排序/ID
                                    </th>
                                    <th>
                                        标题
                                    </th>
                                    <th>
                                        URL
                                    </th>
                                    <th>
                                        发布人
                                    </th>
                                    <th>
                                        状态
                                    </th>
                                    <th>
                                        添加时间
                                    </th>
                                    <th>
                                        操作
                                    </th>
                                </tr>
                                </thead>
                                <?php foreach($data['list'] as $key=>$value){?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $value['id'];?></td>
                                        <td><?php echo $value['title']??0;?>
                                        </td>
                                        <td><?php echo $value['url'];?></td>
                                        <td><?php echo $value['uid'];?></td>
                                        <td><?php if($value['status']){echo '<span class="typcn typcn-tick"></span>';}else{echo  '<span class="typcn typcn-times"></span>';};?></td>
                                        <td><?php echo date('Y-m-d H:i',$value['create_time']);?></td>
                                        <td>
                                            <?php echo $value['str_manage']; ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php } ?>
                            </table>
                            <?php echo $data['page'];?>

                            <div class="footer">
                                <code>class="table table-hover"</code>
                                <div style="clear: both;"></div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- //爬虫任务列表end -->

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
<script src="assets/js/jquery.json.js"></script>
<script src="assets/js/utf.js"></script>
<script src="assets/js/phpSerializer.js"></script>
<script>
    function spider_start(task_id,obj) {
        var json = ('(' + unserialize($(obj).attr('data')) + ')');
        console.log(json)

    }
    function spider_delete(content_id) {
        var url = '<?php echo url('','',"content_delete");?>';
        bootbox.confirm({
            message: '您确认要删除该文章吗？',
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
                    $.post(url, {id:content_id}, function(result) {
                        if(result.status==1){
                            window.location.reload();
                        }
                    })
                }
            }
        });
    }


    //websocket
    var wsUri = "ws://118.89.26.188:8083";
    //var output;
    var websocket;
    var msg = new Object();
    var fd;//当前fd
    var fd_receiver;//接受者fd 如果有
    var uid = <?php echo intval($data['uid']);?>;
    function init() {
        //output = document.getElementById("output");
        //getData();
        runWebSocket('Admin/SpiderWs','connect');

    }

    function runWebSocket(controller,method) {
        websocket = new WebSocket(wsUri);
        websocket.onopen = function (evt){
            onOpen(evt,controller,method)
        };
        websocket.onclose = function (evt) {
            onClose(evt)
        };
        websocket.onmessage = function (evt) {
            onMessage(evt)
        };
        websocket.onerror = function (evt) {
            onError(evt)
        };
    }

    function onOpen(evt,controller,method) {
        //writeToScreen("CONNECTED");
        console.log("CONNECTED:"+evt);
        //doSend("WebSocket rocks");
        msg.controller = controller;
        msg.method=method;
        msg.uid = uid;
        //msg.type = 'login';
        websocket.send($.toJSON(msg));
    }

    function onClose(evt) {
        //writeToScreen("DISCONNECTED");
        console.log("DISCONNECTED:"+evt);
    }

    function onMessage(evt) {
        //writeToScreen('<span style="color: blue;">RESPONSE: ' + evt.data + '</span>');
        //websocket.close();
        var json = $.parseJSON(evt.data);
        var type = json.type;
        switch (type){
            case 'welcome':

                fd = json.fd;
                //加载正在运行的爬虫
                if(json.cur_queue){
                   console.log(json.cur_queue)
                }
                break;
            case 'ready':
                break;
            case 'sendData':
                //发送数据回调
                var obj = {};
                obj = {
                    username: json.data.username,
                    avatar: json.data.avatar,
                    id: json.data.id,
                    type: json.data.type,
                    content: json.data.content
                }
                layim.getMessage(obj);
                sendData('IM/Ws','historyData',localStorage.getItem('layim'));
                console.log(json.data);
                break;
        }
        console.log(json);

    }

    function onError(evt) {
        //writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
        console.log(evt.data);
    }

    function doSend(message) {
        //writeToScreen("SENT: " + message);
        websocket.send(message);
    }

    function writeToScreen(message) {
        var pre = document.createElement("p");
        pre.style.wordWrap = "break-word";
        pre.innerHTML = message;
        output.appendChild(pre);
    }

    window.addEventListener("load", init, false);



    function sendData(controller,method,message) {
        if (!websocket) {
            return false;
        }
        msg.controller = controller;
        msg.method=method;
        //msg.type = 'login';
        msg.message = message;
        msg.fd = fd;
        msg.uid = uid;
        websocket.send($.toJSON(msg));

        return false
    }


</script>

</body>
<!--  /Body -->
</html>
