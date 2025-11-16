
@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto p-6">
    <!-- Sticky Page Info -->
    <div class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md p-4 rounded-xl shadow-lg text-gray-800 dark:text-gray-100 font-bold text-lg flex justify-between items-center">
        Page: {{ $page }}
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $total }} Users Total</span>
    </div>

    <!-- User List -->
    <div class="space-y-6" id="data-container">
        @foreach ($users as $user)
        <div class="flex items-center space-x-5 p-5  bg-black from-amber-100/30 to-amber-300/20 dark:from-gray-800/50 dark:to-gray-700/50 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-950 from-amber-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-extrabold text-xl shadow-md">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="text-gray-900 dark:text-gray-100 font-semibold text-xl hover:text-amber-500 transition-colors">{{ $user->name }}</div>
                <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->email }}</div>
                <div class="text-gray-400 dark:text-gray-500 text-xs mt-1">ID: {{ $user->id }}</div>
            </div>
            <button class="px-3 py-1 bg-amber-400 hover:bg-amber-500 text-white rounded-full text-sm font-medium shadow-sm transition-all duration-200">
                View
            </button>
        </div>
        @endforeach
    </div>

    <!-- Load More -->
    @if($hasMore)
    <div id="load-more" class="flex justify-center py-6 text-amber-400 font-medium space-x-2">
        <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span class="text-lg">Loading more users...</span>
    </div>
    @endif
</div>
@endsection

@push('scrpts')
<script>

    // Vanilla JS Infinite Scroll
    
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