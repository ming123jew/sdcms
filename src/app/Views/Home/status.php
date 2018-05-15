<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>服务器日志检测</title>
     <base href="<?php echo ($data['HTML_URL']);?>"/>


    <script src="js/jquery-2.0.3.min.js"></script>
    <script src="js/jquery.json.js"></script>
</head>

<body>
<input type="hidden" value="1" id="scroll">
<div id="ws_info"></div>
<div id="ws_log" style="background: black;color: #a7926d;padding: 5em;line-height: 30px;"></div>
<input id="strlen" type="hidden" value="0"/>
<script>

    function scroll() {
        //alert($('#scroll').val())
        if($('#scroll').val()==1){
            var div = document.getElementById('ws_log');
            div.scrollTop = div.scrollHeight;
            $(window).scrollTop(div.scrollHeight)
        }else{

        }
    }

    var webim = {
        'server' : 'ws://<?php echo ($data['HOST_IP']);?>:8083'
    }
    var ws = {};
    var client_id = 0;
    var userlist = {};
    var GET = getRequest();
    function getRequest() {
        var url = location.search; // 获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);

            strs = str.split("&");
            for (var i = 0; i < strs.length; i++) {
                var decodeParam = decodeURIComponent(strs[i]);
                var param = decodeParam.split("=");
                theRequest[param[0]] = param[1];
            }

        }
        return theRequest;
    }
    $(document).ready(function () {
        //使用原生WebSocket
        if (window.WebSocket || window.MozWebSocket) {
            ws = new WebSocket(webim.server);
        }
        //使用flash websocket
        else if (webim.flash_websocket) {
            WEB_SOCKET_SWF_LOCATION = "static/flash-websocket/WebSocketMain.swf";
            $.getScript("static/flash-websocket/swfobject.js", function () {
                $.getScript("static/flash-websocket/web_socket.js", function () {
                    ws = new WebSocket(webim.server);
                });
            });
        }
        //使用http xhr长轮循
        else {
            ws = new Comet(webim.server);
        }
        listenEvent();

    })

    function listenEvent() {

        msg = new Object();
        /**
         * 连接建立时触发
         */
        ws.onopen = function (e) {
            //连接成功
            console.log("connect webim server success.");
            //发送登录信息

            msg.controller = 'Home/Status';
            msg.method='connect';
            //msg.type = 'login';

            ws.send($.toJSON(msg));


        };

        //定时获取错误信息
         setInterval(function () {
             getServerInfo();
         },850)
        var getServerInfo = function(){
            msg.controller = 'Home/Status';
            msg.method = 'getlog';
            msg.num = GET['num'];
            ws.send($.toJSON(msg));

        }

        //有消息到来时触发
        ws.onmessage = function (e) {
            //console.log(e.data);

            var message = $.evalJSON(e.data);

            var type = message.type;
            if (type == 'welcome') {
                client_id = $.evalJSON(e.data).fd;
                $('#ws_info').html('client_id' + client_id + '.more:' + $.evalJSON(e.data));
            }
            else if (type == 'getlog')
            {
                client_id = $.evalJSON(e.data).fd;

                if($.evalJSON(e.data).message!=null && parseInt($('#strlen').val())!=$.evalJSON(e.data).strlen) {
                    var html = '';
                    // $.each($.evalJSON(e.data).message,function (i,e) {
                    //     html += e + '<br />';
                    // })
                    $('#ws_log').html(  $.evalJSON(e.data).message );
                    $('#strlen').val( $.evalJSON(e.data).strlen );
                    scroll();
                }
            }
        };

        /**
         * 连接关闭事件
         */
        ws.onclose = function (e) {
            $(document.body).html("<h1 style='text-align: center'>连接已断开，正在重连...</h1>");
            //重新连接
            setInterval(function () {
                location.reload();
            },300)
        };

        /**
         * 异常事件
         */
        ws.onerror = function (e) {
            $(document.body).html("<h1 style='text-align: center'>服务器[" + webim.server +
                "]: 拒绝了连接. 请检查服务器是否启动. </h1>");
            console.log("onerror: " + e.data);
        };
    }
</script>
</body>
</html>