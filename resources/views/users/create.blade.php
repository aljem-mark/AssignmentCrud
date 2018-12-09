@extends('layouts.app')

@section('content')
<div class="container">

    {{-- show error message --}}
    @if (count($errors) > 0)
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">{{ __('Error:') }}</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ __($error) }}</li>
                    @endforeach
                </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-right">
            <a class="btn btn-primary btn-lg" href="{{ route('users.index') }}" title="Return to Users List">
                <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New User') }}</div>

                <div class="card-body">
                    {!! Form::open(array('route' => 'users.store', 'method' => 'post', 'files' => true)) !!}
                        @include('users.form')

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add User') }}
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
