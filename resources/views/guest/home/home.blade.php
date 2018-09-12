@extends('layouts.front')

@section('content')
    <div class="crt-container-sm">
        <div id="about" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section brd-btm padd-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="title-lg text-upper">Não repara na bagunça... viu?</h2>

                                <div class="text-box">
{{--                                    {!! $ninja->info['longDesc'] !!}--}}
                                    <p>
                                        <b>Bem vindo à página Dedoduro!</b><br>
                                    </p>
                                    <p>
                                        Aqui você vai, inicialmente, encontrar várias notícias mapeadas sobre os mais diversos
                                        políticos da atualidade.<br>
                                        <br>
                                        O principal objetivo desse sistema é que as notícias não caiam mais no esquecimento.
                                        Como vem acontecendo. Mas isso é um processo natural da internet. Então é isso.<br>
                                        <br>
                                        Ah! Essa é a fase beta do sistema, vai ter mais, muito mais, então não vai ainda não, tá cedo!
                                        Se tiver alguma idéia, dúvida, ou reclamação (por direitos autorais inclusive), entre em contato
                                        por aqui ou pelas redes disponíveis. :)<br>
                                        <br>
                                        <strong>PS. Todos os políticos disponíveis podem ser encontrados na aba "<a href="/busca">Busca!</a>"</strong><br>
                                        <br>
                                        Até logo!<br>
                                        Rafael.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div id="politicians" class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper">Políticos recentes</h2>

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
