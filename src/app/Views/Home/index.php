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
    <?php $this->insert('app::Home/head',['data'=>$data]) ?>
</head>

<body>
<section class="container user-select">
    <?php $this->insert('app::Home/public_nav',['data'=>$data]) ?>
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
                    <?php foreach ($data['d_slide'] as $k => $v){?>
                        <div <?php if($k==0){?>class="item active"<?php }else{ ?>class="item"<?php } ?> data-id="article_<?php echo $v['id'];?>">
                            <a href="<?php echo url('','Article','Read',['id'=>$v['id']]);?>" target="_blank">
                                <img src="<?php echo $v['thumb'];?>" alt="<?php echo $v['title'];?>" />
                            </a>
                            <div class="carousel-caption"> <?php echo $v['title'];?></div>
                            <span class="carousel-bg"></span> </div>
                    <?php } ?>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
            <!--/banner-->
            <div class="content-block hot-content hidden-xs" style="display: none">
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
                    <?php foreach ($data['d_get_new'] as $k => $v){?>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"> <a target="_blank" href="<?php echo url('','Article','Read',['id'=>$v['id']]);?>"><img style="width: 220px;height: 143px;" src="images/logo.jpg" alt=""> </a> </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt> <a href="<?php echo url('','Article','Read',['id'=>$v['id']]);?>" target="_blank" > <?php echo $v['title'];?> </a> </dt>
                                <dd><span class="name"><a href="<?php echo url('','Article','Read',['id'=>$v['id']]);?>" title="<?php echo $v['title'];?>" rel="author"><?php echo $v['username'];?></a></span> <span class="identity"></span> <span class="time"> <?php echo date('Y-m-d',$v['create_time']);?> </span></dd>
                                <dd class="text"><?php echo $v['description'];?></dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8">
                                <?php if(!empty($v['keywords'])){ $arr_keywords=explode(' ',trim($v['keywords']));?>
                                <span class="tags visible-lg visible-md">
                                    <?php foreach( $arr_keywords as $kk=>$vv){?>
                                    <a href="javascript:;"><?php echo $vv;?></a>
                                    <?php } ?>
                                </span>
                                <?php }else{ ?>
                                <span class="tags visible-lg visible-md"></span>
                                <?php } ?>
                                <span class="look"> 共 <strong><?php echo $v['views'];?></strong> 人围观<!--，发现 <strong> 12 </strong> 个不明物体 --></span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!--<div class="news-more" id="pagination">
                    <a href="">查看更多</a>
                </div>-->
<!--                <div class="quotes" style="margin-top:15px"><span class="disabled">首页</span><span class="disabled">上一页</span><span class="current">1</span><a href="">2</a><a href="">下一页</a><a href="">尾页</a></div>-->
                <?php echo $data['page_d_get_new'];?>
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
    <!--底部导航-->
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
