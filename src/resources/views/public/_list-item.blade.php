<li class="object-list-item">
    <a class="object-list-item-link" href="{{ $object->uri() }}" title="{{ $object->title }}">
        <span class="object-list-item-title">{{ $object->title }}</span>
        <span class="object-list-item-image-wrapper">
            <img class="object-list-item-image" src="{{ $object->present()->image(null, 200) }}" alt="">
        </span>
    </a>
</li>
