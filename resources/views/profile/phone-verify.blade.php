@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Active Phone Number
                    </div>

                    <div class="card-body">
                        <form action="{{ route('profile.2fa.phone') }}" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="token" class="col-form-label">Token</label>
                                <input type="text" id="token" class="form-control @error('token') is-invalid @enderror" name="token" placeholder="enter your token" autocomplete="off">
                                @error('token')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Validate token</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
