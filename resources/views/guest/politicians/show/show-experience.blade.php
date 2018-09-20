<div id="experience" class="crt-paper-layers crt-animate">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">

            <section class="section padd-box">
                <h2 class="title-lg text-upper">work experience</h2>
                <div class="education">
                @foreach ($ninja->actions as $action)
                    <div class="education-box">
                        {{--<time class="education-date" datetime="2014-01T2016-03">--}}
                        <time class="education-date" datetime="{{ $action['happenedAt']->format('Y-m-d\TH:i') }}">
                            <span>{!! $action['happenedAt']->format('j \of F Y') !!}</span>
                            {{--<span>Jan <strong class="text-upper">2014</strong> - Mar <strong>2016</strong></span>--}}
                        </time>
                        <h3><a target="_blank" href="https://themeforest.net/user/px-lab?ref=PX-lab">{{ $action['title'] }}</a></h3>
                        <div class="education-logo">
                            <i class="far fa-check-circle fa-2x"></i>
                            <i class="fas fa-times-circle fa-2x"></i>
                            <i class="fas fa-gavel fa-2x"></i>
                            <i class="fas fa-user-minus fa-2x"></i>
                        </div>
                        @if (!empty($action['subtitle']))
                        <span class="education-company">{!! $action['subtitle'] !!}</span>
                        @endif
                        @if (!empty($action['description']))
                            <p>{!! $action['description'] !!}</p>
                        @endif
                    </div>
                @endforeach
                </div>
                <div class="container-right">
                    <ul>
                        <li><span></span>
                            <div>
                                <div class="title">Codify</div>
                                <div class="info">Let&apos;s make coolest things in css</div>
                                <div class="type">Presentation</div>
                            </div> <span class="number"><span>10:00</span></span>
                        </li>
                        <li>
                            <div><span></span>
                                <div class="title">Presidente do Brasil</div>
                                <div class="info">Reeleito</div>
                                <div class="type">Presentation</div>
                            </div> <span class="number"><span>2011</span></span>
                        </li>
                        <li>
                            <div><span></span>
                                <div class="title">Deputado Federal (SP)</div>
                                <div class="info">Let&apos;s make coolest things in css</div>
                                <div class="type">Review</div>
                            </div> <span class="number"><span>1991</span></span>
                        </li>
                    </ul>
                </div>
                <div class="container">
                    <ul>
                        <li>
                            <div>
                                <span></span>
                                <div class="title">Codify</div>
                                <div class="info">Let&apos;s make coolest things in css</div>
                                <div class="type">Presentation</div>
                            </div> <span class="number"><span>10:00</span> <span>12:00</span></span>
                        </li>
                        <li class="single">
                            <div>
                                <span></span>
                                <div class="title">Single</div>
                                <div class="info">Let&apos;s make coolest things in css</div>
                                <div class="type">Presentation</div>
                            </div> <span class="number"><span>10:00</span></span>
                        </li>
                        <li>
                            <div><span></span>
                                <div class="title">Presidente do Brasil</div>
                                <div class="info">Reeleito</div>
                                <div class="type">Presentation</div>
                            </div> <span class="number"><span>2011</span> <span>2003</span></span>
                        </li>
                        <li>
                            <div><span></span>
                                <div class="title">Deputado Federal (SP)</div>
                                <div class="info">Let&apos;s make coolest things in css</div>
                                <div class="type">Review</div>
                            </div> <span class="number"><span>1991</span> <span>1987</span></span>
                        </li>
                    </ul>
                </div>
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
