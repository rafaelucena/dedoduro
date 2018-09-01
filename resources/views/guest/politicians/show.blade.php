@extends('layouts/front')

@section('content')
    <div id="crt-side-box-wrap" class="crt-sticky">
        <div id="crt-side-box">

            <div class="crt-side-box-item">

                <div class="crt-card bg-primary text-center">
                    <div class="crt-card-avatar">
                        <img class="avatar avatar-195" src="{{ asset('assets/images/uploads/avatar/avatar-195x195.png') }}"
                             srcset="{{ asset('assets/images/uploads/avatar/avatar-390x390-2x.png') }} 2x" width="195" height="195" alt="">
                    </div>
                    <div class="crt-card-info">
                        <h2 class="text-upper">{{ $persona->shortName }}</h2>
                        <p class="text-muted">{{ $role->name }}</p>
                    </div>
                </div>
                <div class="crt-side-box-desc">
                    <p>
                        <small><strong>Nome</strong></small><br>
                        {{ $persona->firstName }}
                    </p>
                    <p>
                        <small><strong>Sobrenome</strong></small><br>
                        {{ $persona->lastName }}
                    </p>
                </div>
            </div><!-- .crt-side-box-item -->

        </div><!-- #crt-side-box -->
    </div><!-- #crt-side-box-wrap -->
    <div id="crt-nav-wrap" class="hidden-sm hidden-xs">
        <div id="crt-nav-inner">
            <div class="crt-nav-cont">
                <div id="crt-nav-scroll">
                    <nav id="crt-nav" class="crt-nav">
                        <ul class="clear-list">
                            <li>
                                <a href="index.php#about" data-tooltip="Home">
                                    <img class="avatar avatar-42" src="{{ asset('assets/images/uploads/avatar/avatar-42x42.png') }}" srcset="{{ asset('assets/images/uploads/avatar/avatar-84x84-2x.png') }} 2x" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="index.php#experience" data-tooltip="Experience">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <a href="index.php#portfolio" data-tooltip="Portfolio">
                                    <i class="fas fa-pen-fancy fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <a href="index.php#references" data-tooltip="References">
                                    <i class="fas fa-quote-right fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <a href="index.php#contact" data-tooltip="Contact">
                                    <i class="far fa-envelope fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <a href="category.php" data-tooltip="Blog"><span class="crt-icon crt-icon-blog"></span></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div id="crt-nav-tools" class="hidden">
                    <span class="crt-icon crt-icon-dots-three-horizontal"></span>

                    <button id="crt-nav-arrow" class="clear-btn">
                        <span class="crt-icon crt-icon-chevron-thin-down"></span>
                    </button>
                </div>
            </div>
            <div class="crt-nav-btm"></div>
        </div>
    </div><!-- .crt-nav-wrap -->
    <div class="crt-container-sm">
        @include('guest/politicians/show/show-news')

        @include('guest/politicians/show/about')

        <div id="experience" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper">work experience</h2>
                        <div class="education">

                            <div class="education-box">
                                <time class="education-date" datetime="2014-01T2016-03">
                                    <span>Jan <strong class="text-upper">2014</strong> - Mar <strong>2016</strong></span>
                                </time>
                                <h3>Full Stack Developer</h3>
                                <div class="education-logo">
                                    <img src="{{ asset('assets/images/uploads/experience/logo-audio-jungle.png') }}" alt="">
                                </div>
                                <span class="education-company">IBBA Group</span>
                                <p>Your brand is the core of your marketing,
                                    the central theme around your products and services.
                                    Your brand is not your Logo or your Company Name
                                </p>
                            </div>
                            <!-- .education-box -->

                            <div class="education-box">
                                <time class="education-date" datetime="2014-01T2016-03">
                                    <span>Jan <strong class="text-upper">2014</strong> - Mar <strong>2016</strong></span>
                                </time>
                                <h3>Systems Analyst / Web Developer</h3>
                                <div class="education-logo">
                                    <img src="{{ asset('assets/images/uploads/experience/logo-themeforest.png') }}" alt="">
                                </div>
                                <span class="education-company">Loft Studio</span>
                                <p>
                                    Your brand is the core of your marketing, the central theme around your products and services.
                                </p>
                            </div>
                            <!-- .education-box -->

                            <div class="education-box">
                                <time class="education-date" datetime="2014-01T2016-03">
                                    <span>Jan <strong class="text-upper">2014</strong> - Mar <strong>2016</strong></span>
                                </time>
                                <h3>Full Stack Developer</h3>
                                <div class="education-logo">
                                    <img src="{{ asset('assets/images/uploads/experience/logo-envato.png') }}" alt="">
                                </div>
                                <span class="education-company">Stu Unger Rise</span>
                                <p>Your brand is the core of your marketing, the central theme around your products and services.</p>
                            </div>
                            <!-- .education-box -->

                        </div>
                        <!-- .education -->
                    </section>
                    <!-- .section -->

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->

        <div id="portfolio" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper padd-box">portfolio</h2>

                        <div class="pf-wrap">
                            <div class="pf-filter padd-box">
                                <button data-filter="*">all</button>
                                <button data-filter=".photography">photography</button>
                                <button data-filter=".design">design</button>
                            </div><!-- .pf-filter -->

                            <div class="pf-grid">
                                <div class="pf-grid-sizer"></div><!-- used for sizing -->

                                <div class="pf-grid-item photography">
                                    <a class="pf-project" href="#pf-popup-1">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text clear-mrg">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-1" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item design">
                                    <a class="pf-project" href="#pf-popup-2">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-02.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text clear-mrg">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-2" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-02.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item photography">
                                    <a class="pf-project" href="#pf-popup-3">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-03.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text clear-mrg">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-3" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-03.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-03.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-03.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item design">
                                    <a class="pf-project" href="#pf-popup-4">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-04.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stunger rise</h2>

                                                    <div class="pf-text">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-4" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-04.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-04.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-04.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item photography">
                                    <a class="pf-project" href="#pf-popup-5">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-05.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-5" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-05.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-05.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-05.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item design">
                                    <a class="pf-project" href="#pf-popup-6">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-06.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text clear-mrg">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-6" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-06.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-06.jpg') }}" alt="">
                                                </div>

                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-06.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->

                                <div class="pf-grid-item photography">
                                    <a class="pf-project" href="#pf-popup-7">
                                        <figure class="pf-figure">
                                            <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                        </figure>

                                        <div class="pf-caption text-center">
                                            <div class="valign-table">
                                                <div class="valign-cell">
                                                    <h2 class="pf-title text-upper">stu unger rise</h2>

                                                    <div class="pf-text clear-mrg">
                                                        <p>Accessories Here you can find the best computer monitor, printer, scanner, speaker, projector. hardware and more</p>
                                                    </div>

                                                    <button class="pf-btn btn btn-primary">View More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a><!-- .pf-project -->

                                    <div id="pf-popup-7" class="pf-popup clearfix">
                                        <div class="pf-popup-col1">
                                            <div class="pf-popup-media cr-slider" data-init="none">
                                                <div class="pf-popup-embed">
                                                    <img src="{{ asset('assets/images/uploads/portfolio/prj-01.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div><!-- .pf-popup-col1 -->

                                        <div class="pf-popup-col2">
                                            <div class="pf-popup-info">
                                                <h2 class="pf-popup-title text-upper">Rs Project</h2>

                                                <div class="text-muted"><strong>design / development</strong></div>

                                                <dl class="dl-horizontal">
                                                    <dt>Date:</dt>
                                                    <dd>11 Jan 2012</dd>

                                                    <dt>Site link:</dt>
                                                    <dd><a href="www.sitedomen.com">www.sitedomen.com</a></dd>

                                                    <dt>Client:</dt>
                                                    <dd>11 Jan 2012</dd>
                                                </dl>

                                                <p>About 64% of all on-line teens say that do things online that they wouldn’t want their
                                                    parents to know about. 11% of all adult internet users visit dating websites and spend their
                                                    time in chatrooms.</p>
                                            </div><!-- .pf-popup-info -->

                                            <div class="pf-popup-rel">
                                                <h2 class="text-upper">More Projects</h2>

                                                <div class="pf-rel-list cr-carousel" data-init="none">
                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>

                                                    <div class="pf-rel-prj">
                                                        <img src="{{ asset('assets/images/uploads/portfolio/prj-rel-01.jpg') }}" alt="">
                                                        <a class="pf-rel-cover" href="">
                                                            <button class="btn btn-primary btn-sm">View</button>
                                                        </a>
                                                    </div>
                                                </div><!-- .pf-rel-projects -->
                                            </div><!-- .pf-popup-rel -->
                                        </div><!-- .pf-popup-col2 -->
                                    </div><!-- .pf-popup -->
                                </div><!-- .pf-grid-item -->
                            </div><!-- .pf-grid -->
                        </div><!-- .pf-wrap -->
                    </section>
                    <!-- .section -->

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->

        <div id="references" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper">References</h2>

                        <div class="padd-box-sm clear-mrg">
                            <div class="ref-box brd-btm hreview">
                                <div class="ref-avatar">
                                    <img alt="" src="{{ asset('assets/images/uploads/avatar/avatar-54x54-01.png') }}" srcset="{{ asset('assets/images/uploads/avatar/avatar-108x108-01-2x.png') }} 2x" class="avatar avatar-54 photo" height="54" width="54">
                                </div>

                                <div class="ref-info">
                                    <div class="ref-author">
                                        <strong>Hattie Maxwell</strong>
                                        <span>West Alexandrine</span>
                                    </div>

                                    <blockquote class="ref-cont clear-mrg">
                                        <p>Your brand is the core of your marketing, the central
                                            theme around your products and services.Your brand is not your Logo or your Company Name
                                        </p>
                                    </blockquote>
                                </div>
                            </div><!-- .ref-box -->

                            <div class="ref-box brd-btm hreview">
                                <div class="ref-avatar">
                                    <img alt="" src="{{ asset('assets/images/uploads/avatar/avatar-54x54-02.png') }}" srcset="{{ asset('assets/images/uploads/avatar/avatar-108x108-02-2x.png') }} 2x" class="avatar avatar-54 photo" height="54" width="54">
                                </div>

                                <div class="ref-info">
                                    <div class="ref-author">
                                        <strong>franklin may</strong>
                                        <span>Modern LLC,HR</span>
                                    </div>

                                    <blockquote class="ref-cont clear-mrg">
                                        <p>Your brand is the core of your marketing, the central
                                            theme around your products and services.Your brand is not your Logo or your Company Name
                                        </p>
                                    </blockquote>
                                </div>
                            </div><!-- .ref-box -->
