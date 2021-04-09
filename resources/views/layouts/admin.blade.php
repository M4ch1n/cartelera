@extends('layouts.app')

@section('body')
    <div class="wrapper" id="wrapper">
        <nav id="sidebar">
            <ul class="list-unstyled components">                
                <li class="@if(Route::is('home')) active @endif">
                    <a href="home">Dashboard</a>                    
                </li>
                <li class="@if(Route::is('peliculas')) active @endif">
                    <a href="peliculas">Peliculas</a>
                </li>
                <li class="@if(Route::is('turnos')) active @endif">
                    <a href="turnos">Turnos</a>
                </li>
            </ul>
        </nav>
        
        
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </nav>
            </div>
        </div>
    
    </div>
@endsection


