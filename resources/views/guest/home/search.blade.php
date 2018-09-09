@extends('layouts.front')

@section('content')
    <div class="crt-container-sm">
        <div class="crt-paper-layers">
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
                            @if ($ninja->results['count'] === 0)
                                <strong class="title-lg text-upper">vish... deu ruim...</strong>
                            @endif
                            <strong class="title-lg text-muted">ENCONTRAMOS UM TOTAL DE:<br><br>{{ $ninja->results['count'] }} resultados</strong>
                            <form action="{{ $ninja->action }}" method="post" class="search-again" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('GET') }}
                                <div class="form-item-wrap">
                                    <input class="form-item" id="query" name="query" type="search"
                                           placeholder="Busque por nome ou por título da notícia" value="" size="30" maxlength="80" required="required">
                                </div>
                                <div class="form-submit form-item-wrap">
                                    <input class="btn btn-default" name="submit" type="submit" id="submit" value="Agora vai!">
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

    </div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
