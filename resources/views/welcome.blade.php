@extends('layout')

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor')
            .focus()
            .keyup(function() {
                $('#currentChars').text($(this).val().length);
                $('#preview').html(marked($(this).val()));
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
        <div class="col-12 col-md-6 mt-3 small">
            <div class="row">
                <div class="col-12 text-right">
                    <div class="dropdown">
                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                            {{ __('Logged In as') }}: {{ Auth::user()->name }} <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?&s=40" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item small" href="#">{{ __('Profile') }}</a>
                            <a class="dropdown-item small" id="logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-12 bg-info py-4 text-black-50">
                    Test
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-12" id="preview">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
@endsection