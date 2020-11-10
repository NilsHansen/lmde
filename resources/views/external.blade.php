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
    $("#content a[href^='#']").on('click', function(e) {
        if(!$('.table-of-contents').hasClass('d-none')) {
            $('#toc').trigger('click');
        }
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
        <div class="col-12 text-break" id="content">
            <div class="sticky-top bg-light py-2 border-bottom mb-2 small">
                <div class="container">
                    <div class="row h-100">
                        <div class="col-6 col-md-8 my-auto">
                            <ul class="list-inline mb-0" id="menu">
                                <li class="list-inline-item"><a href="{{ route('contentLink',$content) }}" class="text-reset text-decoration-none"><i class="far fa-sticky-note"></i> Notes</a></li>
                                <li class="list-inline-item d-print-none"><a href="" id="toc" class="text-reset text-decoration-none"><i class="fas fa-book-reader"></i> <span class="d-none d-md-inline-block">{{ __('Table of contents') }}</span></a></li>
                                <li class="list-inline-item d-print-none"><a href="{{ route('editor.edit', $content) }}" class="text-reset text-decoration-none">@guest<i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline-block">{{ __('Login to') }}</span>@else<i class="fas fa-edit"></i>@endguest <span class="d-none d-md-inline-block">{{ __('Edit') }}</span></a></li>
                                <li class="list-inline-item d-print-none"><a href="javascript:window.print()" class="text-reset text-decoration-none"><i class="fas fa-print"></i> @lang('Print')</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4">
                            @if(count($otherContent) >= 1)
                            <select class="custom-select d-print-none" id="selectSwitch">
                                <option>{{ __('Other notes') }}</option>
                                <option disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
                                @foreach($otherContent as $oc)
                                <option value="{{ route('contentLink',$oc) }}">{{ $oc->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @markdown{!! $content->content !!}@endmarkdown
        </div>
    </div>
</div>
@endsection