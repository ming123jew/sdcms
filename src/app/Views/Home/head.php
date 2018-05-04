<script type="text/javascript">
//判断浏览器是否支持HTML5
window.onload = function() {

    //判断是否是手机
    var system={win:false,mac:false,xll:false};var p=navigator.platform;system.win=p.indexOf("Win")==0;system.mac=p.indexOf("Mac")==0;system.x11=(p=="X11")||(p.indexOf("Linux")==0);if(system.win||system.mac||system.xll){
        //电脑
        var theUA = window.navigator.userAgent.toLowerCase();
        if ((theUA.match(/msie\s\d+/) && theUA.match(/msie\s\d+/)[0]) || (theUA.match(/trident\s?\d+/) && theUA.match(/trident\s?\d+/)[0])) {
            var ieVersion = theUA.match(/msie\s\d+/)[0].match(/\d+/)[0] || theUA.match(/trident\s?\d+/)[0];
            if (ieVersion < 9) {
                window.location.href="<?php echo ($data['__HOST__']);?>Home/Main/ie";
            };
        }
    }else{
        //手机
        ///判断浏览器是否支持HTML5
        if (!window.applicationCache) {
            window.location.href="<?php echo ($data['__HOST__']);?>Home/Main/ie";
        }
    }
}
</script>