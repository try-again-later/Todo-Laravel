<x-layout title="Регистрация">
    <x-header />

    <h2 class="text-center mt-4">Регистрация</h2>

    <form class="container-sm py-8 col-lg-4" action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name-input" class="form-label">Имя</label>
            <input type="text" id="name-input" class="form-control" name="name" required value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email-input" class="form-label">Почта</label>
            <input type="email" id="email-input" class="form-control" name="email" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-input" class="form-label">Пароль</label>
            <input type="password" id="password-input" class="form-control" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirmation" class="form-label">Введите пароль ещё раз</label>
            <input type="password" id="password-confirmation" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
</x-layout>
