@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success fade show" id="success-message" data-bs-dismiss="alert" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="alert alert-success mt-3" role="alert">
        ¡Bienvenido al Sitio Web!
    </div>
@endsection
