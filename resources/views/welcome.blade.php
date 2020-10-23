@extends('layout')

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    $(document).ready(function() {
        var saveAble = 0;
        $('#editor')
            .keyup(function() {
                $('#currentChars').text($(this).val().length);
                $('#preview').html(marked($(this).val()));
                saveAble = 1;
        });
        
        /*setInterval(function() {
            if(saveAble == 1) {
                $.post('{{ route('editor.update', '1') }}', { editor: $('#editor').val() });
                saveAble = 0;
            }
        }, 5000);*/
        $('#editName').focus();
    });
</script>
@endpush

@push('cssfiles')
<style>
#editor {
    height: calc(100% - 110px)!important;
}
</style>
@endpush

@section('title')
{{ __('Create a new note') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <div class="col-12 col-md-6 bg-info">
            <div class="row">
                <div class="col-12">
                    <div class="row mt-2">
                        <div class="col-11">
                            <input type="text" name="name" class="form-control border-0 text-black-50" id="editName" />
                        </div>
                        <div class="col-1">
                            <button name="submit" class="form-control btn btn-secondary btn-sm" title="{{ __('Save this note')}} "><i class="far fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <textarea class="rounded border-0 w-100 p-3 text-black-50" spellcheck="false" id="editor" rows="10"></textarea>
            <hr class="my-2" />
            <div class="small row text-black-25">
                <div class="col-12 col-md-6">
                    {{__('Characters')}}: <span id="currentChars">0</span>
                    <span id="lastSaved"></span>
                </div>
                <div class="d-none d-md-block col-md-6 text-right">
                    {{__('Made with')}} <i class="fas fa-heart"></i> - {{__('Powered by')}} <i class="fab fa-laravel"></i> & <i class="fab fa-linux"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3 small">
            <div class="row">
                <div class="col-6">
                <select name="selectedContent" class="custom-select custom-select-sm">
                    <option value="_new_">{{ __('Create a new note')}}</option>
                    @foreach($contents as $content)
                    <option value="{{ $content->slug }}">{{ $content->name }}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-6 text-right">
                    <div class="dropdown">
                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                            <span class="d-none d-md-inline-block">{{ __('Logged In as') }}: {{ Auth::user()->name }}</span> <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?&s=40" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item small" href="#">{{ __('Profile') }}</a>
                            <a class="dropdown-item small" id="logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1" />
            <div class="row">
                <div class="col-12" id="preview"></div>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
@endsection