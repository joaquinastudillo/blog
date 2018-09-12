<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" >
        <script> window.Laravel = { csrfToken: '{{ csrf_token() }}' } </script>
        <title>Blog</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css">
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

    </head>
    <body>
        <div id="app">

        <Navbar></Navbar/>

        <div class="container">

        

        <blog-articles></blog-articles>
  

        </div>

        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
