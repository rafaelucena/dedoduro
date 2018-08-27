@extends('layouts/test')

@section('content')
    {{--<div class="col-md-4">--}}
        {{--@include('includes.sidebar')--}}
    {{--</div>--}}
    <div id="crt-side-box-wrap" class="crt-sticky">
        <div id="crt-side-box" style="top: 0px; left: auto; width: auto; bottom: auto; position: relative;">
            <div class="crt-side-box-item">
                <div class="crt-card bg-primary text-center">
                    <div class="crt-card-avatar">
                        <img class="avatar avatar-195" src="Certy_files/avatar-195x195.png" srcset="assets/images/uploads/avatar/avatar-390x390-2x.png 2x" alt="" width="195" height="195">
                    </div>
                    <div class="crt-card-info">
                        <h2 class="text-upper">Lula</h2>
                        <p class="text-muted">Ex-presidente</p>
                        <ul class="crt-social clear-list">
                            <li><a><span class="crt-icon crt-icon-facebook"></span></a></li>
                            <li><a><span class="crt-icon crt-icon-twitter"></span></a></li>
                            <li><a><span class="crt-icon crt-icon-google-plus"></span></a></li>
                            <li><a><span class="crt-icon crt-icon-instagram"></span></a></li>
                            <li><a><span class="crt-icon crt-icon-pinterest"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="crt-side-box-btn">
                    <a class="btn btn-default btn-lg btn-block btn-thin btn-upper" href="#">Download Resume</a>
                </div>
            </div><!-- .crt-side-box-item -->

        </div><!-- #crt-side-box -->
    </div>
    <div class="col-md-8">
        <div class="card">
        <div class="card-header">Latest</div>

        <div class="card-body">

            @include('guest/partials/blogs-loop-box')

            <div class="row">
                <div class="col-md-12">
                    {{ 'what for' /*@TODO FIX PAGINATION*/ }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection