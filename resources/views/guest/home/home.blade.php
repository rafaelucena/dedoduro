@extends('layouts.front')

@section('content')
    <div class="crt-container-sm">
        <div id="about" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section brd-btm padd-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="title-lg text-upper">Perfil</h2>

                                <div class="text-box">
{{--                                    {!! $ninja->info['longDesc'] !!}--}}
                                    <p>
                                        <b>Olá, essa é a página Dedoduro!</b><br>
                                    </p>
                                    <p>
                                        Eu decidi criar essa página pra ajudar a mapear notícias de diversas personalidades
                                        no mundo político e/ou próximo dele.
                                    <br>A idéia é não perder de vista notícias de alguns candidatos nunca mais.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div id="politicians" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper">Políticos</h2>

                        <div class="padd-box-sm clear-mrg">
                            @foreach($recentNewsPoliticians as $recentNewsPolitician)
                                @include('guest/home/partials/home/home-recent-politicians')
                            @endforeach
                        </div><!-- .padd-box-sm -->
                    </section>

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->
    </div>
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
