@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">

        {{-- show success message --}}
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">{{ __('Success:') }}</h4>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif

        {{-- show error message --}}
        @if (count($errors) > 0)
            <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">{{ __('Error:') }}</h4>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ __($error) }}</li>
                @endforeach
            </ul>
            </div>
        @endif

        <div class="row align-items-center justify-content-between mb-md-3">
            <div class="col-md-auto col-12 text-md-left text-center">
                <h1 class="mb-0">Users</h1>
            </div>
            <div class="col-md-auto col-12">
                <a class="btn btn-success btn-lg" href="{{ route('users.create') }}" title="Add New User">
                    <i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="row align-items-center justify-content-between mb-md-3">
            <div class="col-md-auto col-12">
                {!! Form::open(array('route' => 'users.index', 'method' => 'get')) !!}
                    <div class="row align-items-center justify-content-end">
                        <div class="col">
                            <div class="form-group row mb-0 align-items-center justify-content-end">
                                {!! Form::label('order', __('Sort by:'), array('class' => 'col-md-auto col-form-label text-md-right')) !!}
                                <div class="col-md-auto">
                                    {!! Form::select('order_field', [
                                        'id' => 'ID',
                                        'name' => 'Name',
                                        'email' => 'Email',
                                        'gender' => 'Gender'
                                        ], $data['order_field'], ['class' => 'custom-select custom-select-lg', 'id' => 'order']) !!}
                                </div>
                                <div class="col-md-auto">
                                    {!! Form::select('order_direction', [
                                        'asc' => 'Ascending',
                                        'desc' => 'Descending',
                                        ], $data['order_direction'], ['class' => 'custom-select custom-select-lg', 'id' => 'order-direction']) !!}
                                </div>
                                <div class="col-md-auto">
                                    {!! Form::button('Sort', ['class' => 'btn btn-secondary btn-lg', 'type' => 'submit', 'title' => 'Sort']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-auto col-12">
                {!! Form::open(array('route' => 'users.index', 'method' => 'get')) !!}
                    <div class="row align-items-center justify-content-end">
                        <div class="col">
                            <div class="input-group mb-0">
                                {!! Form::text('s', $data['s'], [
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => 'Search...',
                                    'aria-label' => 'Search...',
                                    'aria-describedby' => 'button-addon2',
                                    ]) !!}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i>', [
                                        'class' => 'btn btn-secondary btn-lg',
                                        'id' => 'button-addon2',
                                        'type' => 'submit',
                                        'title' => 'Search',
                                        ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if (count($data['users']) > 0)
        <div class="table-responsive-md">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle" scope="col">{{ __('ID') }}</th>
                        <th class="align-middle" scope="col">{{ __('Name') }}</th>
                        <th class="align-middle" scope="col">{{ __('Email') }}</th>
                        <th class="align-middle" scope="col">{{ __('Gender') }}</th>
                        <th class="align-middle" scope="col">{{ __('Description') }}</th>
                        <th class="align-middle" scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data['users'] as $storedUser)
                        <tr>
                            <td class="align-middle" scope="row">{{ $storedUser->id }}</td>
                            <td class="align-middle">{{ $storedUser->name }}</td>
                            <td class="align-middle">{{ $storedUser->email }}</td>
                            <td class="align-middle">{{ ucfirst($storedUser->gender) }}</td>
                            <td class="align-middle">{{ $storedUser->description }}</td>
                            <td class="align-middle">
                                <div class="row">
                                    <div class="col-sm-auto">
                                        <a href="{{ route('users.edit', ['users' => $storedUser->id]) }}" class="btn btn-primary btn-sm my-lg-0 my-3" title="Edit">
                                            <i class="fas fa-pencil-alt"></i></a>
                                    </div>

                                    {{-- @if ($storedUser->id != Auth::user()->id) --}}
                                    <div class="col-sm-auto">
                                        {!! Form::open(array('route' => ['users.destroy', $storedUser->id], 'method' => 'delete')) !!}
                                            {!! Form::button('<i class="fas fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm my-lg-0 my-3', 'title' => 'Delete')) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    {{-- @endif --}}

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>{{ __('No Results Found!') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
