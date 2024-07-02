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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
 
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
            body{
              background-color: #333333;
              margin : 0;
              padding: 0;
              box-sizing: border-box;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
              <a class="navbar-brand" href="#" id="Logo">LOGO</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="{{-- navbarText --}}">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ Route('dashboard') }}">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('projects.list') }}">Projetos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('tasks.list')}}">Tarefas</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('users.list')}}">users</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('teams.list')}}">Teams</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('trainings.list')}}">Formação</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ Route('formers.list')}}">Formação</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Cronogramas</a>
                  </li>
                </ul>
{{--                 <span class="navbar-text">
                    <button class="btn btn-primary">Login</button>
                </span> --}}
              </div>
            </div>
        </nav>
 
        <main>
          @yield('content')
        </main>
       
    </body>
</html>