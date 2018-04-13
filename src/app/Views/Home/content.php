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
    <title><?php echo $data['article']['title'];?> - ming123jew技术博客 - 高性能内容管理CMS</title>
    <base href="<?php echo ($data['HTML_URL']);?>"/>
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/nprogress.css" type="text/css" rel="stylesheet">
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
    <?php $this->insert('app::Home/public_nav',['data'=>$data]) ?>
    <!--/超小屏幕可见-->
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <header class="news_header">
                <h2><?php echo $data['article']['title'];?></h2>
                <ul>
                    <li><?php echo $data['article']['username'];?> 发布于 <?php echo date('Y-m-d',$data['article']['create_time']);?></li>
                    <li>栏目：<a href="" title="" target="_blank"><?php echo $data['article']['catid'];?></a></li>
                    <li>来源：<a href="" title="" target="_blank"><?php echo $data['article']['copyfrom'];?></a></li>
                    <li>共 <strong><?php echo $data['article']['views'];?></strong> 人围观 </li>
<!--                    <li><strong>123</strong> 个不明物体</li>-->
                </ul>
            </header>
            <article class="news_content">
                <?php echo $data['article']['body'];?>
            </article>
            <div class="reprint">转载请说明出处：<a href="" title="" target="_blank">ming123jew技术博客</a> » <a href="" title="" target="_blank">欢迎来到ming123jew个人技术博客</a></div>
            <div class="zambia"><a href="javascript:;" name="zambia" rel=""><span class="glyphicon glyphicon-thumbs-up"></span> 赞（0）</a></div>
            <?php if(!empty($data['article']['keywords'])){ $arr_keywords=explode(' ',trim($data['article']['keywords']));?>
            <div class="tags news_tags">标签：
                <?php foreach( $arr_keywords as $kk=>$vv){?>
                <span data-toggle="tooltip" data-placement="bottom" title="查看关于 本站 的文章"><a href="#"><?php echo $vv;?></a></span>
                <?php } ?>
            </div>
            <?php } ?>
            <nav class="page-nav"> <span class="page-nav-prev">上一篇<br />
        <a href="" rel="prev">欢迎来到个人技术博客</a></span> <span class="page-nav-next">下一篇<br />
        <a href="" rel="next">欢迎来到个人技术博客</a></span> </nav>
            <div class="content-block related-content visible-lg visible-md">
                <h2 class="title"><strong>相关推荐</strong></h2>
                <ul>
                    <li><a target="_blank" href=""><img src="images/logo.jpg" alt="">
                            <h3> 欢迎来到个人技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img1.jpg" alt="">
                            <h3> 欢迎来到个人技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img3.jpg" alt="">
                            <h3> 欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img2.jpg" alt="">
                            <h3> 欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img2.jpg" alt="">
                            <h3> 欢迎来到个人技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img3.jpg" alt="">
                            <h3> 欢迎来到个人技术博客,在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/img1.jpg" alt="">
                            <h3> 欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                    <li><a target="_blank" href=""><img src="images/logo.jpg" alt="">
                            <h3> 欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 </h3>
                        </a></li>
                </ul>
            </div>
            <div class="content-block comment">
                <h2 class="title"><strong>评论</strong></h2>
                <form action="comment.php" method="post" class="form-inline" id="comment-form">
                    <div class="comment-title">
                        <div class="form-group">
                            <label for="commentName">昵称：</label>
                            <input type="text" name="commentName" class="form-control" id="commentName" placeholder="技术博客">
                        </div>
                        <div class="form-group">
                            <label for="commentEmail">邮箱：</label>
                            <input type="email" name="commentEmail" class="form-control" id="commentEmail" placeholder="admin@xxxx.com">
                        </div>
                    </div>
                    <div class="comment-form">
                        <textarea placeholder="你的评论可以一针见血" name="commentContent"></textarea>
                        <div class="comment-form-footer">
                            <div class="comment-form-text">请先 <a href="javascript:;">登录</a> 或 <a href="javascript:;">注册</a>，也可匿名评论 </div>
                            <div class="comment-form-btn">
                                <button type="submit" class="btn btn-default btn-comment">提交评论</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="comment-content">
                    <ul>
                        <li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客编辑</strong> (2015-10-18) 说：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>令狐冲</strong> (2015-10-18) 说：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>任盈盈</strong> (2015-10-18) 说：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></li>
                    </ul>
                </div>
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
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
                <li><a target="_blank" href=""> <span class="thumb"><img src="images/icon/icon.png" alt=""></span> <span class="text">个人技术博客的SHORTCUT和ICON图标 ...</span> <span class="text-muted">阅读(2165)</span></a></li>
            </ul>
        </div>
        <div class="sidebar-block comment">
            <h2 class="title"><strong>最新评论</strong></h2>
            <ul>
                <li data-toggle="tooltip" data-placement="top" title="站长的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="读者墙上的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
                <li data-toggle="tooltip" data-placement="top" title="个人技术博客的SHORTCUT和ICON图标...的评论"><a target="_blank" href=""><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>技术博客站长</strong> (2015-10-18) 说：<br />
          欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></a></li>
            </ul>
        </div>
    </aside>
    <!--/右侧>992px显示-->
    <footer class="footer">POWERED BY &copy;<a href="#">技术博客 XXXXX.COM</a> ALL RIGHTS RESERVED &nbsp;&nbsp;&nbsp;<span><a href="http://www.mycodes.net/" target="_blank">源码之家</a></span> <span style="display:none"><a href="">网站统计</a></span> </footer>
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
    //banner
    $(function(){
        $(".carousel").hover(function(){
            $(this).find(".carousel-control").show();
        },function(){
            $(this).find(".carousel-control").hide();
        });
    });
    //本周热门
    $(function(){
        $(".hot-content ul li").hover(function(){
            $(this).find("h3").show();
        },function(){
            $(this).find("h3").hide();
        });
    });
    //相关推荐
    $(function(){
        $(".related-content ul li").hover(function(){
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


    //ajax更新点赞值
    $(function(){
        $(".content .zambia a").click(function(){
            var zambia = $(this);
            var id = zambia.attr("rel"); //对应id
            zambia.fadeOut(1000); //渐隐效果
            $.ajax({
                type:"POST",
                url:"zambia.php",
                data:"id="+id,
                cache:false, //不缓存此页面
                success:function(data){
                    zambia.html(data);
                    zambia.fadeIn(1000); //渐显效果
                }
            });
            return false;
        });
    })
</script>
</body>
</html>
