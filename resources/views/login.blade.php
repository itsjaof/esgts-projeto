@extends('layouts.app', ['Sidebar' => true])

@section('title','PointSystem - Login')

@section('content')
    <div class="container">
        <h3>
            <i class="fas fa-clock"></i>
            PointSystem
        </h3>
        <p>Faça login para aceder à plataforma.</p>

        <form action="/dashboard.html" method="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="form-email" placeholder="nome@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="form-password" placeholder="••••••••" required>
            </div>

            <button type="submit">Login</button>
            <button type="button" class="google-btn">
                <span class="google-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.66 0 6.51 5.38 2.57 13.22l7.98 6.19C12.39 13.41 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.5 24c0-1.59-.15-3.13-.43-4.63H24v9.13h12.71c-.55 2.97-2.17 5.49-4.63 7.16l7.23 5.62C43.57 37.23 46.5 31.06 46.5 24z"/>
                        <path fill="#FBBC05" d="M10.55 28.78c-.48-1.43-.75-2.96-.75-4.53s.27-3.1.75-4.53l-7.98-6.19C.92 16.53 0 20.17 0 24s.92 7.47 2.57 10.47l7.98-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.47 0 11.9-2.38 15.98-6.85l-7.23-5.62c-2.06 1.4-4.71 2.22-7.75 2.22-6.26 0-11.61-3.91-13.45-9.41l-7.98 6.19C6.51 42.62 14.66 48 24 48z"/>
                    </svg>
                </span>
                Entrar com o Google
            </button>
        </form>
    </div>
@endsection
