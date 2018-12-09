<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/font-awesome.js') }}" defer></script>
    <script src="{{ mix('js/scripts.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                        <li class="nav-item">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                                {{ __('Add User') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalCenterTitle">{{ __('Add User') }}</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    {!! Form::open(array('route' => 'users.store', 'method' => 'post', 'files' => true)) !!}
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                {!! Form::label('name', __('Name'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('email', __('E-Mail Address'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('password', __('Password'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('password-confirm', __('Confirm Password'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    {!! Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password-confirm', 'required' => 'required')) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                {!! Form::label(null, __('Gender'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        {!! Form::radio('gender', 'male', false, array('class' => 'form-check-input', 'id' => 'gender-male')) !!}
                                                        {!! Form::label('gender-male', __('Male'), array('class' => 'form-check-label')) !!}
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        {!! Form::radio('gender', 'female', false, array('class' => 'form-check-input', 'id' => 'gender-female')) !!}
                                                        {!! Form::label('gender-female', __('Female'), array('class' => 'form-check-label')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('description', __('Description'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'rows' => 4)) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('photo', __('Upload Image'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <div class="custom-file">
                                                        {!! Form::file('photo', array('class' => 'custom-file-input', 'id' => 'photo', 'type' => 'file')) !!}
                                                        {!! Form::label('photo', __('Choose file...'), array('class' => 'custom-file-label text-nowrap')) !!}
                                                    </div>
                                                    <img src="..." alt="..." class="img-thumbnail img-fluid">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('attachment', __('Attach File'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                                                <div class="col-md-6">
                                                    <div class="custom-file">
                                                        {!! Form::file('attachment', array('class' => 'custom-file-input', 'id' => 'attachment', 'type' => 'file')) !!}
                                                        {!! Form::label('file', __('Choose file...'), array('class' => 'custom-file-label text-nowrap')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                </div>
                            </div>
                        </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
