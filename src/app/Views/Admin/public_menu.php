<ul class="nav sidebar-menu">
    <!--Dashboard-->
    <li class="active">
        <a href="<?php echo $data['__URL__'];?>">
            <i class="menu-icon glyphicon glyphicon-home"></i>
            <span class="menu-text"> 仪表盘 </span>
        </a>
    </li>
    <!--Databoxes-->
    <li>
        <a href="<?php \app\Extend\Helpers\Helper::url($data['__C__'],'config','i=1');?>">
            <i class="menu-icon glyphicon glyphicon-tasks"></i>
            <span class="menu-text">系统设置</span>
        </a>
    </li>
    <!--Widgets-->
    <li>
        <a href="widgets.html">
            <i class="menu-icon fa fa-th"></i>
            <span class="menu-text"> Widgets </span>
        </a>
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
                    <li>
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