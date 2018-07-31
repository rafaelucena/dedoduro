@extends('layouts.app')

@section('pageTitle', 'Search "'.$query.'" - '.app('global_settings')[0]->settingValue)

@section('content')
<div class="card">
    <div class="card-header">Search "{{ $query }}"</div>

    <div class="card-body">

        @include('guest.partials.blogs-loop-box')

        <div class="row">
            <div class="col-md-12">
                {{ 'what for' /*$blogs->appends(['q' => $query])->links()*/ //@TODO FIX PAGINATION }}
            </div>
        </div>

    </div>
</div>
@endsection