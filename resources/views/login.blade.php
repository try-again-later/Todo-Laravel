<x-layout title="Вход">
    <x-header />

    <h2 class="text-center mt-4">Вход</h2>

    <form class="container-sm py-8 col-lg-4" action="#" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email-input" class="form-label">Почта</label>
            <input type="email" id="email-input" class="form-control" name="email">
        </div>

        <div class="mb-3">
            <label for="password-input" class="form-label">Пароль</label>
            <input type="password" id="password-input" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</x-layout>
