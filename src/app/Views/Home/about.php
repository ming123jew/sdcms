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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>关于我们 - ming123jew技术博客 - 高性能内容管理CMS</title>
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
    <?php $this->insert('app::Home/head',['data'=>$data]) ?>
</head>

<body>
<section class="container user-select">
    <?php $this->insert('app::Home/public_nav',['data'=>$data]) ?>
    <!--/超小屏幕可见-->
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block about-content">
                <h2 class="title"><strong>关于技术博客</strong></h2>
                <p class="line-title">想要深入了解<span>技术博客？</span></p>
                <p>个人技术博客的		内容大概为网站前端和后端的技术，包括内容管理系统，文章内容有我自己的原创，也有其他网站转载过来的精品，如果我遇到好的资源会第一时间发布在本博客内。</p>
                <p>大家如果有好的文章好的技术请不要吝啬，欢迎前来投稿！</p>
                <p>如果有什么疑问或者需要投稿的请使用下方联系方式，或者留言来告诉我，收到后第一时间回复。</p>
            </div>
            <div class="content-block contact-content">
                <h2 class="title"><strong>联系技术博客</strong></h2>
                <p><span>站长QQ：</span><a href="tencent://message/?uin=164101065\">164101065</a></p>
                <p><span>站长信箱：</span><a href="mailto:ming123jew@qq.com">ming123jew@qq.com</a></p>
            </div>
            <div class="content-block comment" style="display: none">
                <h2 class="title"><strong>添加留言</strong></h2>
                <form action="message.php" method="post" class="form-inline" id="comment-form">
                    <div class="comment-title">
                        <div class="form-group">
                            <label for="messageName">姓名：</label>
                            <input type="text" name="messageName" class="form-control" id="messageName" placeholder="技术博客">
                        </div>
                        <div class="form-group">
                            <label for="messageEmail">邮箱：</label>
                            <input type="email" name="messageEmail" class="form-control" id="messageEmail" placeholder="admin@xxxx.com">
                        </div>
                    </div>
                    <div class="comment-form">
                        <textarea placeholder="在此处填写留言内容" name="messageContent"></textarea>
                        <div class="comment-form-footer">
                            <div class="comment-form-text">请先 <a href="javascript:;">登录</a> 或 <a href="javascript:;">注册</a>，也可匿名留言 </div>
                            <div class="comment-form-btn">
                                <button type="submit" class="btn btn-default btn-comment">提交留言</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="content-block comment-content">
                    <h2 class="title"><strong>最新留言</strong></h2>
                    <ul>
                        <li><span class="text"><strong>技术博客站长</strong> (2015-10-18) 留言：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="text"><strong>技术博客编辑</strong> (2015-10-18) 留言：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="text"><strong>令狐冲</strong> (2015-10-18) 留言：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="text"><strong>任盈盈</strong> (2015-10-18) 留言：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                        <li><span class="text"><strong>技术博客站长</strong> (2015-10-18) 留言：<br />
              欢迎来到个人技术博客，在这里可以看到网站前端和后端的技术等 ...</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/内容-->
    <aside class="sidebar visible-lg"><!--右侧>992px显示-->
        <div class="sentence"> <strong>每日一句</strong>
            <h2><?php echo $data['date'];?></h2>
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
                <?php foreach ($data['d_get_recommend'] as $k=>$v){?>
                    <li>
                        <a target="_blank" href="<?php echo url('','Article','Read',['id'=>$v['id']]);?>">
                            <span class="thumb"><img src="images/icon/icon.png" alt=""></span>
                            <span class="text"> <?php echo $v['title'];?> </span>
                            <span class="text-muted">阅读(<?php echo $v['views'];?>)</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="sidebar-block comment">
            <h2 class="title"><strong>最新评论</strong></h2>
            <ul>
                <?php foreach ($data['d_get_new_comment'] as $k=>$v){?>
                    <li data-toggle="tooltip" data-placement="top" title="《<?php echo $v['title'];?>》">
                        <a target="_blank" href="<?php echo url('','Article','read',['id'=>$v['content_id']]);?>">
                            <span class="face"><img src="images/icon/icon.png" alt=""></span>
                            <span class="text"><strong><?php echo $v['username'];?></strong> (<?php echo date('Y-m-d',$v['create_time']);?>) 说：<br />
                                <?php echo $v['content'];?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </aside>
    <!--/右侧>992px显示-->
    <?php $this->insert('app::Home/public_footer',['data'=>$data]) ?>
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
