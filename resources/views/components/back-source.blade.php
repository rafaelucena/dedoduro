<!DOCTYPE html>
<html lang="pt">
<head>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ asset('backend/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <title>Ultima</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/plugins/materialize/css/materialize.min.css') }}"  media="screen"/>
    <!--vector map css-->
    <link href="{{ asset('backend/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!--Template style-->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="preloader">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-red">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<!-- end preloader-->
<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\Start top bar header\\\\\\\\\\\\\\\\\\\\\\\-->
<header id="header" class="top-bar">
    <div class="navbar-fixed">
        <nav class="teal">
            <div class="nav-wrapper">
                <ul class="left">
                    <li><h1 class="logo-wrapper center-align"><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/index.html" class="brand-logo">ultima</a></h1></li>
                </ul>

                <ul class="right col s9 m3 nav-right-menu">
                    <li class="hide-on-med-and-down"><a href="javascript:void(0)" data-activates="dropdown2" class="dropdown-button dropdown-right show-on-large"><i class="material-icons">notifications_none</i><span class="badge red">3</span></a></li>
                    <li class="hide-on-med-and-down"><a href="javascript:void(0)" data-activates="dropdown1" class="dropdown-button dropdown-right show-on-large"><i class="material-icons">email</i><span class="badge blue">4</span></a></li>
                    <li><a class='dropdown-button  dropdown-right' href='form-basic.html#' data-activates='dropdown'><img src='images/avatar-03.png' alt="" width="40"></a></li>
                    <li><a href="javascript:void(0)" data-activates="right-sidebar" class="right-sidebar-button waves-effect waves-light"><i class="material-icons">chat</i></a></li>

                </ul>
                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content profile-dropdown'>
                    <li><a href="form-basic.html#!">Profile</a></li>
                    <li><a href="form-basic.html#!">Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="form-basic.html#!">Logout</a></li>
                </ul>
                <ul id='dropdown1' class='dropdown-content notifications-dropdown'>
                    <li class="notification-header">
                        4 New Messages
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <img src="images/avatar-01.png" alt="" width="40" class="left">
                            <div class="notify-content">
                                <span class="notify-title">John Started Following You</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <img src="images/avatar-04.png" alt="" width="40" class="left">
                            <div class="notify-content">
                                <span class="notify-title">Adam sent you a request</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <img src="images/avatar-05.png" alt="" width="40" class="left">
                            <div class="notify-content">
                                <span class="notify-title">Deny Sent a private Message</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <img src="images/avatar-08.png" alt="" width="40" class="left">
                            <div class="notify-content">
                                <span class="notify-title">Kalia assign a task</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#" class="center-align">View All</a>
                    </li>
                </ul>
                <ul id='dropdown2' class='dropdown-content notifications-dropdown'>
                    <li class="notification-header">
                        3 New Alerts
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <i class="material-icons left red-text">warning</i>
                            <div class="notify-content">
                                <span class="notify-title red-text">Disc storage is low</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <i class="material-icons left green-text">cloud_download</i>
                            <div class="notify-content">
                                <span class="notify-title green-text">File download is complete</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#">
                            <i class="material-icons red-text left">email</i>
                            <div class="notify-content">
                                <span class="notify-title red-text">Email Send Failed</span>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                </p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="form-basic.html#" class="center-align">View All</a>
                    </li>
                </ul>
                <form class="right search col s6 hide-on-med-and-down">
                    <div class="input-field">
                        <input id="search" type="search" placeholder="Search" autocomplete="off">
                        <label for="search" class="active"><i class="material-icons search-icon">search</i></label>
                    </div>
                </form>
            </div>
        </nav>

    </div>
</header>
<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\End top bar header\\\\\\\\\\\\\\\\\\\\\\\-->



