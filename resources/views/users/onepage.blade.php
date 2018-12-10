@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-8 col-offset-4">

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

            {!! Form::open(array('route' => 'users.onepage', 'method' => 'get')) !!}
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
            <div class="col-lg-8">
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
                                        <div class="userlist-thumb" data-val="{{ $storedUser->photo }}" data-img-src="{{ asset('storage/upload/' . $storedUser->photo) }}">
                                            <img src="{{ isset($storedUser->photo) ? asset('storage/upload/' . $storedUser->photo) : '...' }}" alt="..." class="img-thumbnail img-fluid">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="text" data-pk="{{ $storedUser->id }}" data-name="name" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Name">{{ $storedUser->name }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="email" data-pk="{{ $storedUser->id }}" data-name="email" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Email">{{ $storedUser->email }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable gender" href="//" data-type="select" data-value="{{ $storedUser->gender }}" data-pk="{{ $storedUser->id }}" data-name="gender" data-url="{{ route('users.updatefield') }}" data-original-title="Select Gender">{{ ucfirst($storedUser->gender) }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="apply-xeditable" href="//" data-type="textarea" data-pk="{{ $storedUser->id }}" data-name="description" data-url="{{ route('users.updatefield') }}" data-original-title="Enter Description">{{ $storedUser->description }}</a>
                                    </td>
                                    <td class="align-middle"><span class="userlist-attachment">{{ $storedUser->attachment }}</span></td>
                                    <td class="align-middle">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="//" class="btn btn-secondary btn-sm my-3 toggle-editable" title="Quick Edit">
                                                    <i class="fas fa-edit"></i></a>
                                            </div>

                                            <div class="col-auto">
                                            <a href="//" class="btn btn-primary btn-sm my-3 onepage-edit" title="Edit" data-url="{{ route('users.update', ['users' => $storedUser->id]) }}">
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
            <div class="col-lg-4 mt-5">
                {!! Form::open(array('route' => 'users.store', 'files' => true, 'id' => 'onepage-form')) !!}
                    {!! Form::hidden('_method', 'POST', array('id' => 'onepage-form-method')) !!}
                    {!! Form::hidden('old_email', null, array('id' => 'onepage-form-old-email')) !!}
                    <div class="form-group row">
                        {!! Form::label('onepage-form-name', __('Name'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <input id="onepage-form-name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-email', __('E-Mail Address'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <input id="onepage-form-email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-password', __('Password'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <input id="onepage-form-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-password-confirm', __('Confirm Password'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            {!! Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'onepage-form-password-confirm', 'required' => 'required')) !!}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        {!! Form::label('gender', __('Gender'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                {!! Form::radio('gender', 'male', false, array('class' => 'form-check-input', 'id' => 'onepage-form-gender-male')) !!}
                                {!! Form::label('onepage-form-gender-male', __('Male'), array('class' => 'form-check-label')) !!}
                            </div>
                            <div class="form-check form-check-inline">
                                {!! Form::radio('gender', 'female', false, array('class' => 'form-check-input', 'id' => 'onepage-form-gender-female')) !!}
                                {!! Form::label('onepage-form-gender-female', __('Female'), array('class' => 'form-check-label')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-description', __('Description'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'onepage-form-description', 'rows' => 4)) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-photo', __('Upload Image'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <div class="custom-file">
                                {!! Form::file('photo', array('class' => 'custom-file-input', 'id' => 'onepage-form-photo', 'type' => 'file')) !!}
                                {!! Form::label('onepage-form-photo', __('Choose file...'), array('class' => 'custom-file-label text-nowrap', 'id' => 'onepage-form-photo-label2')) !!}
                            </div>
                            <img id="onepage-form-img-thumbnail" src="..." alt="..." class="img-thumbnail img-fluid">
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('onepage-form-attachment', __('Attach File'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

                        <div class="col-md-6">
                            <div class="custom-file">
                                {!! Form::file('attachment', array('class' => 'custom-file-input', 'id' => 'onepage-form-attachment', 'type' => 'file')) !!}
                                {!! Form::label('onepage-form-attachment', __('Choose file...'), array('class' => 'custom-file-label text-nowrap', 'id' => 'onepage-form-attachment-label2')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" id="onepage-form-submit">
                                {{ __('Submit') }}
                            </button>
                            <button type="button" class="btn btn-danger" id="onepage-form-cancel" data-url="{{ route('users.store') }}">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        @endif
    </div>
</div>
@endsection
