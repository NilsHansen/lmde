@extends('layout')

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    @isset($editor)
    var saveAble = 0;
    var saveContentToDB = function() {
        if(saveAble == 1) {
            $.ajax({
                url: '{{ route('editor.update', $editor) }}',
                type: 'PUT',
                data: { content: $('#editor').val() }
            }).done(function() {
                saveAble = 0;
                $('#editTime').text(moment());
            });
        }
    }
    $(document).on('unload', function() {
        saveAble = 1;
        saveContentToDB();
    });
    @endisset

    $(document).ready(function() {
        $('#editor')
            .keyup(function() {
                $('#currentChars').text($(this).val().length);
                $('#preview').html(marked($(this).val()));
                saveAble = 1;
        });

        $('select[name=selectedContent]').change(function() {
            var value = $(this).val();
            if(value != '_new_')
                document.location.href = '/editor/'+$(this).val();
            else
                document.location.href = '{{ route('editor.index') }}';
        });

        @if(isset($editor))
            var cnt = $('#editor').val(); 
            $('#editor').focus().val('').val(cnt).trigger('keyup');

            setInterval(function() {
                saveContentToDB();
            }, 10000);

            $('#external').change(function() {
                var checked = ($(this).is(':checked') ? 1 : 0);
                console.log(checked);
                $.ajax({
                    url: '{{ route('editor.update', $editor) }}',
                    type: 'PUT',
                    data: { external: checked }
                });
            });
            var updateLastEdited = function() {
                $("#lastSaved").text(moment($('#editTime').text()).fromNow());
            }
            updateLastEdited();

            setInterval(function() {
                updateLastEdited();
            }, 1000);
        @else
            $('#editName').focus();
        @endif
    });
</script>
@endpush

@if(!isset($editor))
@push('cssfiles')
<style>
#editor {
    height: calc(100% - 110px)!important;
}
</style>
@endpush
@endif

@section('title')
@if(!isset($editor))
{{ __('Create a new note') }}
@else
{{ $editor->name }}
@endif
@endsection

@section('content')
@isset($editor)<div class="d-none" id="editTime">{{ $editor->updated_at }}</div>@endisset
<div class="container-fluid">
    <div class="row min-vh-100">
        <div class="col-12 col-md-6 bg-info">
            @if(!isset($editor))<form method="POST" action="{{ route('editor.store') }}" class="h-100">
            @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row mt-2">
                            <div class="col-11">
                                <input type="text" name="name" class="form-control border-0 text-black-50" id="editName" />
                            </div>
                            <div class="col-1">
                                <button name="submit" class="form-control btn btn-secondary btn-sm" title="{{ __('Save this note')}}"><i class="far fa-save"></i></button>
                            </div>
                        </div>
                    </div>
                </div> @endif
                <textarea class="rounded border-0 w-100 p-3 text-black-50 overflow-hidden" name="content" spellcheck="false" id="editor" rows="10">{{ $editor->content ?? ''}}</textarea>
                <hr class="my-2" />
                <div class="small row text-black-25">
                    <div class="col-12 col-md-6">
                        {{__('Characters')}}: <span id="currentChars">0</span>
                        |<i class="fas fa-download mx-1"></i><span id="lastSaved"></span>
                    </div>
                    <div class="d-none d-md-block col-md-6 text-right">
                        {{__('Made with')}} <i class="fas fa-heart"></i> - {{__('Powered by')}} <i class="fab fa-laravel"></i> & <i class="fab fa-linux"></i>
                    </div>
                </div>
            @if(!isset($editor))</form>@endif
        </div>
        <div class="col-12 col-md-6 mt-3 small">
            <div class="row">
                <div class="col-6">
                <select name="selectedContent" class="custom-select custom-select-sm @isset($editor)w-75 @endisset">
                    <option value="_new_">{{ __('Create a new note')}}</option>
                    @foreach($contents as $content)
                    <option value="{{ $content->slug }}" @if(isset($editor) && $content->id == $editor->id)selected @endif>{{ $content->name }}</option>
                    @endforeach
                </select>
                @isset($editor)
                    <a href="#" class="btn btn-secondary btn-sm ml-4" title="{{ __('Delete this note')}}" onclick="event.preventDefault();if(confirm('{{ __('Do you really want to delete this note?') }}')) document.getElementById('delete-form').submit();"><i class="fas fa-trash-alt"></i></a>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="external" name="external"@if(isset($editor) && $editor->external == 1) checked @endif>
                        <label class="custom-control-label pt-1" for="external">{{ __('Make this note external') }}</label>
                    </div>
                @endisset
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
@isset($editor)
<form id="delete-form" action="{{ route('editor.destroy', $editor) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
@endisset
@endsection