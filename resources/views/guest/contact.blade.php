@extends('layouts/front')

@section('content')
    {{--<div id="crt-side-box-wrap" class="crt-sticky">--}}
        {{--<div id="crt-side-box">--}}

            {{--<div class="crt-side-box-item">--}}

                {{--<div class="crt-card bg-primary text-center">--}}
                    {{--<div class="crt-card-avatar">--}}
                        {{--<img class="avatar avatar-195" src="{{ asset($ninja->info['image']) }}"--}}
                             {{--srcset="{{ asset('assets/images/uploads/avatar/avatar-390x390-2x.png') }} 2x" width="195" height="195" alt="">--}}
                    {{--</div>--}}
                    {{--<div class="crt-card-info">--}}
                        {{--<h2 class="text-upper">{{ $ninja->info['shortName'] }}</h2>--}}
                        {{--<p class="text-muted">{{ $ninja->info['roleName'] }} ({{ $ninja->info['partyName'] }})</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="crt-side-box-desc">--}}
                    {{--@foreach($ninja->details as $label => $value)--}}
                        {{--<p>--}}
                            {{--<small><strong>{{ $label }}</strong></small><br>--}}
                            {{--{{ $value }}--}}
                        {{--</p>--}}
                    {{--@endforeach()--}}
                {{--</div>--}}
            {{--</div><!-- .crt-side-box-item -->--}}

        {{--</div><!-- #crt-side-box -->--}}
    {{--</div><!-- #crt-side-box-wrap -->--}}
    <div id="crt-nav-wrap" class="hidden-sm hidden-xs">
        <div id="crt-nav-inner">
            <div class="crt-nav-cont">
                <div id="crt-nav-scroll">
                    <nav id="crt-nav" class="crt-nav">
                        <ul class="clear-list">
                            <li>
                                <a href="#about" data-tooltip="Perfil">
                                    <i class="far fa-address-card fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#news" data-tooltip="Notícias recentes">
                                    <i class="far fa-newspaper fa-2x"></i>
                                </a>
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
        <div id="contact" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">
                    <div class="padd-box">
                        <h2 class="title-lg text-upper">{!! $ninja->info['title'] !!}</h2>

                        <div class="padd-box-xs">
                            <header class="contact-head">
                                <ul class="crt-social clear-list text-primary">
                                    <li><a href="http://google.com"><i class="fab fa-facebook-square fa-2x"></i></a></li>
                                    <li><a href="http://google.com"><i class="fab fa-twitter-square fa-2x"></i></a></li>
                                    <li><a><i class="fab fa-google-plus-square fa-2x"></i></a></li>
                                    <li><a><i class="fab fa-slack fa-2x"></i></a></li>
                                    <li><a><i class="fab fa-linkedin fa-2x"></i></a></li>
                                </ul>
                                <h3 class="title">{!! $ninja->info['subtitle'] !!}</h3>
                            </header>
                        </div>

                        <div class="padd-box-sm">
                            <form action="{{ $ninja->action }}" method="post" class="contact-form" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('POST') }}

                                <div class="form-group">
                                    <label class="form-label" for="author">Nome</label>
                                    <div class="form-item-wrap">
                                        <input id="author" name="author" class="form-item" type="text" required="required"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">E-mail</label>
                                    <div class="form-item-wrap">
                                        <input id="email" name="email" class="form-item" type="email" required="required"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="subject">Assunto</label>
                                    <div class="form-item-wrap">
                                        <input id="subject" name="subject" class="form-item" type="text"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="message">Mensagem</label>
                                    <div class="form-item-wrap">
                                        <textarea id="message" name="message" class="form-item" required="required"></textarea>
                                    </div>
                                </div>

                                <div class="form-submit form-item-wrap">
                                    <input class="btn btn-primary btn-lg" type="submit" value="Envie sua mensagem">
                                </div>
                            </form>
                        </div>
                    </div><!-- .padd-box -->
                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->

        {{--@include('guest/politicians/show/show-about')--}}

        {{--@include('guest/politicians/show/show-news')--}}

        {{--        @include('guest/politicians/show/show-contact')--}}

    </div>
    <!-- .crt-container-sm -->
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
