<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">

    {{--<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav visible-xs">
                        @if( Auth::check() )
                            @if( Auth::user()->tipo_usuario_id  == 1 )
                                <li><a href="{{route('platos.index')}}">Platos</a></li>
                                <li><a href="{{route('personal.index')}}">Personal</a></li>
                                <li><a href="{{route('disponibilidad')}}">Disponibilidad</a></li>
                                <li><a href="{{route('mesas.index')}}">Mesas</a></li>
                            @elseif( Auth::user()->tipo_usuario_id  == 2 )
                                <li><a href="{{route('pedidos.index')}}">Pedidos</a></li>
                                <li><a href="{{route('pedidos.digest')}}">Pedidos listados</a></li>
                                <li><a href="{{route('disponibilidad')}}">Disponibilidad de platos</a></li>
                            @elseif( Auth::user()->tipo_usuario_id  == 3 )
                                <li><a href="{{route('mesas.index')}}">Mesas</a></li>
                                <li><a href="{{route('mesas.index')}}">Pedidos listos</a></li>
                            @endif
                                <hr>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Salír
                                    </a>
                                </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Ingresar</a></li>
                            {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                        @else

                            <li class="dropdown hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if( Auth::check() )
                                        @if( Auth::user()->tipo_usuario_id  == 1 )
                                            <li><a href="{{route('platos.index')}}">Platos</a></li>
                                            <li><a href="{{route('personal.index')}}">Personal</a></li>
                                            <li><a href="{{route('disponibilidad')}}">Disponibilidad</a></li>
                                            <li><a href="{{route('mesas.index')}}">Mesas</a></li>
                                        @elseif( Auth::user()->tipo_usuario_id  == 2 )
                                            <li><a href="{{route('pedidos.index')}}">Pedidos</a></li>
                                            <li><a href="{{route('pedidos.digest')}}">Pedidos listados</a></li>
                                            <li><a href="{{route('disponibilidad')}}">Disponibilidad de platos</a></li>
                                        @elseif( Auth::user()->tipo_usuario_id  == 3 )
                                            <li><a href="{{route('mesas.index')}}">Mesas</a></li>
                                            <li><a href="{{route('mesas.index')}}">Pedidos listos</a></li>
                                        @endif
                                            <hr>
                                            <li>
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Salír
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            @include('flash::message')
            @include('layouts.errorMessage')
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('extra-scripts')
</body>
</html>
