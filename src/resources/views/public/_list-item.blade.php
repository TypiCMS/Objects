<li class="objects-item">
    <a class="objects-item-link" href="{{ $object->uri() }}" title="{{ $object->title }}">
        <span class="objects-item-title">{!! $object->title !!}</span>
        <span class="objects-item-image">{!! $object->present()->thumb(null, 200) !!}</span>
    </a>
</li>
