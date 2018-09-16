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
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/plugins/materialize/css/materialize.style.css') }}"  media="screen"/>
    <!--vector map css-->
    <link href="{{ asset('backend/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!--Template style-->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script>
        var base_url = "<?php echo e(url('')); ?>";
    </script>
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
@include ('includes/partials/backend/sidebar-navigation')
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

@yield('custom_js')

</body>
</html>

<!--https://dribbble.com/shots/2280300-Free-Set-Of-Material-design-avatars-->