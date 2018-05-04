<ul class="nav sidebar-menu" id="menu">
    <!--Dashboard-->
    <li <?php if($data['__C__']=='Admin/Main'){?>class="active"<?php } ?>>
        <a href="<?php echo $data['__URL__'];?>">
            <i class="menu-icon glyphicon glyphicon-home"></i>
            <span class="menu-text"> 仪表盘 </span>
        </a>
    </li>
    <!--Databoxes-->
    <li <?php if($data['__C__']=='Admin/System'||$data['__C__']=='Admin/Role'){?>class="active open"<?php } ?>>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon-tasks"></i>
            <span class="menu-text">系统设置</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li <?php if($data['__M__']=='config'){?>class="active"<?php } ?>>
                <a href="<?php echo url('Admin/System','config','i=1');?>">
                    <span class="menu-text">基本设置</span>
                </a>
            </li>
            <li <?php if($data['__M__']=='menu'){?>class="active"<?php } ?>>
                <a href="<?php echo url('Admin/System','menu','i=1');?>">
                    <span class="menu-text">后台菜单</span>
                </a>
            </li>
            <li <?php if($data['__M__']=='lists'){?>class="active"<?php } ?>>
                <a href="<?php echo url('Admin/Role','role_lists','i=1');?>">
                    <span class="menu-text">角色权限</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Widgets-->
    <li <?php if($data['__C__']=='Admin/Content'){?>class="active open"<?php } ?>>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-th"></i>
            <span class="menu-text">内容管理</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li <?php if( strpos($data['__M__'],'content_article')!==false){?>class="open"<?php } ?>>
                <a href="#" class="menu-dropdown">
                                    <span class="menu-text">
                                         <span class="menu-text">内容发布</span>
                                    </span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li <?php if($data['__M__']=='content_article_list'){?>class="active"<?php } ?>>
                        <a href="<?php echo url('Admin/Content','content_article_list','i=1');?>">列表</a>
                    </li>
                    <li <?php if($data['__M__']=='content_article_add'){?>class="active"<?php } ?>>
                        <a href="<?php echo url('Admin/Content','content_article_add','i=1');?>">添加</a>
                    </li>
                </ul>
            </li>
            <li <?php if( strpos($data['__M__'],'content_category')!==false){?>class="open"<?php } ?>>
                <a href="#" class="menu-dropdown">
                    <span class="menu-text">
                        <span class="menu-text">栏目管理</span>
                    </span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li <?php if($data['__M__']=='content_category_list'){?>class="active"<?php } ?>>
                        <a href="<?php echo url('Admin/Content','content_category_list','i=1');?>">
                            <span class="menu-text">列表</span>
                        </a>
                    </li>
                    <li <?php if($data['__M__']=='content_category_add'){?>class="active"<?php } ?>>
                        <a href="<?php echo url('Admin/Content','content_category_add','i=1');?>">
                            <span class="menu-text">添加</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </li>



    <!--Right to Left-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-align-right"></i>
            <span class="menu-text"> Right to Left </span>

            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a>
                    <span class="menu-text">RTL</span>
                    <label class="pull-right margin-top-10">
                        <input id="rtl-changer" class="checkbox-slider slider-icon colored-primary" type="checkbox">
                        <span class="text"></span>
                    </label>
                </a>
            </li>
            <li>
                <a href="index-rtl-ar.html">
                    <span class="menu-text">Arabic Layout</span>
                </a>
            </li>

            <li>
                <a href="index-rtl-fa.html">
                    <span class="menu-text">Persian Layout</span>
                </a>
            </li>
        </ul>
    </li>
</ul>

<!--Success Modal Templates-->
<div id="modal-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="glyphicon glyphicon-check"></i>
            </div>
            <div class="modal-title">Success</div>

            <div class="modal-body">You have done great!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>
<!--/Success Modal Templates-->

