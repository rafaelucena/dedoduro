<!DOCTYPE html>
<html lang="pt" class="crt crt-side-box-on crt-nav-on crt-nav-type2 crt-main-nav-on crt-sidebar-on crt-layers-1">
<head>
    {{--<meta charset="utf-8">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dedoduro</title>
    <meta name="description" content="O mapeamento de noticias mais atualizado que existe!">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="{{ asset('assets/fonts/icomoon/style.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/front.plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/front.style.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Modernizer -->
    <script type="text/javascript" src="{{ asset('assets/js/vendor/modernizr-3.3.1.min.js') }}"></script>

    @if (env('APP_ENV') === 'production')
        {{--<!-- Global site tag (gtag.js) - Google Analytics -->--}}
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125557212-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-125557212-1');
        </script>
    @endif

    <!-- Google Analytics -->
    {{--<script>--}}
        {{--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
            {{--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
            {{--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
        {{--})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');--}}
{{----}}
        {{--ga('create', 'UA-125557212-1', 'auto');--}}
        {{--ga('send', 'pageview');--}}
    {{--// </script>--}}
</head>

<body class="">
<div class="crt-wrapper">
    <div class="progress-container">
        <div class="progress-bar" id="reading-bar"></div>
    </div>
    <header id="crt-header">
        <div class="crt-head-inner crt-container">
            <div class="crt-container-sm">
                <div class="crt-head-row">
                    {{--<div id="crt-head-col1" class="crt-head-col text-left">--}}
                        {{--<a id="crt-logo" class="crt-logo" href="index.php">--}}
                            {{--<img src="{{ asset('assets/images/uploads/brand/logo.svg') }}" alt="certy resume"><span>.Certy</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}

                    <div id="crt-head-col2" class="crt-head-col text-right">
                        <div class="crt-nav-container crt-container hidden-sm hidden-xs">
                            <nav id="crt-main-nav">

                                <ul class="clear-list">
                                    <li>
                                        <a href="{{ url('/') }}">Home</a>
                                    </li>
                                    <li class="in-progress coming-soon">
                                        <a href="{{ url('sobre') }}">Sobre</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('busca') }}">Busca</a>
                                    </li>
                                    <li class="in-progress coming-soon">
                                        <a href="{{ url('comunicados') }}">Comunicados</a>
                                    </li>
                                    <li class="in-progress coming-soon">
                                        <a href="{{ url('contribuir') }}">Contribua</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('contato') }}">Contato</a>
                                    </li>
                                    {{--<li><a href="index.php">home</a></li>--}}
                                    {{--<li><a href="portfolio.php">portfolio</a>--}}
                                    {{--<li class="has-sub-menu"><a href="#">pages</a>--}}
                                        {{--<ul class="sub-menu">--}}
                                            {{--<li><a href="typography.php">typography</a></li>--}}
                                            {{--<li><a href="components.php">components</a></li>--}}
                                            {{--<li><a href="search.php">search</a></li>--}}
                                            {{--<li><a href="404.php">404</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</li>--}}
                                    {{--<li class="has-sub-menu"><a href="category.php">blog</a>--}}
                                        {{--<ul class="sub-menu">--}}
                                            {{--<li><a href="single.php">single</a></li>--}}
                                            {{--<li><a href="single-image.php">single image</a></li>--}}
                                            {{--<li><a href="single-slider.php">single slider</a></li>--}}
                                            {{--<li><a href="single-youtube.php">single youtube</a></li>--}}
                                            {{--<li><a href="single-vimeo.php">single vimeo</a></li>--}}
                                            {{--<li><a href="single-dailymotion.php">single dailymotion</a></li>--}}
                                            {{--<li><a href="single-soundcloud.php">single soundcloud</a></li>--}}
                                            {{--<li><a href="single-video.php">single video</a></li>--}}
                                            {{--<li><a href="single-audio.php">single audio</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</li>--}}
                                    {{--<li><a href="contact.php">contact</a></li>--}}
                                </ul>
                            </nav>
                        </div>
                    </div>

                    {{--<div id="crt-head-col3" class="crt-head-col text-right">--}}
                        {{--<button id="crt-sidebar-btn" class="btn btn-icon btn-shade">--}}
                            {{--<span class="crt-icon crt-icon-side-bar-icon"></span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                </div>
            </div><!-- .crt-head-inner -->
        </div>

        <nav id="crt-nav-sm" class="crt-nav hidden-lg hidden-md">
            <ul class="clear-list">
                {{--<li>--}}
                    {{--<a href="{{ url('/') }}">Home</a>--}}
                {{--</li>--}}
                {{--<li class="in-progress coming-soon">--}}
                    {{--<a href="{{ url('sobre') }}">Sobre</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{ url('busca') }}">Busca</a>--}}
                {{--</li>--}}
                {{--<li class="in-progress coming-soon">--}}
                    {{--<a href="{{ url('comunicados') }}">Comunicados</a>--}}
                {{--</li>--}}
                {{--<li class="in-progress coming-soon">--}}
                    {{--<a href="{{ url('contribuir') }}">Contribua</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{ url('contato') }}">Contato</a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ url('/') }}" data-tooltip="Home"><i class="fas fa-home fa-lg"></i></a>
                </li>
                <li>
                    <a href="{{ url('sobre') }}" data-tooltip="Sobre"><i class="fas fa-hashtag fa-lg"></i></a>
                </li>
                <li>
                    <a href="{{ url('busca') }}" data-tooltip="Busca"><i class="fas fa-search fa-lg"></i></a>
                </li>
                <li>
                    <a href="{{ url('comunicados') }}" data-tooltip="Comunicados"><i class="fas fa-bullhorn fa-lg"></i></a>
                </li>
                {{--<li>--}}
                    {{--<a href="{{ url('contribuir') }}" data-tooltip="Contribuir"><i class="fas fa-hands-helping fa-lg"></i></a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ url('contato') }}" data-tooltip="Contato"><i class="far fa-envelope fa-lg"></i></a>
                </li>
            </ul>
        </nav><!-- #crt-nav-sm -->
    </header><!-- #crt-header -->

    <div id="crt-container" class="crt-container">
        @yield('content')
    </div>
    <!-- .crt-container -->

    <div id="crt-sidebar">
        <button id="crt-sidebar-close" class="btn btn-icon btn-light btn-shade">
            <span class="crt-icon crt-icon-close"></span>
        </button>

        <div id="crt-sidebar-inner">
            <nav id="crt-main-nav-sm" class="visible-xs text-center">

                <ul class="clear-list">
                    <li><a href="index.php">home</a></li>
                    <li><a href="portfolio.php">portfolio</a>
                    <li class="has-sub-menu"><a href="#">pages</a>
                        <ul class="sub-menu">
                            <li><a href="typography.php">typography</a></li>
                            <li><a href="components.php">components</a></li>
                            <li><a href="search.php">search</a></li>
                            <li><a href="404.php">404</a></li>
                        </ul>
                    </li>
                    <li class="has-sub-menu"><a href="category.php">blog</a>
                        <ul class="sub-menu">
                            <li><a href="single.php">single</a></li>
                            <li><a href="single-image.php">single image</a></li>
                            <li><a href="single-slider.php">single slider</a></li>
                            <li><a href="single-youtube.php">single youtube</a></li>
                            <li><a href="single-vimeo.php">single vimeo</a></li>
                            <li><a href="single-dailymotion.php">single dailymotion</a></li>
                            <li><a href="single-soundcloud.php">single soundcloud</a></li>
                            <li><a href="single-video.php">single video</a></li>
                            <li><a href="single-audio.php">single audio</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.php">contact</a></li>
                </ul>        </nav>


            <div class="crt-card bg-primary text-center">
                {{--<div class="crt-card-avatar">--}}
                    {{--<img class="avatar avatar-195" src="{{ asset('assets/images/uploads/avatar/avatar-195x195.png') }}"--}}
                         {{--srcset="{{ asset('assets/images/uploads/avatar/avatar-390x390-2x.png') }} 2x" width="195" height="195" alt="">--}}
                {{--</div>--}}
                <div class="crt-card-info">
                    <h2 class="text-upper">Ola Lowe</h2>

                    <p class="text-muted">Florist | Decorator</p>
                    <ul class="crt-social clear-list">
                        <li><a><span class="crt-icon crt-icon-facebook"></span></a></li>
                        <li><a><span class="crt-icon crt-icon-twitter"></span></a></li>
                        <li><a><span class="crt-icon crt-icon-google-plus"></span></a></li>
                        <li><a><span class="crt-icon crt-icon-instagram"></span></a></li>
                        <li><a><span class="crt-icon crt-icon-pinterest"></span></a></li>
                    </ul>
                </div>
            </div>
            <aside class="widget-area">
                <section class="widget widget_search">
                    <form role="search" method="get" class="search-form" action="#">
                        <label>
                            <span class="screen-reader-text">Search for:</span>
                            <input type="search" class="search-field" placeholder="Search" value="" name="s">
                        </label>
                        <button type="submit" class="search-submit">
                            <span class="screen-reader-text">Search</span>
                            <span class="crt-icon crt-icon-search"></span>
                        </button>
                    </form>
                </section>

                <section class="widget widget_posts_entries">
                    <h2 class="widget-title">popular posts</h2>
                    <ul>
                        <li>
                            {{--<a class="post-image" href="">--}}
                                {{--<img src="{{ asset('assets/images/uploads/blog/img-70x70-01.png') }}" alt="">--}}
                            {{--</a>--}}
                            <div class="post-content">
                                <h3>
                                    <a href="">contextual advertising</a>
                                </h3>
                            </div>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Work</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>

                        <li>
                            {{--<a class="post-image" href="">--}}
{{--                                <img src="{{ asset('assets/images/uploads/blog/img-70x70-02.jpg') }}" alt="">--}}
                            {{--</a>--}}
                            <div class="post-content">
                                <h3>
                                    <a href="">grilling tips for the dog days of summer</a>
                                </h3>
                            </div>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Work</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>

                        <li>
                            {{--<a class="post-image" href="">--}}
                                {{--<img src="{{ asset('assets/images/uploads/blog/img-70x70-03.png') }}" alt="">--}}
                            {{--</a>--}}
                            <div class="post-content">
                                <h3><a href=""></a>branding do you know who are</h3>
                            </div>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Work</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>
                    </ul>
                </section>

                <section id="tag_cloud-2" class="widget widget_tag_cloud">
                    <h2 class="widget-title">Tags</h2>
                    <div class="tagcloud">
                        <a href="" class="tag-link-5 tag-link-position-1" title="1 topic" style="font-size: 1em;">Audios</a>
                        <a href="" class="tag-link-7 tag-link-position-2" title="1 topic" style="font-size: 1em;">Freelance</a></div>
                </section>

                <section id="recent-posts-3" class="widget widget_recent_entries">
                    <h4 class="widget-title">Recent Posts</h4>
                    <ul>
                        <li>
                            <a href="">Global Travel And Vacations  Luxury Travel On A Tight  Budget</a>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Photography</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>
                        <li>
                            <a href="">cooking for one</a>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Work</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>
                        <li>
                            <a href="">An Ugly Myspace Profile Will  Sure Ruin Your Reputation</a>
                            <div class="post-category-comment">
                                <a href="" class="post-category">Photography</a>
                                <a href="" class="post-comments">256 comments</a>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="widget widget_categories">
                    <h4 class="widget-title">post categories</h4>
                    <ul>
                        <li class="cat-item"><a href="">Audios</a>5</li>
                        <li class="cat-item"><a href="">Daili Inspiration</a>2</li>
                        <li class="cat-item"><a href="">Freelance</a>27</li>
                        <li class="cat-item"><a href="">Links</a>5</li>
                        <li class="cat-item"><a href="">Mobile</a>2</li>
                        <li class="cat-item"><a href="">Phography</a>27</li>
                    </ul>
                </section>
            </aside>

        </div><!-- #crt-sidebar-inner -->
    </div><!-- #crt-sidebar -->
    <footer id="crt-footer" class="crt-container-lg">
        <div class="crt-container">
            <div class="crt-container-sm clear-mrg text-center">
                <p>Criado por puro ódio @ Todos os direitos reservados 2018</p>
            </div>
        </div>
        <!-- .crt-container -->
    </footer>
    <!-- #crt-footer -->

    <button id="crt-button-up" title="Voltar ao topo." onclick="topFunction()" class="btn btn-icon btn-primary" style="display: block;"> <i class="fas fa-angle-double-up"></i> </button>

    <svg id="crt-bg-shape-1" class="hidden-sm hidden-xs" height="519" width="758">
        <polygon class="pol" points="0,455,693,352,173,0,92,0,0,71"/>
    </svg>

    <svg id="crt-bg-shape-2" class="hidden-sm hidden-xs" height="536" width="633">
        <polygon points="0,0,633,0,633,536"/>
    </svg>
</div>
<!-- .crt-wrapper -->

<!-- Scripts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset("assets/js/vendor/jquery-1.12.4.min.js") }}"><\/script>')</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiwY_5J2Bkv2UgSeJa4NOKl6WUezSS9XA"></script>

<script type="text/javascript" src="{{ asset('assets/js/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/theme.min.js') }}"></script>

<script>
    /** Scrolling button **/
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("crt-button-up").style.display = "block";
        } else {
            document.getElementById("crt-button-up").style.display = "none";
        }

        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById("reading-bar").style.width = scrolled + "%";
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>

@yield('custom_js')

</body>
</html>