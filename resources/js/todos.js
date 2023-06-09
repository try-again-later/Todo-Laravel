import './bootstrap';
import '../css/app.scss';
import axios from "axios";

import * as bootstrap from 'bootstrap';

const todoSubmitForm = document.getElementById('todo-submit-form');
todoSubmitForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('content', event.currentTarget.content.value);

    if (event.currentTarget.image.files.length === 1) {
        formData.append('image', event.currentTarget.image.files[0]);
    }

    await axios.post('/todos', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });

    await downloadAllTodos();
    await refreshTodos();
});

const todoTemplate = document.getElementById('todo-template');
const tagTemplate = document.getElementById('tag-template');
const todosContainer = document.getElementById('todos-container');

let todosMap = new Map();
let todos = [];
let tags = [];
let editedTodo = null;

async function downloadAllTodos() {
    todos = (await axios.get('/todos/all')).data;
}

async function downloadTags() {
    tags = (await axios.get('/tags')).data;
}

const todoEditModal = document.getElementById('todo-edit-modal');
todoEditModal.addEventListener('shown.bs.modal', function () {
    if (editedTodo === null) {
        return;
    }

    const fileInput = this.querySelector('input[type=file]');
    fileInput.value = null;

    const textarea = this.querySelector('textarea');
    textarea.value = editedTodo.content;

    const closeButton = this.querySelector('[data-bs-dismiss=modal]');

    this.querySelector('form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData();
        formData.append('_method', 'PATCH');

        formData.append('content', event.currentTarget.content.value);

        if (event.currentTarget.image.files.length === 1) {
            formData.append('image', event.currentTarget.image.files[0]);
        }

        await axios.post(`/todos/${editedTodo.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        closeButton.click();
        await downloadAllTodos();
        await refreshTodos();
    });
});

async function refreshTodos() {
    let activeTags = [];
    document.querySelectorAll('#global-tags-list .badge').forEach((badge) => {
        const name = badge.querySelector('[data-tag-name]').textContent;
        if (badge.querySelector('input[type=checkbox]').checked) {
            activeTags.push(name);
        }
    });

    todosContainer.textContent = '';

    todosIteration:
    for (const todo of todos) {
        for (const tag of todo.tags) {
            if (!activeTags.includes(tag.name)) {
                continue todosIteration;
            }
        }

        todosMap.set(todo.id, todo);

        const todoElement = todoTemplate.content.cloneNode(true);

        const checkbox = todoElement.querySelector('[name=done]');
        if (todo.done) {
            checkbox.checked = true;
        }
        checkbox.addEventListener('click', async function (event) {
            event.preventDefault();
            try {
                this.disabled = true;
                const response = await axios.patch(`/todos/${todo.id}`, {done: this.checked});
                this.checked = response.data.done;
            } finally {
                this.disabled = false;
            }
        });

        const imageDeleteButton = todoElement.querySelector('[data-delete-image-button]');
        if (todo.has_image) {
            imageDeleteButton.classList.remove('d-none');
        }
        imageDeleteButton.addEventListener('click', async function () {
            try {
                this.disabled = true;
                await axios.patch(`/todos/${todo.id}`, {image: null});
                await downloadAllTodos();
                await refreshTodos();
            } finally {
                this.disabled = false;
            }
        });

        const content = todoElement.querySelector('[data-content]');
        content.textContent = todo.content;

        if (todo.has_image) {
            const image = todoElement.querySelector('[data-image]');
            image.style.display = 'inline-block';
            image.src = `/thumbnails/${todo.id}?t=${new Date().getTime()}`;

            const imageLink = todoElement.querySelector('[data-image-link]');
            imageLink.href = `/images/${todo.id}`;
        }

        const deleteButton = todoElement.querySelector('[data-todo-delete-button]');
        deleteButton.addEventListener('click', async function () {
            await axios.delete(`/todos/${todo.id}`);
            await downloadAllTodos();
            await refreshTodos();
        });

        const editButton = todoElement.querySelector('[data-todo-edit-button]');
        editButton.addEventListener('click', function () {
            editedTodo = todosMap.get(todo.id);
        });

        todoElement.querySelector('[data-add-tag-form]').addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('name', event.currentTarget.name.value);

            await axios.post(`/todos/${todo.id}/tags`, formData);
            await downloadTags();
            refreshGlobalTagsList();
            await downloadAllTodos();
            await refreshTodos();
        });

        const tagsListElement = todoElement.querySelector('[data-tags-list]');
        for (const tag of todo.tags) {
            const tagElement = tagTemplate.content.cloneNode(true);
            tagElement.querySelector('[data-tag-name]').textContent = tag.name;

            tagElement.querySelector('form').addEventListener('submit', async function (event) {
                event.preventDefault();

                await axios.delete(`/todos/${todo.id}/tags`, {data: {name: tag.name}});
                await downloadAllTodos();
                await refreshTodos();
            });

            tagsListElement.appendChild(tagElement)
            tagsListElement.appendChild(document.createTextNode(' '));
        }

        todosContainer.appendChild(todoElement);
    }
}

const todoSearchForm = document.getElementById('search-form');

todoSearchForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    todos = (await axios.get('/todos/all', {params: {search: event.currentTarget.search.value}})).data;
    await refreshTodos();
});

todoSearchForm.querySelector('[data-show-all-todos]').addEventListener('click', async function () {
    todoSearchForm.querySelector('input[type=text]').value = '';
    await downloadAllTodos();
    await refreshTodos();
});

const globalTagsList = document.getElementById('global-tags-list');

function refreshGlobalTagsList() {
    globalTagsList.textContent = '';

    for (const tag of tags) {
        const tagElement = tagTemplate.content.cloneNode(true);

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = true;
        checkbox.style.width = '1.5rem';
        checkbox.style.height = '1.5rem';

        checkbox.addEventListener('change', async function () {
            await refreshTodos();
        });

        tagElement.querySelector('.badge').appendChild(checkbox);

        tagElement.querySelector('[data-tag-name]').textContent = tag.name;

        tagElement.querySelector('form').addEventListener('submit', async function (event) {
            event.preventDefault();

            await axios.delete('/tags', {data: {name: tag.name}});
            await downloadTags();
            refreshGlobalTagsList();
            await downloadAllTodos();
            await refreshTodos();
        });

        globalTagsList.appendChild(tagElement)
        globalTagsList.appendChild(document.createTextNode(' '));
    }
}

(async () => {
    await downloadTags();
    refreshGlobalTagsList();
    await downloadAllTodos();
    await refreshTodos();
})();
