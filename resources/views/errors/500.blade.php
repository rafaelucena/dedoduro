@extends('layouts/front')

@section('content')
    <div class="crt-container-sm">
        <div class="crt-paper-layers">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">

                    <div class="padd-box-sm">
                        <div class="text-center">
                            <strong class="title-404 text-upper">500</strong>
                            <span class="info-404">
                                Estamos a exatamente :dias: sem alguém quebrar alguma coisa.<br>
                                Nosso recorde é de :maxdias:!<br>
                                <br>
                            </span>
                            <a class="btn btn-primary" href="/">Clique para <strike>chorar</strike> voltar</a>
                        </div>
                    </div>

                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
    </div>
    <!-- .crt-container-sm -->
@endsection
