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
        <div class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <div class="padd-box-sm">
                        <div class="text-center">
                            <strong class="title-404 text-upper">204</strong>
                            <span class="info-404">Esta página ficou retida no <br>centro de distribuição de curitiba.<br>
                                <br>
                                <br>
                                Favor aguardar a liberação.</span>
                            <a class="btn btn-primary" href="/">Clique para <strike>chorar</strike> voltar</a>
                        </div>
                    </div>

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        {{--@include('guest/politicians/show/show-about')--}}

        {{--@include('guest/politicians/show/show-news')--}}

        {{--        @include('guest/politicians/show/show-contact')--}}

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
                    info: "Exibindo de _START_ a _END_ de _TOTAL_ not&iacute;cias",
                    oPaginate: {
                        // sFirst: '<i class="fas fa-step-backward"></i> First',
                        sPrevious: 'Anterior',
                        sNext: 'Próxima',
                        // sLast: 'Last <i class="fas fa-step-forward"></i>'
                    },
                },
                searching: false,
                bLengthChange: false,
                pageLength: 7,
                order: [
                    [2, "desc"]
                ],
                drawCallback: function () {
                    $('.dataTables_info').addClass('crt-table-info');
                    $('.dataTables_paginate').addClass('crt-table-paginator');
                    $('.paginate_button').addClass('btn-pagination btn-pagination-numbers');
                }
            });
        });
    </script>
@endsection
