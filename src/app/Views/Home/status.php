<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <base href="<?php echo ($data['HTML_URL']);?>"/>
    <script src="js/jquery-2.0.3.min.js"></script>
</head>

<body>



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
        listenEvent();
    })

    function listenEvent() {
        /**
         * 连接建立时触发
         */
        ws.onopen = function (e) {
            //连接成功
            console.log("connect webim server success.");
            //发送登录信息
            msg = new Object();
            msg.cmd = 'login';
            ws.send($.toJSON(msg));
        };

        //定时获取在线列表

        //有消息到来时触发
        ws.onmessage = function (e) {
            var message = $.evalJSON(e.data);
            var cmd = message.cmd;
            if (cmd == 'login')
            {
                client_id = $.evalJSON(e.data).fd;
                //获取在线列表
                ws.send($.toJSON({cmd : 'getOnline', gid:gid}));
                //获取历史记录
                ws.send($.toJSON({cmd : 'getHistory', gid:gid}));
                //alert( "收到消息了:"+e.data );
            }
            else if(cmd == 'Over')
            {
                console.log(message);
                alert(message.info);
                closeWindows();
            }
            else if (cmd == 'getOnline')
            {
                showOnlineList(message);
            }
            else if (cmd == 'getHistory')
            {
                showHistory(message);
            }
            else if (cmd == 'newUser')
            {
                showNewUser(message);
            }
            else if (cmd == 'fromMsg')
            {
                showNewMsg(message);
            }
            else if (cmd == 'offline')
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