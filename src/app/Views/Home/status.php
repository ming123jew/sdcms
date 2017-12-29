<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <base href="<?php echo ($data['HTML_URL']);?>"/>
    <script src="js/jquery-2.0.3.min.js"></script>
    <script src="js/jquery.json.js"></script>
</head>

<body>

<div id="ws_info"></div>


<script>
    var webim = {
        'server' : 'ws://123.207.0.104:8083'
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
        listenEvent(ws);
    })

    function listenEvent(ws) {
        /**
         * 连接建立时触发
         */
        ws.onopen = function (e) {
            //连接成功
            console.log("connect webim server success.");
            //发送登录信息
            msg = new Object();
            msg.type='connect';
            //msg.type = 'login';

            ws.send($.toJSON(msg));
        };

        //定时获取在线列表

        //有消息到来时触发
        ws.onmessage = function (e) {
            console.log('hee');
            alert('heee');
            console.log(e.data);
            var message = $.evalJSON(e.data);

            var method_name = message.method_name;
            if (method_name == 'login')
            {
                client_id = $.evalJSON(e.data).fd;
                $('#ws_info').html('client_id'+client_id +'.more:'+ $.evalJSON(e.data));
            }
            else if(method_name == 'Over')
            {
                console.log(message);
                alert(message.info);
                closeWindows();
            }
            else if (method_name == 'getOnline')
            {
                showOnlineList(message);
            }
            else if (method_name == 'getHistory')
            {
                showHistory(message);
            }
            else if (method_name == 'newUser')
            {
                showNewUser(message);
            }
            else if (method_name == 'fromMsg')
            {
                showNewMsg(message);
            }
            else if (method_name == 'offline')
            {
                var cid = message.fd;
                delUser(cid);
                showNewMsg(message);
            }
        };

        /**
         * 连接关闭事件
         */
        ws.onclose = function (e) {
            $(document.body).html("<h1 style='text-align: center'>连接已断开，请刷新页面重新登录。</h1>");
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