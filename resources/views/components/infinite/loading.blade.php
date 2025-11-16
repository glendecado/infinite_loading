@props(['hasMore' => false, 'total' => 0, 'page' => 1, 'perPage' => 10])
@extends('layouts.app')
@section('content')
<div>
    <div id="data-container">
        {{ $slot }}
    </div>


    @if($hasMore)
      <x-infinite.load-more />
    @endif
</div>
@endsection

@push('scrpts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
        const userList = document.getElementById('data-container');
        const loadMore = document.getElementById('load-more');
        let page = parseInt("{{ $page }}");
        const perPage = parseInt("{{ $perPage }}");
        const total = parseInt("{{ $total }}");

        if (!loadMore) return;

        const observer = new IntersectionObserver(async ([entry]) => {
            if (!entry.isIntersecting) return;

            if (userList.children.length >= total) {
                loadMore.style.display = 'none';
                return;
            }

            page++;

            const res = await fetch(`?page=${page}&perPage=${perPage}`);
            const html = await res.text();

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newData = tempDiv.querySelectorAll('#data-container > div');

            newData.forEach(u => userList.appendChild(u));

            if (userList.children.length >= total) {
                loadMore.style.display = 'none';
            }
        }, {
            rootMargin: '100px',
        });

        observer.observe(loadMore);
    });
</script>
@endpush
