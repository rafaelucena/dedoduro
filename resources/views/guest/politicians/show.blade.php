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

        @include('guest/politicians/show/show-about')

{{--        @include('guest/politicians/show/show-experience')--}}

{{--        @include('guest/politicians/show/show-portfolio')--}}

{{--        @include('guest/politicians/show/show-references')--}}

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
                pageLength: 5,
                drawCallback: function () {
                    $('.dataTables_info').addClass('crt-table-info');
                    $('.dataTables_paginate').addClass('crt-table-paginator');
                    $('.dataTables_paginate > .paginate_button').addClass('btn-pagination btn-pagination-numbers');
                    $('.dataTables_paginate > span > .paginate_button').addClass('btn-pagination btn-pagination-numbers');
                }
            });
        });
    </script>
@endsection
