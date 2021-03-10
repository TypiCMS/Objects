<li class="object-list-item">
    <a class="object-list-item-link" href="{{ $object->uri() }}" title="{{ $object->title }}">
        <div class="object-list-item-title">{{ $object->title }}</div>
        <div class="object-list-item-image-wrapper">
            @empty (!$object->image)
            <img class="object-list-item-image" src="{{ $object->present()->image(null, 200) }}" width="{{ $object->image->width }}" height="{{ $object->image->height }}" alt="{{ $object->image->alt_attribute }}">
            @endempty
        </div>
    </a>
</li>
