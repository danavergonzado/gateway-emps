@extends('layouts.app')
@section('style')
    <style>
       label:not(.form-check-label):not(.custom-file-label) {font-weight: normal;}
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Password') }}</div>

                <div class="card-body">
                    <form method="POST" id="FrmUpdatePassword">
                        @csrf
                        <div class="form-group row">
                            <label for="current password" class="col-md-4 text-md-right">Current Password</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" value="" required autofocus>

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new_password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" id="BtnUpdatePassword">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>
    $('document').ready(function(){
        $('#BtnUpdatePassword').click(function(e){
            e.preventDefault();
            $.post("{{ url('/updatepassword') }}", $('#FrmUpdatePassword').serialize())
                .done(function(e){
                    if(e==1){
                        alert('Success: Password update. Please login with your new password.');
                        window.location = "{{ url('/end_session') }}";
                    }else{
                        alert(e);
                    }
                })
                .fail(function(xhr, textStatus, errorThrown){
                    alert(xhr.responseText);
                });
        });
    });
</script>       
@endsection