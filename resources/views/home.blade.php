<x-layout title="Домашняя">
    <x-header />

    <div class="p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-5 fw-normal mb-4">Список дел</h1>

            @guest
                <a class="btn btn-outline-secondary" href="{{ route('register') }}">Зарегистрироваться</a>
            @else
                <a class="btn btn-outline-secondary" href="{{ route('todos') }}">Перейти к списку дел</a>
            @endguest
        </div>
    </div>
</x-layout>
