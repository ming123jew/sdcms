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
    <?php $this->insert('app::Home/head',['data'=>$data]) ?>
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
                    <li>栏目：<a href="" title="" target="_blank"><?php echo $data['article']['catname'];?></a></li>
                    <li>来源：<a href="" title="" target="_blank"><?php echo $data['article']['copyfrom'];?></a></li>
                    <li>共 <strong><?php echo $data['article']['views'];?></strong> 人围观 </li>
<!--                    <li><strong>123</strong> 个不明物体</li>-->
                </ul>
            </header>
            <article class="news_content">
                <?php echo $data['article']['body'];?>
            </article>
            <div class="reprint">转载请说明出处：<a href="" title="" target="_blank">ming123jew技术博客</a> » <a href="" title="" target="_blank">欢迎来到ming123jew个人技术博客</a></div>
            <div class="zambia"><a href="javascript:;" name="zambia" rel="<?php echo $data['article']['praise'];?>"><span class="glyphicon glyphicon-thumbs-up"></span> 赞（<?php echo $data['article']['praise'];?>）</a></div>
            <?php if(!empty($data['article']['keywords'])){ $arr_keywords=explode(' ',trim($data['article']['keywords']));?>
            <div class="tags news_tags">标签：
                <?php foreach( $arr_keywords as $kk=>$vv){?>
                <span data-toggle="tooltip" data-placement="bottom" title="查看关于 本站 的文章"><a href="javascript:;"><?php echo $vv;?></a></span>
                <?php } ?>
            </div>
            <?php } ?>
            <nav class="page-nav">
                <span class="page-nav-prev">
                    上一篇<br />
                    <?php echo $data['article']['prev'];?>
                </span>
                <span class="page-nav-next">下一篇<br />
                    <?php echo $data['article']['next'];?>
                </span>
            </nav>
            <!--<div class="content-block related-content visible-lg visible-md" style="display: none;">
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
            </div>-->
            <div class="content-block comment">
                <h2 class="title"><strong>评论</strong></h2>
                <form action="" method="post" class="form-inline" id="comment-form">
                    <div class="comment-title">
                        <div class="form-group">
                            <label for="commentName">昵称：</label>
                            <input type="text" name="commentName" class="form-control" id="commentName" placeholder="技术博客" value="<?php echo $data['user.username'];?>">
                        </div>
                        <div class="form-group">
                            <label for="commentEmail">邮箱：</label>
                            <input type="email" name="commentEmail" class="form-control" id="commentEmail" placeholder="xxx@xxxx.com" value="<?php echo $data['user.email'];?>">
                        </div>
                    </div>
                    <div class="comment-form">
                        <textarea placeholder="你的评论可以一针见血" name="commentContent" id="commentContent"></textarea>
                        <div class="comment-form-footer">
                            <div class="comment-form-text">请先 <a href="<?php echo url('Home','Main','login')?>">登录</a> 或 <a href="<?php echo url('Home','Main','register')?>">注册</a>，也可匿名评论 </div>
                            <div class="comment-form-btn">
                                <button type="submit" class="btn btn-default btn-comment">提交评论</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="comment-content">
                    <ul id="comment-list">
                    </ul>
                    <input type="hidden" value="1" id="comment-page">
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
                            <span class="text"><strong><?php echo $v['username'];?></strong> (<?php echo date('Y-m-d',$v['create_time']);?>) 说：<br /><?php echo $v['content'];?></span>
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



    $(function(){
        //ajax更新点赞值
        $(".content .zambia a").click(function(){
            var zambia = $(this);
            var praise = parseInt( zambia.attr("rel") ); //对应id
            zambia.fadeOut(1000); //渐隐效果
            $.ajax({
                type:"POST",
                url:"<?php echo url('','Article','praise',['id'=>$data['article']['id']]);?>",
                data:"praise="+praise,
                cache:false, //不缓存此页面
                success:function(json){
                    if(json.status==1){
                        zambia.html('<span class="glyphicon glyphicon-thumbs-up"></span> 赞（'+(praise+1)+'）');
                        zambia.fadeIn(1000); //渐显效果
                    }
                }
            });
            return false;
        });
        //提交评论
        $("#comment-form").submit(function(e){
            $.ajax({
                type:"POST",
                url:"<?php echo url('','Article','comment',['content_id'=>$data['article']['id'],'catid'=>$data['article']['catid']]);?>",
                data:{"title":"<?php echo $data['article']['title']?>","username":$("#commentName").val(),"email":$("#commentEmail").val(),"content":$("#commentContent").val()},
                cache:false, //不缓存此页面
                success:function(json){
                    if(json.status==1){

                        $('#comment-list').prepend('<li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>'+$('#commentName').val()+'</strong> ('+getNowFormatDate()+') 说：<br />\n' +
                            $('#commentContent').val().replace(/[\n\r]/g,'<br>')+'</span></li>')
                    }else {
                        alert(json.message);
                    }
                }
            });
            return false;
        });

        //加载评论
        var p = parseInt( $('#comment-page').val() );
        getComment(p);
        
    })

    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }
    function formatDateTime(timeStamp) {
        var date = new Date();
        date.setTime(timeStamp * 1000);
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        m = m < 10 ? ('0' + m) : m;
        var d = date.getDate();
        d = d < 10 ? ('0' + d) : d;
        var h = date.getHours();
        h = h < 10 ? ('0' + h) : h;
        var minute = date.getMinutes();
        var second = date.getSeconds();
        minute = minute < 10 ? ('0' + minute) : minute;
        second = second < 10 ? ('0' + second) : second;
        return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
    }
    function getComment(p) {
        $.ajax({
            url: "<?php echo url('','Article','get_comment',['content_id'=>$data['article']['id']]);?>",
            data: {
                p:p,
                url: window.location.href,
                type: "signature"
            },
            type:'post',
            dataType: "jsonp",
            jsonp: "jsonpcallback",//服务端用于接收callback调用的function名的参数
        }).success(function (result) {
            //alert(result)
            var html = '';
            if(result.status==1){
                $(result.data).each(function (i,e) {
                    html +='<li><span class="face"><img src="images/icon/icon.png" alt=""></span> <span class="text"><strong>'+e.username+'</strong> ('+formatDateTime(e.create_time)+') 说：<br />\n' +
                        e.content.replace(/[\n\r]/g,'<br>')+'</span></li>';
                })
                $('#comment-list').html(html).show(300)
                $('#comment-page').val( p+1 );
            }

        });
    }

</script>
</body>
</html>
