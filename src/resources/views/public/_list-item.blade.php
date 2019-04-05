<li class="object-list-item">
    <a class="object-list-item-link" href="{{ $object->uri() }}" title="{{ $object->title }}">
        <span class="object-list-item-title">{!! $object->title !!}</span>
        <span class="object-list-item-image">{!! $object->present()->thumb(null, 200) !!}</span>
    </a>
</li>
