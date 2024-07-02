<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>SGP</title>
 
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
        <style>
            *{
                margin: 0;
                padding: 0;
            }
 
            .navbar{
                background-color: #1C1C1C;
            }
 
            .nav-link{
                color: white !important;
            }
 
            #Logo{
               font-weight: 700;
               color: white
            }
 
            .navbar ul{
                width: 100%;
                text-align: center
            }
 
            #loginContent{
                margin-top: 200px;
            }
 
        </style>
    </head>
    <body>
      <main>
        @yield('content')
      </main>
    </body>
</html>