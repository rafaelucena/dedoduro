@extends('layouts.front')

@section('content')
    <div id="crt-side-box-wrap" class="crt-sticky">
        <div id="crt-side-box">

            <div class="crt-side-box-item">

                <div class="crt-card bg-primary text-center">
                    <h2 class="text-upper">Lista</h2>
                </div>
                {{--@foreach($ninja->sideList as $item)--}}
                    {{--<a href="{{ route('politician.show', ['slug' => $item['personUrn']]) }}">--}}
                    {{--<div class="crt-side-box-desc">--}}
                        {{--<p>--}}
                            {{--<img alt="" src="{{ asset('storage/' . $item['personImage']) }}" class="avatar avatar-54 photo" width="40" height="40">--}}
                            {{--<small><strong>{{ $item['personName'] }}</strong></small><br>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                {{--@endforeach()--}}
                <table id="side-list" class="side-list mdl-data-table">
                    <thead>
                    <tr>
                        <th style="width: 20%">Foto</th>
                        <th style="width: 80%">Nome</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@for($i=0; $i<5; $i++)--}}
                    @foreach($ninja->sideList as $item)
                        <tr>
                            <td class="cst-side-list">
                                <a href="{{ route('politician.show', ['slug' => $item['personUrn']]) }}"><img alt="" src="{{ asset('storage/' . $item['personImage']) }}" class="avatar avatar-54 photo" width="40" height="40"></a>
                            </td>
                            <td class="cst-side-list"><small><strong><a href="{{ route('politician.show', ['slug' => $item['personUrn']]) }}">{{ $item['personName'] }}</a></strong></small></td>
                        </tr>
                    @endforeach()
                    </tbody>
                    {{--@endfor--}}
                </table>
            </div><!-- .crt-side-box-item -->

        </div><!-- #crt-side-box -->
    </div><!-- #crt-side-box-wrap -->
    <div class="crt-container-sm">
        <div id="search" class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <div class="padd-box-sm">
                        @if ($ninja->searchBy['visible'])
                            <header class="search-for">
                                <h1 class="search-title text-muted">procurando por:
                                    <span>{{ $ninja->searchBy['query'] }}</span></h1>
                            </header>
                        @endif
                        <div class="search-result">
                            @if ($ninja->searchBy['visible'])
                                @if ($ninja->results['count'] === 0)
                                    <strong class="title-lg text-upper">vish... deu ruim...</strong>
                                @endif
                                <strong class="title-lg text-muted">ENCONTRAMOS UM TOTAL DE:<br><br>{{ $ninja->results['count'] }} resultados</strong>
                            @else
                                <strong class="title-lg text-upper">Busque aqui pelo abençoado</strong>
                            @endif
                            <form action="{{ $ninja->action }}" method="post" class="search-again" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('GET') }}
                                <div class="form-item-wrap">
                                    <input class="form-item" id="query" name="query" type="search"
                                           placeholder="Nome do fulano" value="" size="80" maxlength="80" required="required">
                                </div>
                                <div class="form-submit form-item-wrap">
                                    <input class="btn btn-default" name="submit" type="submit" id="submit" value="@if ($ninja->searchBy['visible'] && $ninja->results['count'] === 0) Agora vai! @elseif ($ninja->searchBy['visible']) Outra vez! @else Buscar! @endif">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- .crt-paper-cont -->
            </div>
        <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->
        @if ($ninja->results['count'] > 0)
        <div id="politicians" class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <section class="section padd-box">
                        <h2 class="title-lg text-upper">Políticos</h2>

                        <div class="padd-box-sm clear-mrg">
                            @for ($i = 0; $i < 10; $i++)
                            @foreach($ninja->results['list'] as $recentNewsPolitician)
                                @include('guest/home/partials/home/home-recent-politicians')
                            @endforeach
                            @endfor
                        </div><!-- .padd-box-sm -->
                    </section>

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        @endif

    </div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $('.side-list').DataTable({
                language: {
                    oPaginate: {
                        // sFirst: '<i class="fas fa-step-backward"></i> First',
                        sPrevious: 'Anterior',
                        sNext: 'Próxima',
                        // sLast: 'Last <i class="fas fa-step-forward"></i>'
                    },
                },
                searching: false,
                bLengthChange: false,
                info: false,
                pageLength: 5,
                columnDefs: [
                    { orderable: false, targets: 0}
                ],
                order: [
                    [1, "asc"]
                ],
                drawCallback: function () {
                    $('.dataTables_info').addClass('crt-table-info');
                    $('.dataTables_paginate').addClass('crt-list-paginator');
                    $('.paginate_button').addClass('btn-pagination btn-pagination-numbers');
                }
            });
        });
    </script>
@endsection
