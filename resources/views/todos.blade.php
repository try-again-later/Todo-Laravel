<x-layout :scripts="['resources/js/todos.js']">
    <x-header />

    <form id="todo-submit-form" class="col-lg-6 mx-auto mt-4" action="{{ route('todos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <textarea class="form-control" name="content" style="resize: none;" required></textarea>
        </div>

        <div class="input-group mt-2">
            <label class="input-group-text" for="image-input">Загрузка картинки</label>
            <input type="file" class="form-control" id="image-input" name="image">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Создать</button>
    </form>

    <div class="col-lg-6 mx-auto mt-4" id="todos-container"></div>

    <template id="todo-template">
        <article class="d-flex mt-4 p-2 border rounded">
            <div class="me-2">
                <input type="checkbox" name="done" style="width: 2rem; height: 2rem;">
            </div>
            <p data-content class="me-auto"></p>
            <div class="">
                <a href="#" data-image-link class="d-block">
                    <img data-image src="" alt="Todo image" style="display: none;">
                </a>
                <button type="button" class="btn btn-link link-danger d-block mx-auto mt-2 d-none" data-delete-image-button>Удалить картинку</button>
            </div>
            <div class="ms-2">
                <button data-todo-delete-button class="d-block btn btn-danger">Удалить</button>
                <button data-todo-edit-button class="d-block mt-2 btn btn-secondary" data-bs-toggle="modal" data-bs-target="#todo-edit-modal">Изменить</button>
            </div>
        </article>
    </template>

    <div class="modal fade" tabindex="-1" id="todo-edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <textarea class="form-control" name="content" style="resize: none;" required></textarea>
                        <div class="input-group mt-2">
                            <label class="input-group-text" for="image-input">Замена картинки</label>
                            <input type="file" class="form-control" id="image-input" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary" data-todo-save-changes>Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