<!--\\\\\\\\\\\\\\\\\\\ Start left side nav\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="nav-title">Main Navigation</li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">dashboard</i>Dashboard</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/index.html">Dashboard v1</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/index-v2.html">Dashboard v2</a></li>

                    </ul>
                </div>
            </li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/widget.html"><i class="material-icons">extension</i>Widgets</a></li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">pie_chart</i>Charts</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/chart-flot.html">Flot Chart</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/chart-morris.html">Morris Chart</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/chart-chartjs.html">ChartJs</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/chart-sparkline.html">Sparkline</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/chart-c3.html">c3 Charts</a></li>


                    </ul>
                </div>
            </li>
            <li class="nav-title">Components</li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey active"><i class="material-icons">mode_edit</i>Form Elements</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="form-basic.html">Basic elements</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/form-upload.html">File Upload</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/form-mask.html">input mask</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Tables</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/table-basic.html">Basic Tables</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/table-responsive.html">Responsive tables</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/table-data.html">Data-tables</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">settings</i>Material UI</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-accordions.html">Accordion</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-badges.html">Badges</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-buttons.html">Buttons</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-typography.html">Typography</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-cards.html">Cards</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-dialogs.html">Dialogs</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-grid.html">Grid</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-helpers.html">Helpers</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-modals.html">Modals</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-media.html">Media</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-icons.html">Icons</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-parallax.html">Parallax</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ui-tabs.html">Tabs</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">build</i>Other Elements</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/sweet-alerts.html">Sweet Alerts</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/ion-sliders.html">Sliders</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/nestable.html">Nastable</a></li>

                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/draggable-cards.html">draggable cards</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/tree-view.html">tree view</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-title">Others</li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/calendar.html"><i class="material-icons">perm_contact_calendar</i>Calendar</a></li>


            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">folder</i>Pages</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-404.html">404 Page</a></li>


                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-login.html">Login</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-register.html">Register</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-lock-screen.html">Lock Screen</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-forgot-password.html">Forgot Password</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/page-pricing.html">Pricing Tables</a></li>


                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">navigation</i>Maps</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/map-google.html">Google Maps</a></li>
                        <li><a href="http://bootstraplovers.com/themeforest-html/ultima-v1.2/map-vector.html">Vector Maps</a></li>
                    </ul>
                </div>
            </li>
            <li class="footer center">
                <span class="grey-text">&copy; 2016-2017. Ultima</span>
            </li>
        </ul>
    </div>
</aside>
<a href="form-basic.html#" data-activates="slide-out" class="button-collapse hide-on-large-only"><i class="material-icons">menu</i></a>
<!--//////////////////End left side nav/////////////////-->



<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\Right sidebar Start\\\\\\\\\\\\\\\\\\\\\\\-->
<aside id="right-sidebar" class="side-nav  white right-sidebar-panel">
    <div class="side-nav-wrapper">
        <ul class="chat-list">
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-01.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>John Doe</h5>
                        <span class="green-text">Online</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-02.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>David villa</h5>
                        <span class="red-text">Offline</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-03.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>John Abraham</h5>
                        <span class="grey-text">Active 3h ago</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-04.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>Johnny Liver</h5>
                        <span class="green-text">Online</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-05.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>Mark Wough</h5>
                        <span class="green-text">Online</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-06.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>Adam Smith</h5>
                        <span class="red-text">Offline</span>
                    </div>
                </a>
            </li><!--end chat item-->
            <li class="chat-item clearfix">
                <a href="form-basic.html#">
                    <img src="images/avatar-07.png" alt="" width="40" class="left">
                    <div class="overflow-hidden">
                        <h5>Rakesh sharma</h5>
                        <span class="grey-text">Active 3h ago</span>
                    </div>
                </a>
            </li><!--end chat item-->
        </ul><!--end chat list-->
        <div class="center-align">
            <a href="form-basic.html#" class="btn waves-effect waves-light teal">Load More...</a>
        </div>
    </div>
</aside>
<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\Right sidebar End\\\\\\\\\\\\\\\\\\\\\\\-->


<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\Main content Start\\\\\\\\\\\\\\\\\\\\\\\-->
<main class="main-content">
    @yield('content')
</main>
<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\Main content end\\\\\\\\\\\\\\\\\\\\\\\-->


<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="{{ asset('backend/plugins/jquery/jquery.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('backend/plugins/materialize/js/materialize.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('backend/js/app.js')}}"></script>

</body>
</html>

<!--https://dribbble.com/shots/2280300-Free-Set-Of-Material-design-avatars-->