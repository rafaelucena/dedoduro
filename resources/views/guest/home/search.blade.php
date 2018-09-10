@extends('layouts.front')

@section('content')
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
                            @endif
                            <form action="{{ $ninja->action }}" method="post" class="search-again" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('GET') }}
                                <div class="form-item-wrap">
                                    <input class="form-item" id="query" name="query" type="search"
                                           placeholder="Busque por nome ou por título da notícia" value="" size="30" maxlength="80" required="required">
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
                            @foreach($ninja->results['list'] as $recentNewsPolitician)
                                @include('guest/home/partials/home/home-recent-politicians')
                            @endforeach
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

        });
    </script>
@endsection
