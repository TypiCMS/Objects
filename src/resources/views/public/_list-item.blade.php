<li>
    <a href="{{ route($lang.'.objects.slug', $object->slug) }}" title="{{ $object->title }}">
        {!! $object->title !!}
        {!! $object->present()->thumb(null, 200) !!}
    </a>
</li>
