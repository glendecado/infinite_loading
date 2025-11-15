<?php

use App\Models\User;
use function Livewire\Volt\{state, mount};

// STATE
state([
    'users'   => [],
    'page'    => 1,
    'perPage' => 7,
    'total' => User::count(),
    'hasMore' => 'true'
]);

// INITIAL LOAD
mount(function () {
    $this->users = User::take($this->perPage)->get();
});

// LOAD MORE (EXPOSE TO ALPINE)
$loadMore = function () {
    $this->page++;
    $more = User::skip(($this->page - 1) * $this->perPage)->take($this->perPage)->get();
    if (count($more) === 0) {
        $this->hasMore = false;
        return;
    }
    $this->users = [...$this->users, ...$more];
};

?>

<div
    x-data="{
        observe() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $wire.call('loadMore');
                    }
                })
            }, { rootMargin: '100px' }); // preload earlier
            observer.observe(this.$refs.load);
        }
    }"
    x-init="observe()"
    class="space-y-4 max-w-xl mx-auto p-4">

    <div
        wire.live:model="page"
        class="sticky top-0 z-50 bg-white dark:bg-gray-800 p-4 shadow-md dark:text-gray-100">
        Page: {{ $page }}
    </div>



    <div class="space-y-4">
        @foreach ($this->users as $user)
        <div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="w-12 h-12 bg-amber-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="text-gray-900 dark:text-gray-100 font-semibold text-lg">{{ $user->name }}</div>
                <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</div>
                <div class="text-gray-400 dark:text-gray-500 text-xs">ID: {{ $user->id }}</div>
            </div>
        </div>
        @endforeach
    </div>

    @if($this->hasMore)
    <div x-ref="load" class="flex justify-center py-6 text-amber-400 font-medium">
        <svg class="animate-spin h-6 w-6 mr-2 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Loading...
    </div>
    @endif



</div>