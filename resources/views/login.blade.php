<x-layout title="Вход">
    <x-header />

    <h2 class="text-center mt-4">Вход</h2>

    <form class="container-sm py-8 col-lg-4" action="#" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email-input" class="form-label">Почта</label>
            <input type="email" id="email-input" class="form-control" name="email" value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-input" class="form-label">Пароль</label>
            <input type="password" id="password-input" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <input type="checkbox" id="remember-me-input" class="form-check-control" name="remember_me">
            <label for="remember-me-input" class="form-check-label">Запомнить меня</label>
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</x-layout>
