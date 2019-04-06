{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $object->title }}",
    "description": "{{ $object->summary !== '' ? $object->summary : strip_tags($object->body) }}",
    "image": [
        "{{ $object->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $object->uri() }}"
    }
}
</script>
--}}
