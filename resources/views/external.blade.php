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
    });
    $(".table-of-contents a[href^='#']").on('click', function(e) {
        $('#toc').trigger('click');
        $('html, body').animate({
            scrollTop: $("[name="+$(this).attr('href').substring(1)+"]").offset().top - 60
            }, 300, function(){
        });
    });
    $("#selectSwitch").change(function() {
        if($(this).val() != '') {
            document.location.href = $(this).val();
        }
    });
});
</script>
@endpush

@section('content')
<div class="container bg-light shadow">
    <div class="row min-vh-100">
        <div class="col-12 text-break">
            <div class="sticky-top bg-light py-2 border-bottom mb-2 small">
                <div class="container">
                    <div class="row h-100">
                        <div class="col-6 col-md-8 my-auto">
                            <ul class="list-inline mb-0" id="menu">
                                <li class="list-inline-item"><a href="{{ route('contentLink',$content) }}" class="text-reset text-decoration-none"><i class="far fa-sticky-note"></i> Notes</a></li>
                                <li class="list-inline-item"><a href="" id="toc" class="text-reset text-decoration-none"><i class="fas fa-book-reader"></i> <span class="d-none d-md-inline-block">{{ __('Table of contents') }}</span></a></li>
                                <li class="list-inline-item"><a href="{{ route('editor.edit', $content) }}" class="text-reset text-decoration-none">@guest<i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline-block">{{ __('Login to') }}</span>@else<i class="fas fa-edit"></i>@endguest <span class="d-none d-md-inline-block">{{ __('Edit') }}</span></a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4">
                            <select class="custom-select" id="selectSwitch">
                                <option>{{ __('Other notes') }}</option>
                                <option disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
                                @foreach($otherContent as $oc)
                                <option value="{{ route('contentLink',$oc) }}">{{ $oc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-3 small sticky-top">
                <a class="navbar-brand" href="{{ route('contentLink',$content) }}"><i class="far fa-sticky-note"></i></a>
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
                    @if(count($otherContent) >= 1)
                    <form class="form-inline my-2 my-lg-0">
                    {{ __('Other notes') }}: <select class="custom-select ml-2">
                        @foreach($otherContent as $oc)
                        <option value="{{ $oc->slug }}">{{ $oc->name }}</option>
                        @endforeach
                    </select>
                    </form>
                    @endif
                </div>
            </nav> --}}
            @markdown{!! $content->content !!}@endmarkdown
        </div>
    </div>
</div>
@endsection