@extends('layout')

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#content').html(marked($('#fakeContent').html()));
    });
</script>
@endpush

@section('content')
<div id="fakeContent" class="d-none">{!! $content->content !!}</div>
<div id="content"></div>
@endsection