<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>LayIM 3.x PC版本地演示</title>
<base href="<?php echo ($data['HTML_URL']);?>"/>
<link rel="stylesheet" href="../layui/css/layui.css">
<style>
html{background-color: #333;}
</style>
</head>
<body>
<script src="../layui/layui.js"></script>
<script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.json.js"></script>
<script>

if(!/^http(s*):\/\//.test(location.href)){
  alert('请部署到localhost上查看该演示');
}

layui.use('layim', function(layim){


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
        runWebSocket('IM/Ws','connect');

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
                //加载历史信息
                if(json.history){
                    localStorage.setItem('layim',json.history.content);
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

  
  //演示自动回复
  var autoReplay = [
    '您好，我现在有事不在，一会再和您联系。', 
    '你没发错吧？face[微笑] ',
    '洗澡中，请勿打扰，偷窥请购票，个体四十，团体八折，订票电话：一般人我不告诉他！face[哈哈] ',
    '你好，我是主人的美女秘书，有什么事就跟我说吧，等他回来我会转告他的。face[心] face[心] face[心] ',
    'face[威武] face[威武] face[威武] face[威武] ',
    '<（@￣︶￣@）>',
    '你要和我说话？你真的要和我说话？你确定自己想说吗？你一定非说不可吗？那你说吧，这是自动回复。',
    'face[黑线]  你慢慢说，别急……',
    '(*^__^*) face[嘻嘻] ，是贤心吗？'
  ];
  
  //基础配置
  layim.config({

    //初始化接口
    init: {
        //http://118.89.26.188:8081/layui/json/getList.json
      url: '<?php echo url("IM","Index","init",['uid'=>$data['uid']]);?>'
      ,data: {fd:fd}
    }
    
    //或采用以下方式初始化接口
    /*
    ,init: {
      mine: {
        "username": "LayIM体验者" //我的昵称
        ,"id": "100000123" //我的ID
        ,"status": "online" //在线状态 online：在线、hide：隐身
        ,"remark": "在深邃的编码世界，做一枚轻盈的纸飞机" //我的签名
        ,"avatar": "a.jpg" //我的头像
      }
      ,friend: []
      ,group: []
    }
    */
    

    //查看群员接口
    ,members: {
        //http://118.89.26.188:8081/layui/json/getMembers.json
      url: '<?php echo url("IM","Index","getMembers",['uid'=>$data['uid']]);?>'
      ,data: {}
    }
    
    //上传图片接口
    ,uploadImage: {
      url: '/upload/image' //（返回的数据格式见下文）
      ,type: '' //默认post
    } 
    
    //上传文件接口
    ,uploadFile: {
      url: '/upload/file' //（返回的数据格式见下文）
      ,type: '' //默认post
    }
    
    //扩展工具栏
    ,tool: [{
      alias: 'code'
      ,title: '代码'
      ,icon: '&#xe64e;'
    }]
    
    //,brief: true //是否简约模式（若开启则不显示主面板）
    
    //,title: 'WebIM' //自定义主面板最小化时的标题
    //,right: '100px' //主面板相对浏览器右侧距离
    //,minRight: '90px' //聊天面板最小化时相对浏览器右侧距离
    ,initSkin: '5.jpg' //1-5 设置初始背景
    //,skin: ['aaa.jpg'] //新增皮肤
    //,isfriend: false //是否开启好友
    //,isgroup: false //是否开启群组
    //,min: true //是否始终最小化主面板，默认false
    ,notice: true //是否开启桌面消息提醒，默认false
    //,voice: false //声音提醒，默认开启，声音文件为：default.wav
    
    ,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
    ,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
    ,chatLog: layui.cache.dir + 'css/modules/layim/html/chatLog.html' //聊天记录页面地址，若不开启，剔除该项即可
    
  });

  /*
  layim.chat({
    name: '在线客服-小苍'
    ,type: 'kefu'
    ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.180.180.180/7f5f6861jw1e8qgp5bmzyj2050050aa8.jpg'
    ,id: -1
  });
  layim.chat({
    name: '在线客服-心心'
    ,type: 'kefu'
    ,avatar: 'http://tva1.sinaimg.cn/crop.219.144.555.555.180/0068iARejw8esk724mra6j30rs0rstap.jpg'
    ,id: -2
  });
  layim.setChatMin();*/

  //监听在线状态的切换事件
  layim.on('online', function(data){
    console.log(data);
  });
  
  //监听签名修改
  layim.on('sign', function(value){
    //console.log(value);
  });

  //监听自定义工具栏点击，以添加代码为例
  layim.on('tool(code)', function(insert){
    layer.prompt({
      title: '插入代码'
      ,formType: 2
      ,shade: 0
    }, function(text, index){
      layer.close(index);
      insert('[pre class=layui-code]' + text + '[/pre]'); //将内容插入到编辑器
    });
  });
  
  //监听layim建立就绪
  layim.on('ready', function(res){

    //console.log(res.mine);
    
    layim.msgbox(8); //模拟消息盒子有新消息，实际使用时，一般是动态获得
  
    //添加好友（如果检测到该socket）
    // layim.addList({
    //   type: 'group'
    //   ,avatar: "http://tva3.sinaimg.cn/crop.64.106.361.361.50/7181dbb3jw8evfbtem8edj20ci0dpq3a.jpg"
    //   ,groupname: 'Angular开发'
    //   ,id: "12333333"
    //   ,members: 0
    // });
    // layim.addList({
    //   type: 'friend'
    //   ,avatar: "http://tp2.sinaimg.cn/2386568184/180/40050524279/0"
    //   ,username: '冲田杏梨'
    //   ,groupid: 2
    //   ,id: "1233333312121212"
    //   ,remark: "本人冲田杏梨将结束AV女优的工作"
    // });

      //获取服务器端信息
    // setTimeout(function(){
    //   //接受消息（如果检测到该socket）
    //   layim.getMessage({
    //     username: "Hi"
    //     ,avatar: "http://qzapp.qlogo.cn/qzapp/100280987/56ADC83E78CEC046F8DF2C5D0DD63CDE/100"
    //     ,id: "1"
    //     ,type: "friend"
    //     ,content: "临时："+ new Date().getTime()
    //   });
    //
    //   layim.getMessage({
    //     username: "贤心"
    //     ,avatar: "http://tp1.sinaimg.cn/1571889140/180/40030060651/1"
    //     ,id: "100001"
    //     ,type: "friend"
    //     ,content: "嗨，你好！欢迎体验LayIM。演示标记："+ new Date().getTime()
    //   });
    // }, 3000);

  });

  //监听发送消息
  layim.on('sendMessage', function(data){
    data.mine.fd = fd;
    var To = data.to;
    console.log(data);
    
    if(To.type === 'friend'){
      layim.setChatStatus('<span style="color:#FF5722;">对方正在输入。。。</span>');
    }

    //将内容发送到服务器
      sendData('IM/Ws','sendData',data);
      sendData('IM/Ws','historyData',localStorage.getItem('layim'));

    // var obj = {};
    // if(To.type === 'group'){
    //     obj = {
    //         username: '模拟群员'+(Math.random()*100|0),
    //         avatar: layui.cache.dir + 'images/face/'+ (Math.random()*72|0) + '.gif',
    //         id: To.id,
    //         type: To.type,
    //         content: autoReplay[Math.random()*9|0]
    //       }
    // } else {
    //       obj = {
    //         username: To.name,
    //           avatar: To.avatar,
    //               id: To.id,
    //             type: To.type,
    //          content: autoReplay[Math.random()*9|0]
    //       }
    //     layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
    // }
    
    //演示自动回复
    // setTimeout(function(){
    //   var obj = {};
    //   if(To.type === 'group'){
    //     obj = {
    //       username: '模拟群员'+(Math.random()*100|0)
    //       ,avatar: layui.cache.dir + 'images/face/'+ (Math.random()*72|0) + '.gif'
    //       ,id: To.id
    //       ,type: To.type
    //       ,content: autoReplay[Math.random()*9|0]
    //     }
    //   } else {
    //     obj = {
    //       username: To.name,
    //         avatar: To.avatar,
    //             id: To.id,
    //           type: To.type,
    //        content: autoReplay[Math.random()*9|0]
    //
    //     }
    //     layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
    //   }
    //   layim.getMessage(obj);
    // }, 1000);
  });

  //监听查看群员
  layim.on('members', function(data){
    //console.log(data);
  });
  
  //监听聊天窗口的切换
  layim.on('chatChange', function(res){
    var type = res.data.type;
    console.log(res.data.id)
    if(type === 'friend'){
      //模拟标注好友状态
      //layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
    } else if(type === 'group'){
      //模拟系统消息
      layim.getMessage({
        system: true
        ,id: res.data.id
        ,type: "group"
        ,content: '模拟群员'+(Math.random()*100|0) + '加入群聊'
      });
    }
  });

  setInterval(function () {
      //每15分钟进行一次记录
      //var data = Object();
      //console.log(localStorage.getItem('layim'));
      sendData('IM/Ws','historyData',localStorage.getItem('layim'));
  },1000 * 60 * 10 )//10分钟进行一次记录

});



</script>
</body>
</html>
