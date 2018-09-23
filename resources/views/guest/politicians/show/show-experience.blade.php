<div id="experience" class="crt-paper-layers crt-animate">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">

            <section class="section padd-box">
                <h2 class="title-lg text-upper">work experience</h2>
                <div class="action">
                @foreach ($ninja->actions as $action)
                    <div class="action-box">
                        {{--<time class="education-date" datetime="2014-01T2016-03">--}}
                        <time class="action-date" datetime="{{ $action['happenedAt']->format('Y-m-d\TH:i') }}">
                            <span>{!! $action['happenedAt']->format('d/m/Y') !!}</span>
                            {{--<span>Jan <strong class="text-upper">2014</strong> - Mar <strong>2016</strong></span>--}}
                        </time>
                        <h3><a target="_blank" href="https://themeforest.net/user/px-lab?ref=PX-lab">{{ $action['title'] }}</a></h3>

                        <div class="action-logo {{ $action['personaAction']['logo'] }}">
                            {!! $action['personaAction']['text'] !!}
                            {{--<i class="far fa-check-circle fa-2x"></i>--}}
                            {{--{{ if ($action['personaActionType']->name) }}--}}
                        </div>
                        {{--<div class="education-logo logo-success">--}}
                            {{--<i class="far fa-check-circle fa-2x"></i>--}}
                        {{--</div>--}}
                        {{--<div class="education-logo logo-danger">--}}
                            {{--<i class="far fa-times-circle fa-2x"></i>--}}
                        {{--</div>--}}
                        {{--<div class="education-logo logo-info">--}}
                            {{--<i class="fas fa-gavel fa-2x"></i>--}}
                        {{--</div>--}}
                        {{--<div class="education-logo logo-warning">--}}
                            {{--<i class="fas fa-comment-slash fa-2x"></i>--}}
                        {{--</div>--}}
                        @if (!empty($action['subtitle']))
                        <span class="action-company">{!! $action['subtitle'] !!}</span>
                        @endif
                        @if (!empty($action['description']))
                            <p>{!! $action['description'] !!}</p>
                        @endif
                    </div>
                @endforeach
                </div>
            </section>
            <!-- .section -->

        </div>
        <!-- .crt-paper-cont -->
    </div>
    <!-- .crt-paper -->
</div>
<!-- .crt-paper-layers -->
