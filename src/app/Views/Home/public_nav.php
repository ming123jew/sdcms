<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-11
 * Time: 10:20
 */
?>
<header>
    <div class="hidden-xs header"><!--超小屏幕不显示-->
        <h1 class="logo"> <a href="<?php echo $data['__HOST__'];?>" title="个人技术博客"></a> </h1>
        <ul class="nav hidden-xs-nav">
            <li class="active"><a href="<?php echo $data['__HOST__'];?>"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
            <li><a href="<?php echo url('','Article','list',['id'=>1])?>"><span class="glyphicon glyphicon-erase"></span>诗意人生</a></li>
            <li><a href="<?php echo url('','Article','list',['id'=>2])?>"><span class="glyphicon glyphicon-inbox"></span>编程指南</a></li>
            <li><a href="<?php echo url('','Article','page',['id'=>1])?>"><span class="glyphicon glyphicon-user"></span>关于我们</a></li>
            <li><a href="<?php echo url('','Article','page',['id'=>2])?>"><span class="glyphicon glyphicon-tags"></span>友情链接</a></li>
        </ul>
        <div class="feeds">
            <a class="feed feed-xlweibo" href="https://weibo.com/ming123jew" target="_blank"><i></i>新浪微博</a>
            <a class="feed feed-txweibo" href="javascript:;"><i></i>腾讯微博</a>
            <a class="feed feed-rss" href="javascript:;" onclick="alert('建设中...')"><i></i>订阅本站</a>
            <a class="feed feed-weixin" data-toggle="popover" data-trigger="hover" title="微信扫一扫" data-html="true" data-content="<img src='images/weixin.jpg' alt=''>" href="javascript:;" target="_blank"><i></i>关注微信</a>
        </div>
        <div class="wall" style="display: none;"><a href="javascript:;">读者墙</a> | <a href="javascript:;">标签云</a></div>
    </div>
    <!--/超小屏幕不显示-->
    <div class="visible-xs header-xs"><!--超小屏幕可见-->
        <div class="navbar-header header-xs-logo">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-xs-menu" aria-expanded="false" aria-controls="navbar"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
        </div>
        <div id="header-xs-menu" class="navbar-collapse collapse">
            <ul class="nav navbar-nav header-xs-nav">
                <li class="active"><a href="<?php echo $data['__HOST__'];?>"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
                <li><a href="<?php echo url('','Article','list',['id'=>1])?>"><span class="glyphicon glyphicon-erase"></span>诗意人生</a></li>
                <li><a href="<?php echo url('','Article','list',['id'=>2])?>"><span class="glyphicon glyphicon-inbox"></span>编程指南</a></li>
                <li><a href="<?php echo url('','Article','page',['id'=>1])?>"><span class="glyphicon glyphicon-user"></span>关于我们</a></li>
                <li><a href="<?php echo url('','Article','page',['id'=>2])?>"><span class="glyphicon glyphicon-tags"></span>友情链接</a></li>
            </ul>
            <form class="navbar-form" action="search.php" method="post" style="padding:0 25px;">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="请输入关键字">
                    <span class="input-group-btn">
            <button class="btn btn-default btn-search" type="submit">搜索</button>
            </span> </div>
            </form>
        </div>
    </div>
</header>
