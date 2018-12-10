<div class="form-group row">
    {!! Form::label('name', __('Name'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

    <div class="col-md-6">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($storedUser->name) ? $storedUser->name : old('name') }}" required autofocus>

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
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($storedUser->email) ? $storedUser->email : old('email') }}" required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

@if (!isset($storedUser->id))
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
@endif

<div class="form-group row align-items-center">
    {!! Form::label(null, __('Gender'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

    <div class="col-md-6">
        <div class="form-check form-check-inline">
            {!! Form::radio('gender', 'male', (isset($storedUser->gender) && $storedUser->gender == 'male') ? true : false, array('class' => 'form-check-input', 'id' => 'gender-male')) !!}
            {!! Form::label('gender-male', __('Male'), array('class' => 'form-check-label')) !!}
        </div>
        <div class="form-check form-check-inline">
            {!! Form::radio('gender', 'female', (isset($storedUser->gender) && $storedUser->gender == 'female') ? true : false, array('class' => 'form-check-input', 'id' => 'gender-female')) !!}
            {!! Form::label('gender-female', __('Female'), array('class' => 'form-check-label')) !!}
        </div>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('description', __('Description'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

    <div class="col-md-6">
        {!! Form::textarea('description', (isset($storedUser->description) ? $storedUser->description : null), array('class' => 'form-control', 'id' => 'description', 'rows' => 4)) !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('photo', isset($storedUser->photo) ? __('Update Image') : __('Upload Image'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

    <div class="col-md-6">
        <div class="custom-file">
            {!! Form::file('photo', array('class' => 'custom-file-input', 'id' => 'photo', 'type' => 'file')) !!}
            {!! Form::label('photo', isset($storedUser->photo) ? $storedUser->photo : __('Choose file...'), array('class' => 'custom-file-label text-nowrap')) !!}
        </div>
        <img src="{{ isset($storedUser->photo) ? asset('storage/upload/' . $storedUser->photo) : '...' }}" alt="..." class="img-thumbnail img-fluid">
    </div>
</div>

<div class="form-group row">
    {!! Form::label('attachment', isset($storedUser->attachment) ? __('Update Attached File') : __('Attach File'), array('class' => 'col-md-4 col-form-label text-md-right')) !!}

    <div class="col-md-6">
        <div class="custom-file">
            {!! Form::file('attachment', array('class' => 'custom-file-input', 'id' => 'attachment', 'type' => 'file')) !!}
            {!! Form::label('attachment', isset($storedUser->attachment) ? $storedUser->attachment : __('Choose file...'), array('class' => 'custom-file-label text-nowrap')) !!}
        </div>
    </div>
</div>