<!--Danger Modal Templates-->
<div id="modal-warning" class="modal modal-message modal-warning fade in" style="display: none;" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-warning"></i>
            </div>
            <div class="modal-title">Warning</div>

            <div class="modal-body">Is something wrong?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">OK</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>
<!--/Danger Modal Templates-->

<script>
    /**
      * Array.prototype.[method name] allows you to define/overwrite an objects method
      * needle is the item you are searching for
      * this is a special variable that refers to "this" instance of an Array.
      * returns true if needle is in the array, and false otherwise
      */
    Array.prototype.contains = function ( needle ) {
        for (i in this) {
            if (this[i] == needle) return true;
        }
        return false;
    }
    var Ajax={
        get: function(url, fn) {
            var obj = new XMLHttpRequest();  // XMLHttpRequest对象用于在后台与服务器交换数据
            obj.open('GET', url, true);
            obj.onreadystatechange = function() {
                if (obj.readyState == 4 && obj.status == 200 || obj.status == 304) { // readyState == 4说明请求已完成
                    fn.call(this, obj.responseText);  //从服务器获得数据
                }
            };
            obj.send();
        },
        post: function (url, data, fn) {         // datat应为'a=a1&b=b1'这种字符串格式，在jq里如果data为对象会自动将对象转成这种字符串格式
            var obj = new XMLHttpRequest();
            obj.open("POST", url, true);
            obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // 添加http头，发送信息至服务器时内容编码类型
            obj.onreadystatechange = function() {
                if (obj.readyState == 4 && (obj.status == 200 || obj.status == 304)) {  // 304未修改
                    fn.call(this, obj.responseText);
                }
            };
            obj.send(data);
        }
    }
    var html = '';
    window.onload = function (ev) {
        $.post("<?php echo url('Admin','Main','ajaxgetmenu');?>",{},function (json) {
            //var json = eval('('+json+')');
            if(json.status==1){
                var jsonData = json.data;
                var one_active = '';
                var two_active = '';
                var controller = '<?php echo ucwords($data['__C__']); ?>';
                var controller2 = '<?php echo strtolower($data['__C__']); ?>';//子菜单模糊查找，包含了其字样 则active
                var action = '<?php echo ($data['__A__']); ?>';
                for(var i = 0; i < jsonData.length; i++){
                    //一级目录

                    if(jsonData[i].a=='#'){

                        //查看是否设置了菜单多控制器分类
                        if(jsonData[i].cc){
                            if(jsonData[i].cc.split(',').contains(controller)){one_active='class = "active open"'; }else{one_active='';}
                        }else{
                            if(jsonData[i].c==controller){one_active='class = "active open"'; }else{one_active='';}
                        }
                        html +='<li '+one_active+'>';
                        html += '<a href="'+jsonData[i].url+'" class="menu-dropdown">';
                        html +='<i class="'+jsonData[i].icon+'"></i>';
                        html +='<span class="menu-text"> '+jsonData[i].name+' </span>';
                        html +='<i class="menu-expand"></i>';
                        html +='</a>';
                        //console.log(jsonData[i].subset)
                        var subset = jsonData[i].subset;
                        //console.log(subset.length);
                        //判断是否有子菜单
                        if(subset.length>0){
                            html +='<ul class="submenu">';
                            for (var n=0; n<subset.length;n++){
                                if(action==subset[n].a){
                                    two_active='class = "active"';
                                }else if( subset[n].a.indexOf(controller2)!=-1 ){
                                    two_active='class = "active"';
                                }else{
                                    two_active='';
                                }
                                html +='<li '+two_active+'>';
                                html +='<a href="'+subset[n].url+'">';
                                html +='<span class="menu-text">'+subset[n].name+'</span>';
                                html +='</a>';
                            }
                            html +='</ul>';
                        }

                        html +='</li>';
                    }

                }
                console.log(html);
                document.getElementById('menu').innerHTML = html;
            }else{
                console.log(json.status)
            }

        });
    }

</script>
