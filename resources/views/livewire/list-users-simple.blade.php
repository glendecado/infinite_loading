<?php

use App\Models\User;
use function Livewire\Volt\{state, mount};

// STATE
state([
    'users'   => [],
    'page'    => 1,
    'perPage' => 7,
    'hasMore' => true,
]);

// INITIAL LOAD
mount(function () {
    $paginated = User::paginate($this->perPage);
    $this->users = $paginated->items();
    $this->hasMore = $paginated->hasMorePages();
});

// LOAD MORE (exposed to Alpine)
$loadMore = function () {
    if (!$this->hasMore) return;

    $this->page++;
    $paginated = User::paginate($this->perPage, ['*'], 'page', $this->page);

    $this->users = [...$this->users, ...$paginated->items()];
    $this->hasMore = $paginated->hasMorePages();
};
?>
<div
    x-data="{
        observe() {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $wire.call('loadMore');
                    }
                });
            }, { rootMargin: '100px' });
            observer.observe(this.$refs.load);
        }
    }"
    x-init="observe()"
>

    @foreach ($this->users as $user)
        <div class="flex-1 border m-2 p-2 rounded-md">
            <div>{{ $user->name }}</div>
            <div>{{ $user->email }}</div>
            <div>ID: {{ $user->id }}</div>
        </div>
    @endforeach

    @if ($this->hasMore)
        <div x-ref="load" class="text-center p-2 border m-5">
            Loading more users...
        </div>
    @endif

</div>
