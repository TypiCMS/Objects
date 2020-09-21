<ul class="object-list-results-list">
    @foreach ($items as $object)
    <li class="object-list-results-item">
        <a class="object-list-results-item-link" href="{{ $object->uri() }}" title="{{ $object->title }}">
            <span class="object-list-results-item-title">{{ $object->title }}</span>
        </a>
    </li>
    @endforeach
</ul>
