@extends('layouts.front')

@section('content')
    <div class="crt-container-sm">
        <div class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <div class="padd-box-sm">
                        <header class="search-for">
                            <h1 class="search-title text-muted">procurando por:
                                <span>Lorem ipsum</span></h1>
                        </header>
                        <div class="search-result">
                            <strong class="title-lg text-upper">vish... deu ruim...</strong>
                            <strong class="title-lg text-muted">ENCONTRAMOS UM TOTAL DE:<br><br>0 resultados</strong>
                            <form class="search-again">
                                <div class="form-item-wrap">
                                    <input class="form-item" id="searchInput" name="searchInput" type="search"
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
