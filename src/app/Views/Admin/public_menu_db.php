<ul class="nav sidebar-menu">
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

    <!--UI Elements-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-desktop"></i>
            <span class="menu-text"> Elements </span>
            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="elements.html">
                    <span class="menu-text">Basic Elements</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-dropdown">
                                    <span class="menu-text">
                                        Icons
                                    </span>
                    <i class="menu-expand"></i>
                </a>

                <ul class="submenu">
                    <li  class="active">
                        <a href="font-awesome.html">
                            <i class="menu-icon fa fa-rocket"></i>
                            <span class="menu-text">Font Awesome</span>
                        </a>
                    </li>
                    <li>
                        <a href="glyph-icons.html">
                            <i class="menu-icon glyphicon glyphicon-stats"></i>
                            <span class="menu-text">Glyph Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="typicon.html">
                            <i class="menu-icon typcn typcn-location-outline"></i>
                            <span class="menu-text"> Typicons</span>
                        </a>
                    </li>
                    <li>
                        <a href="weather-icons.html">
                            <i class="menu-icon wi-day-snow"></i>
                            <span class="menu-text">Weather Icons</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="tabs.html">
                    <span class="menu-text">Tabs & Accordions</span>
                </a>
            </li>
            <li>
                <a href="alerts.html">
                    <span class="menu-text">Alerts & Tooltips</span>
                </a>
            </li>
            <li>
                <a href="modals.html">
                    <span class="menu-text">Modals & Wells</span>
                </a>
            </li>
            <li>
                <a href="buttons.html">
                    <span class="menu-text">Buttons</span>
                </a>
            </li>
            <li>
                <a href="nestable-list.html">
                    <span class="menu-text"> Nestable List</span>
                </a>
            </li>
            <li>
                <a href="treeview.html">
                    <span class="menu-text">Treeview</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Tables-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-table"></i>
            <span class="menu-text"> Tables </span>

            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="tables-simple.html">
                    <span class="menu-text">Simple & Responsive</span>
                </a>
            </li>
            <li>
                <a href="tables-data.html">
                    <span class="menu-text">Data Tables</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Forms-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-pencil-square-o"></i>
            <span class="menu-text"> Forms </span>

            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="form-layouts.html">
                    <span class="menu-text">Form Layouts</span>
                </a>
            </li>

            <li>
                <a href="form-inputs.html">
                    <span class="menu-text">Form Inputs</span>
                </a>
            </li>

            <li>
                <a href="form-pickers.html">
                    <span class="menu-text">Data Pickers</span>
                </a>
            </li>
            <li>
                <a href="form-wizard.html">
                    <span class="menu-text">Wizard</span>
                </a>
            </li>
            <li>
                <a href="form-validation.html">
                    <span class="menu-text">Validation</span>
                </a>
            </li>
            <li>
                <a href="form-editors.html">
                    <span class="menu-text">Editors</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Charts-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-bar-chart-o"></i>
            <span class="menu-text"> Charts </span>

            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="flot.html">
                    <span class="menu-text">Flot Charts</span>
                </a>
            </li>

            <li>
                <a href="morris.html">
                    <span class="menu-text"> Morris Charts</span>
                </a>
            </li>
            <li>
                <a href="sparkline.html">
                    <span class="menu-text">Sparkline Charts</span>
                </a>
            </li>
            <li>
                <a href="easypiecharts.html">
                    <span class="menu-text">Easy Pie Charts</span>
                </a>
            </li>
            <li>
                <a href="chartjs.html">
                    <span class="menu-text"> ChartJS</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Profile-->
    <li>
        <a href="profile.html">
            <i class="menu-icon fa fa-picture-o"></i>
            <span class="menu-text">Profile</span>
        </a>
    </li>
    <!--Mail-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-envelope-o"></i>
            <span class="menu-text"> Mail </span>

            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="inbox.html">
                    <span class="menu-text">Inbox</span>
                </a>
            </li>

            <li>
                <a href="message-view.html">
                    <span class="menu-text">View Message</span>
                </a>
            </li>
            <li>
                <a href="message-compose.html">
                    <span class="menu-text">Compose Message</span>
                </a>
            </li>
        </ul>
    </li>
    <!--Calendar-->
    <li>
        <a href="calendar.html">
            <i class="menu-icon fa fa-calendar"></i>
            <span class="menu-text">
                                Calendar
                            </span>
        </a>
    </li>
    <!--Pages-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon-paperclip"></i>
            <span class="menu-text"> Pages </span>

            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="timeline.html">
                    <span class="menu-text">Timeline</span>
                </a>
            </li>
            <li>
                <a href="pricing.html">
                    <span class="menu-text">Pricing Tables</span>
                </a>
            </li>

            <li>
                <a href="invoice.html">
                    <span class="menu-text">Invoice</span>
                </a>
            </li>

            <li>
                <a href="login.html">
                    <span class="menu-text">Login</span>
                </a>
            </li>
            <li>
                <a href="register.html">
                    <span class="menu-text">Register</span>
                </a>
            </li>
            <li>
                <a href="lock.html">
                    <span class="menu-text">Lock Screen</span>
                </a>
            </li>
            <li>
                <a href="typography.html">
                    <span class="menu-text"> Typography </span>
                </a>
            </li>
        </ul>
    </li>
    <!--More Pages-->
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon-link"></i>

            <span class="menu-text">
                                More Pages
                            </span>

            <i class="menu-expand"></i>
        </a>

        <ul class="submenu">
            <li>
                <a href="error-404.html">
                    <span class="menu-text">Error 404</span>
                </a>
            </li>

            <li>
                <a href="error-500.html">
                    <span class="menu-text"> Error 500</span>
                </a>
            </li>
            <li>
                <a href="blank.html">
                    <span class="menu-text">Blank Page</span>
                </a>
            </li>
            <li>
                <a href="grid.html">
                    <span class="menu-text"> Grid</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-dropdown">
                                    <span class="menu-text">
                                        Multi Level Menu
                                    </span>
                    <i class="menu-expand"></i>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="#">
                            <i class="menu-icon fa fa-camera"></i>
                            <span class="menu-text">Level 3</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-asterisk"></i>

                            <span class="menu-text">
                                                Level 4
                                            </span>
                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="#">
                                    <i class="menu-icon fa fa-bolt"></i>
                                    <span class="menu-text">Some Item</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="menu-icon fa fa-bug"></i>
                                    <span class="menu-text">Another Item</span>
                                </a>
                            </li>
                        </ul>
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