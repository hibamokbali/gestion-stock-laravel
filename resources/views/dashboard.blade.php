@extends('layouts.app-stock')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <h2>Bienvenue, {{ auth()->user()->name }} !</h2>
    <p style="color: #64748b; margin-top: 10px;">Vous êtes connecté !</p>

    @if(auth()->user()->isAdmin())
    <div style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Aller au Dashboard Admin</a>
    </div>
    @else
    <div style="margin-top: 20px;">
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Aller à mon Dashboard</a>
    </div>
    @endif
</div>
@endsection