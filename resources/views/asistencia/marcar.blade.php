@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success fade show" id="success-message" data-bs-dismiss="alert" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">

                <h1 class="text-center">Marcar Asistencia</h1>

                <form action="{{ route('asistencias.marcar') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="password" class="form-label">CONTRASEÑA</label>
                            <input type="password" class="form-control" id="pin" name="pin" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success">Marcar</button>
                            @if (auth()->check())
                                <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">Volver</a>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            @error('InvalidCredentials')
                                <div class="alert alert-success fade show" id="success-message" data-bs-dismiss="alert"
                                    role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection