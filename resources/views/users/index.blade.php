@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

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

            <div class="row align-items-center justify-content-lg-start justify-content-center mb-md-3">
                <div class="col-auto">
                    <h1 class="mb-0">Users</h1>
                </div>
                {{-- <div class="col-auto text-right">
                    <a class="btn btn-success btn-lg" href="{{ route('users.create') }}" title="Add New User">
                        <i class="fa fa-plus" aria-hidden="true"></i></a>
                </div> --}}
            </div>

            {!! Form::open(array('route' => 'users.index', 'method' => 'get')) !!}
                <div class="row align-items-center justify-content-between mb-3">
                    <div class="col-lg-auto col-12 mb-lg-0 mb-3">
                        <div class="row align-items-center justify-content-end">
                            <div class="col">
                                <div class="form-group row mb-0 align-items-center justify-content-end">
                                    {!! Form::label('order', __('Sort by:'), array('class' => 'col-md-auto col-form-label text-md-right')) !!}
                                    <div class="col-md-auto mb-sm-0 mb-3">
                                        {!! Form::select('order_field', [
                                            'id' => 'ID',
                                            'name' => 'Name',
                                            'email' => 'Email',
                                            'gender' => 'Gender'
                                            ], $data['order_field'], ['class' => 'custom-select custom-select-lg', 'id' => 'order']) !!}
                                    </div>
                                    <div class="col-md-auto mb-sm-0 mb-3">
                                        {!! Form::select('order_direction', [
                                            'asc' => 'Ascending',
                                            'desc' => 'Descending',
                                            ], $data['order_direction'], ['class' => 'custom-select custom-select-lg', 'id' => 'order-direction']) !!}
                                    </div>
                                    <div class="col-md-auto text-sm-left text-right">
                                        {!! Form::button('Sort', ['class' => 'btn btn-secondary btn-lg', 'type' => 'submit', 'title' => 'Sort']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto col-12">
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
                    </div>
                </div>
            {!! Form::close() !!}
        </div>

        @if (count($data['users']) > 0)
            <div class="col-12">
                <div class="table-responsive-lg">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle" scope="col">{{ __('ID') }}</th>
                                <th class="align-middle" scope="col">{{ __('Photo') }}</th>
                                <th class="align-middle" scope="col">{{ __('Name') }}</th>
                                <th class="align-middle" scope="col">{{ __('Email') }}</th>
                                <th class="align-middle" scope="col">{{ __('Gender') }}</th>
                                <th class="align-middle" scope="col">{{ __('Description') }}</th>
                                <th class="align-middle" scope="col">{{ __('Attachment') }}</th>
                                <th class="align-middle" scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data['users'] as $storedUser)
                                <tr>
                                    <td class="align-middle" scope="row">{{ $storedUser->id }}</td>
                                    <td class="align-middle">
                                        <div class="userlist-thumb">
                                            <img src="{{ isset($storedUser->photo) ? asset('storage/upload/' . $storedUser->photo) : '...' }}" alt="..." class="img-thumbnail img-fluid">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="text" data-pk="{{ $storedUser->id }}" data-name="name" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Name">
                                            {{ $storedUser->name }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="email" data-pk="{{ $storedUser->id }}" data-name="gender" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Email">
                                            {{ $storedUser->email }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable gender" href="//" data-type="select" data-value="{{ $storedUser->gender }}" data-pk="{{ $storedUser->id }}" data-name="gender" data-url="{{ route('users.updatefield') }}" data-original-title="Select Gender">
                                            {{ ucfirst($storedUser->gender) }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="textarea" data-pk="{{ $storedUser->id }}" data-name="gender" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Description">{{ $storedUser->description }}</a>
                                    </td>
                                    <td class="align-middle">{{ $storedUser->attachment }}</td>
                                    <td class="align-middle">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="//" class="btn btn-secondary btn-sm my-3 toggle-editable" title="Quick Edit">
                                                    <i class="fas fa-edit"></i></a>
                                            </div>

                                            <div class="col-auto">
                                                <a href="{{ route('users.edit', ['users' => $storedUser->id]) }}" class="btn btn-primary btn-sm my-3" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i></a>
                                            </div>

                                            {{-- @if ($storedUser->id != Auth::user()->id) --}}
                                            <div class="col-auto">
                                                {!! Form::open(array('route' => ['users.destroy', $storedUser->id], 'method' => 'delete')) !!}
                                                    {!! Form::button('<i class="fas fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm my-3', 'title' => 'Delete')) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            {{-- @endif --}}

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="align-middle" scope="row">{{ __('No Results Found!') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
