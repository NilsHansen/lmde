@extends('layout')

@section('title','Welcome')

@push('cssfiles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
<style type="text/css">
body {
    background-color: #336699;
    font-family: 'Quicksand', serif;
}

a:hover {
    text-decoration: none;
}

.note:hover {
    background-color: #6699FF!important;
}
</style>
@endpush

@section('content')
<div class="container bg-light shadow">
    <div class="row min-vh-100">
        <div class="col-12 text-break" id="content">
            <div class="sticky-top bg-light py-2 border-bottom mb-5 small">
                <div class="container">
                    <div class="row h-100">
                        <div class="col-6 col-md-8 my-auto">
                            <ul class="list-inline mb-0" id="menu">
                                <li class="list-inline-item"><a href="{{ route('start') }}" class="text-reset text-decoration-none"><i class="far fa-sticky-note"></i> Notes</a></li>
                                <li class="list-inline-item d-print-none"><a href="{{ route('editor.index') }}" class="text-reset text-decoration-none">@guest<i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline-block">{{ __('Login') }}</span>@else<i class="fas fa-edit"></i> <span class="d-none d-md-inline-block">{{ __('Editor') }}</span>@endguest</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4 text-right">
                            <form method="get" action="{{ route('start') }}">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="q" value="{{ request()->input('q') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($notes as $n)            
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="border rounded p-3 bg-white note mb-4">
                    <a href="{{ route('contentLink',$n) }}" class="text-reset">
                        <h5 class="text-truncate" title="{{ $n->name }}">{{ $n->name }}</h5>
                        <div class="row mt-3">
                            <div class="small col-6 pl-4">
                                <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($n->updated_at)->format('d.m.Y, H:i')}} <br />
                                <i class="fas fa-scroll"></i> {{ str_word_count($n->content) }}
                            </div>
                            <div class="col-6 text-right pr-4">
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($n->user->email)) }}?&s=40" class="rounded-circle" />
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    {{ __("There were no notes found.") }}
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection