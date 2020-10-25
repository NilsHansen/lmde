@extends('layout')

@push('cssfiles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
<style type="text/css">
body {
    background-color: #336699;
    font-family: 'Quicksand', serif;
}
</style>
@endpush

@section('title',$content->name)

@section('content')
<div class="container bg-light shadow">
    <div class="row min-vh-100 pt-3">
        <div class="col-12 overflow-hidden">@markdown{!! $content->content !!}@endmarkdown</div>
    </div>
</div>
@endsection