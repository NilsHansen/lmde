<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style type="text/css">
    #editor {
        background-color: rgba(255,255,255,0.1);
        margin-top: 15px;
        height: calc(100% - 30px);
        font-size: 12px;
        resize: none;
    }

    #editor:focus {
        outline: none;
    }

    </style>    

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-md-6 bg-info">
                <textarea class="rounded border-0 w-100 p-3" id="editor" rows="10"></textarea>
            </div>
            <div class="col-12 col-md-6">

            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#editor').focus();
        });
    </script>
  </body>
</html>