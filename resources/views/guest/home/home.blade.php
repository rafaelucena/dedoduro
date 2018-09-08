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
