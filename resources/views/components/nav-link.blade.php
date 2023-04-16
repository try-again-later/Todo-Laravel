@props([
    'href' => '#',
    'active' => false,
])

<a href="{{ $href }}" class="nav-link px-2 {{ $active ? 'text-white' : 'text-secondary' }}">
    {{ $slot }}
</a>
