@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: #f4f4f4;">
    <div style="background: white; padding: 2rem; border-radius: 12px; width: 100%; max-width: 400px;">
        <h2 style="margin-bottom: 1.5rem;">Login Staff</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #ddd; border-radius:6px;">
            <input type="password" name="password" placeholder="Password" style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #ddd; border-radius:6px;">
            <button type="submit" style="background:#1A1A1A; color:white; padding:12px; width:100%; border:none; border-radius:6px;">Login</button>
        </form>
        @if($errors->any())
            <p style="color:red; margin-top:1rem;">{{ $errors->first() }}</p>
        @endif
        <p style="margin-top:1rem; text-align:center;"><a href="{{ route('home') }}">Kembali ke Beranda</a></p>
    </div>
</div>
@endsection