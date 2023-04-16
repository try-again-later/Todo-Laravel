<x-layout>
    <x-header />

    <form id="todo-submit-form" class="col-lg-6 mx-auto mt-4" action="{{ route('todos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <textarea class="form-control" name="content" style="resize: none;" required></textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mt-2">
            <label class="input-group-text" for="image-input">Загрузка картинки</label>
            <input type="file" class="form-control" id="image-input" name="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2 float-end">Создать</button>
    </form>

    <div class="col-lg-6 mx-auto mt-4">
    </div>
</x-layout>
