<!doctype html>
<!--
                              _.._        ,------------.
                           ,'      `.    ( We want you! )
                          /  __) __` \    `-,----------'
                         (  (`-`(-')  ) _.-'
                         /)  \  = /  (
                        /'    |--' .  \
                       (  ,---|  `-.)__`
                        )(  `-.,--'   _`-.
                       '/,'          (  Wy",
                        (_       ,    `/,-' )
                        `.__,  : `-'/  /`--'
                          |     `--'  |
                          `   `-._   /
                           \        (
                           /\ .      \.  ming123jew
                          / |` \     ,-\
                         /  \| .)   /   \
                        ( ,'|\    ,'     :
                        | \,`.`--"/      }
                        `,'    \  |,'    /
                       / "-._   `-/      |
                       "-.   "-.,'|     ;
                      /        _/["---'""]
                     :        /  |"-     '
                     '           |      /
                                 `      |
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>首页 - ming123jew技术博客 - 高性能内容管理CMS</title>
    <base href="<?php echo ($data['HTML_URL']);?>"/>
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link type="text/css" href="css/nprogress.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js" type="text/javascript"></script>
    <script src="js/respond.min.js" type="text/javascript"></script>
    <script src="js/selectivizr-min.js" type="text/javascript"></script>
    <![endif]-->
    <link rel="apple-touch-icon-precomposed" href="images/icon/icon.png">
    <link rel="shortcut icon" href="images/icon/favicon.ico">
    <meta name="Keywords" content="" />
    <meta name="description" content="" />
    <script type="text/javascript">
        //判断浏览器是否支持HTML5
        window.onload = function() {
            if (!window.applicationCache) {
                window.location.href="ie.html";
            }
        }
    </script>
</head>

<body>
<section class="container user-select">
    <header>
        <div class="hidden-xs header"><!--超小屏幕不显示-->
            <h1 class="logo"> <a href="index.html" title="个人技术博客"></a> </h1>
            <ul class="nav hidden-xs-nav">
                <li class="active"><a href="index.html"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
                <li><a href=""><span class="glyphicon glyphicon-erase"></span>网站前端</a></li>
                <li><a href=""><span class="glyphicon glyphicon-inbox"></span>后端技术</a></li>
                <li><a href=""><span class="glyphicon glyphicon-globe"></span>管理系统</a></li>
                <li><a href="about.html"><span class="glyphicon glyphicon-user"></span>关于我们</a></li>
                <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>友情链接</a></li>
            </ul>
            <div class="feeds"> <a class="feed feed-xlweibo" href="" target="_blank"><i></i>新浪微博</a> <a class="feed feed-txweibo" href="" target="_blank"><i></i>腾讯微博</a> <a class="feed feed-rss" href="" target="_blank"><i></i>订阅本站</a> <a class="feed feed-weixin" data-toggle="popover" data-trigger="hover" title="微信扫一扫" data-html="true" data-content="<img src='images/weixin.jpg' alt=''>" href="javascript:;" target="_blank"><i></i>关注微信</a> </div>
            <div class="wall"><a href="readerWall.html" target="_blank">读者墙</a> | <a href="tags.html" target="_blank">标签云</a></div>
        </div>
        <!--/超小屏幕不显示-->
        <div class="visible-xs header-xs"><!--超小屏幕可见-->
            <div class="navbar-header header-xs-logo">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-xs-menu" aria-expanded="false" aria-controls="navbar"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
            </div>
            <div id="header-xs-menu" class="navbar-collapse collapse">
                <ul class="nav navbar-nav header-xs-nav">
                    <li class="active"><a href="index.html"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-erase"></span>网站前端</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-inbox"></span>后端技术</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-globe"></span>管理系统</a></li>
                    <li><a href="about.html"><span class="glyphicon glyphicon-user"></span>关于我们</a></li>
                    <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>友情链接</a></li>
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
    <!--/超小屏幕可见-->
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> <!--banner-->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active"> <a href="content.html" target="_blank"><img src="images/img1.jpg" alt="" /></a>
                        <div class="carousel-caption"> 欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 </div>
                        <span class="carousel-bg"></span> </div>
                    <div class="item"> <a href="content.html" target="_blank"><img src="images/img2.jpg" alt="" /></a>
                        <div class="carousel-caption"> 欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 </div>
                        <span class="carousel-bg"></span> </div>
                    <div class="item"> <a href="content.html" target="_blank"><img src="images/img3.jpg" alt="" /></a>
                        <div class="carousel-caption"> 欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 </div>
                        <span class="carousel-bg"></span> </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
            <!--/banner-->
            <div class="content-block hot-content hidden-xs">
                <h2 class="title"><strong>本周热门排行</strong></h2>
                <ul>
                    <li class="large"><a href="content.html" target="_blank"><img src="images/img3.jpg" alt="">
                            <h3> 欢迎来到个人技术博客技术博客 </h3>
                        </a></li>
                    <li><a href="content.html" target="_blank"><img src="images/logo.jpg" alt="">
                            <h3> 欢迎来到个人技术博客技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a href="content.html" target="_blank"><img src="images/img2.jpg" alt="">
                            <h3> 欢迎来到个人技术博客技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a href="content.html" target="_blank"><img src="images/img1.jpg" alt="">
                            <h3> 欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a href="content.html" target="_blank"><img src="images/logo.jpg" alt="">
                            <h3> 欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                </ul>
            </div>
            <div class="content-block new-content">
                <h2 class="title"><strong>最新文章</strong></h2>
                <div class="row">
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/img1.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/img2.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/img3.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href=""><img src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="" target="_blank" > 个人技术博客技术博客正式上线！ </a> </dt>
                                <dd><span class="name"><a href="" title="由 个人技术博客 发布" rel="author">个人技术博客</a></span> <span class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。</dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"> <span class="tags visible-lg visible-md"> <a href="">本站</a> <a href="">个人技术博客</a> </span> <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span> </div>
                        </div>
                    </div>
                </div>
                <!--<div class="news-more" id="pagination">
                    <a href="">查看更多</a>
                </div>-->
                <div class="quotes" style="margin-top:15px"><span class="disabled">首页</span><span class="disabled">上一页</span><span class="current">1</span><a href="">2</a><a href="">下一页</a><a href="">尾页</a></div>
            </div>
        </div>
    </div>
    <!--/内容-->
    <aside class="sidebar visible-lg"><!--右侧>992px显示-->
        <div class="sentence"> <strong>每日一句</strong>
            <h2>2015年11月1日 星期日</h2>
            <p>你是我人生中唯一的主角，我却只能是你故事中的一晃而过得路人甲。</p>
        </div>
        <div id="search" class="sidebar-block search" role="search">
            <h2 class="title"><strong>搜索</strong></h2>
            <form class="navbar-form" action="search.php" method="post">
                <div class="input-group">
                    <input type="text" class="form-control" size="35" placeholder="请输入关键字">
                    <span class="input-group-btn">
          <button class="btn btn-default btn-search" type="submit">搜索</button>
          </span> </div>
            </form>
        </div>
        <div class="sidebar-block recommend">
            <h2 class="title"><strong>热门推荐</strong></h2>
            <ul>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
            </ul>
        </div>
        <div class="sidebar-block comment">
            <h2 class="title"><strong>最新评论</strong></h2>
            <ul>
                <li data-toggle="tooltip" data-placement="top" title="站长的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>个人技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="读者墙上的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>个人技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>个人技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>个人技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>个人技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
            </ul>
        </div>
    </aside>
    <!--/右侧>992px显示-->
    <footer class="footer">POWERED BY &copy;<a href="#">个人技术博客 XXXXX.COM</a> ALL RIGHTS RESERVED &nbsp;&nbsp;&nbsp;<span><a href="http://www.mycodes.net/" target="_blank">源码之家</a></span> <span style="display:none"><a href="">网站统计</a></span> </footer>
</section>
<div><a href="javascript:;" class="gotop" style="display:none;"></a></div>
<!--/返回顶部-->
<script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="js/nprogress.js" type="text/javascript" ></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    //页面加载
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 1000);
    //返回顶部按钮
    $(function(){
        $(window).scroll(function(){
            if($(window).scrollTop()>100){
                $(".gotop").fadeIn();
            }
            else{
                $(".gotop").hide();
            }
        });
        $(".gotop").click(function(){
            $('html,body').animate({'scrollTop':0},500);
        });
    });
    //提示插件启用
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    //鼠标滑过显示 滑离隐藏
    $(function(){
        $(".carousel").hover(function(){
            $(this).find(".carousel-control").show();
        },function(){
            $(this).find(".carousel-control").hide();
        });
    });
    $(function(){
        $(".hot-content ul li").hover(function(){
            $(this).find("h3").show();
        },function(){
            $(this).find("h3").hide();
        });
    });
    //页面元素智能定位
    $.fn.smartFloat = function() {
        var position = function(element) {
            var top = element.position().top; //当前元素对象element距离浏览器上边缘的距离
            var pos = element.css("position"); //当前元素距离页面document顶部的距离
            $(window).scroll(function() { //侦听滚动时
                var scrolls = $(this).scrollTop();
                if (scrolls > top) { //如果滚动到页面超出了当前元素element的相对页面顶部的高度
                    if (window.XMLHttpRequest) { //如果不是ie6
                        element.css({ //设置css
                            position: "fixed", //固定定位,即不再跟随滚动
                            top: 0 //距离页面顶部为0
                        }).addClass("shadow"); //加上阴影样式.shadow
                    } else { //如果是ie6
                        element.css({
                            top: scrolls  //与页面顶部距离
                        });
                    }
                }else {
                    element.css({ //如果当前元素element未滚动到浏览器上边缘，则使用默认样式
                        position: pos,
                        top: top
                    }).removeClass("shadow");//移除阴影样式.shadow
                }
            });
        };
        return $(this).each(function() {
            position($(this));
        });
    };
    //启用页面元素智能定位
    $(function(){
        $("#search").smartFloat();
    });
    //异步加载更多内容
    jQuery("#pagination a").on("click", function ()
    {
        var _url = jQuery(this).attr("href");
        var _text = jQuery(this).text();
        jQuery(this).attr("href", "javascript:viod(0);");
        jQuery.ajax(
            {
                type : "POST",
                url : _url,
                success : function (data)
                {
                    //将返回的数据进行处理，挑选出class是news-list的内容块
                    result = jQuery(data).find(".row .news-list");
                    //newHref获取返回的内容中的下一页的链接地址
                    nextHref = jQuery(data).find("#pagination a").attr("href");
                    jQuery(this).attr("href", _url);
                    if (nextHref != undefined)
                    {
                        jQuery("#pagination a").attr("href", nextHref);
                    }
                    else
                    {
                        jQuery("#pagination a").html("下一页没有了").removeAttr("href")
                    }
                    // 渐显新内容
                    jQuery(function ()
                    {
                        jQuery(".row").append(result.fadeIn(300));
                        jQuery("img").lazyload(
                            {
                                effect : "fadeIn"
                            });
                    });
                }
            });
        return false;
    });
</script>
</body>
</html>
