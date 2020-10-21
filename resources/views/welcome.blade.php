@extends('layout')

@push('javascript')
<script>
    $(document).ready(function() {
        $('#editor')
            .focus()
            .keyup(function() {
                $('#currentChars').text($(this).val().length)
            })
        ;
    });
</script>
@endpush

@section('title','Editmode')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <div class="col-12 col-md-6 bg-info">
            <textarea class="rounded border-0 w-100 p-3 text-black-50" spellcheck="false" id="editor" rows="10"></textarea>
            <hr class="my-2" />
            <div class="small row text-black-25">
                <div class="col-12 col-md-6">{{__('Characters')}}: <span id="currentChars">0</span></div>
                <div class="d-none d-md-block col-md-6 text-right">
                    {{__('Made with')}} <i class="fas fa-heart"></i> - {{__('Powered by')}} <i class="fab fa-laravel"></i> & <i class="fab fa-linux"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">

        </div>
    </div>
</div>
@endsection