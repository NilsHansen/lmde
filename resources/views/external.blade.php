@extends('layout')

@section('title',$content->name)

@push('cssfiles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
<style type="text/css">
body {
    background-color: #336699;
    font-family: 'Quicksand', serif;
}
</style>
@endpush

@push('javascript')
<script>
$(document).ready(function() {
    $("#toc").click(function(e) {
        e.preventDefault();
        if($('.table-of-contents').hasClass('d-none'))
            $('.table-of-contents').removeClass('d-none');
        else
            $('.table-of-contents').addClass('d-none');
    })
});
</script>
@endpush

@section('content')
<div class="container bg-light shadow">
    <div class="row min-vh-100">
        <div class="col-12 text-break">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-3 small sticky-top">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarExternal" aria-controls="navbarExternal" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarExternal">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="toc">{{ __('Table of contents') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('editor.edit', $content) }}">@guest {{ __('Login to') }} @endguest{{ __('Edit') }}</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                    {{ __('Other notes') }}: <select class="custom-select ml-2">
                        @foreach($otherContent as $oc)
                        <option value="{{ $oc->slug }}">{{ $oc->name }}</option>
                        @endforeach
                    </select>
                    </form>
                </div>
            </nav>
            @markdown{!! $content->content !!}@endmarkdown
        </div>
    </div>
</div>
@endsection