'
                            <div class="ref-box brd-btm hreview">
                                <div class="ref-avatar">
                                    <img alt="" src="{{ asset('assets/images/uploads/avatar/avatar-58x58-default.png') }}" srcset="{{ asset('assets/images/uploads/avatar/avatar-116x116-default-2x.jpg') }} 2x" class="avatar avatar-54 photo" height="54" width="54">
                                </div>

                                <div class="ref-info">
                                    <div class="ref-author">
                                        <strong>edwin ballard</strong>
                                        <span>West Alexandrine</span>
                                    </div>

                                    <blockquote class="ref-cont clear-mrg">
                                        <p>Your brand is the core of your marketing, the central
                                            theme around your products and services.Your brand is not your Logo or your Company Name
                                        </p>
                                    </blockquote>
                                </div>
                            </div><!-- .ref-box -->

                        </div><!-- .padd-box-sm -->
                    </section>
                    <!-- .section -->

                    <section class="section clear-mrg padd-box">
                        <h2 class="title-lg text-upper">Clients</h2>
                        <div class="padd-box-sm">
                            <ul class="clients">
                                <li><a href=""><img src="{{ asset('assets/images/uploads/clients/logo-wordpress.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-wordpress-2x.png') }} 2x" alt="WordPress"></a></li><li>
                                    <a href=""><img src="{{ asset('assets/images/uploads/clients/logo-compass.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-compass-2x.png') }} 2x" alt="Compass"></a></li><li>
                                    <a href=""><img src="{{ asset('assets/images/uploads/clients/logo-jquery.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-jquery-2x.png') }} 2x" alt="jQuery"></a></li><li>
                                    <a href=""><img src="{{ asset('assets/images/uploads/clients/logo-teaspoon.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-teaspoon-2x.png') }} 2x" alt="teaspoon"></a></li><li>
                                    <a href=""><img src="{{ asset('assets/images/uploads/clients/logo-evernote.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-evernote-2x.png') }} 2x" alt="evernote"></a></li><li>
                                    <a href=""><img src="{{ asset('assets/images/uploads/clients/logo-bootstrap.png') }}" srcset="{{ asset('assets/images/uploads/clients/logo-bootstrap-2x.png') }} 2x" alt="Bootstrap"></a></li>
                            </ul>
                        </div><!-- .padd-box-sm -->
                    </section><!-- .section -->

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->

        <div id="contact" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">
                    <div class="padd-box">
                        <h2 class="title-lg text-upper">contact me</h2>

                        <div class="padd-box-xs">
                            <header class="contact-head">
                                <ul class="crt-social clear-list text-primary">
                                    <li><a><span class="crt-icon crt-icon-facebook"></span></a></li>
                                    <li><a><span class="crt-icon crt-icon-twitter"></span></a></li>
                                    <li><a><span class="crt-icon crt-icon-google-plus"></span></a></li>
                                    <li><a><span class="crt-icon crt-icon-instagram"></span></a></li>
                                    <li><a><span class="crt-icon crt-icon-pinterest"></span></a></li>
                                </ul>
                                <h3 class="title text-upper">fell free to contact me the core of your marketing</h3>
                            </header>
                        </div>

                        <div class="padd-box-sm">
                            <form action="#" method="post" class="contact-form">

                                <div class="form-group">
                                    <label class="form-label" for="author">Your Name</label>
                                    <div class="form-item-wrap">
                                        <input id="author" class="form-item" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Your E-mail</label>
                                    <div class="form-item-wrap">
                                        <input id="email" class="form-item" type="email" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="url">Subject</label>
                                    <div class="form-item-wrap">
                                        <input id="url" class="form-item" type="url">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="comment">Your Comment</label>
                                    <div class="form-item-wrap">
                                        <textarea id="comment" class="form-item"></textarea>
                                    </div>
                                </div>

                                <div class="form-submit form-item-wrap">
                                    <input class="btn btn-primary btn-lg" type="submit" value="Post Your Comment">
                                </div>
                            </form>
                        </div>
                    </div><!-- .padd-box -->

                    {{--<div id="map" data-latitude="50.84592" data-longitude="4.366859999999974"></div>--}}
                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->
    </div>
    <!-- .crt-container-sm -->
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $('#recent-news').DataTable({
                language: {
                    search: "Filtro:",
                    // searchPlaceholder: "Filtro...",
                    info: "Exibindo _END_ de _TOTAL_ not&iacute;cias",
                },
                searching: false,
                bPaginate: false,
            });
            // $(".dataTables_filter input").addClass("form-item");
        });
    </script>
@endsection
