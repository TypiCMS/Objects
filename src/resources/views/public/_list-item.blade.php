<li>
    <a href="{{ route($lang.'::object', $object->slug) }}" title="{{ $object->title }}">
        {!! $object->title !!}
        {!! $object->present()->thumb(null, 200) !!}
    </a>
</li>
