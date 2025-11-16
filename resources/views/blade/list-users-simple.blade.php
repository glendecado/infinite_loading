<x-infinite.loading :hasMore=" $users->hasMorePages()" :page="$users->currentPage()" :perPage="$perPage" :total="$users->total()">

        @foreach ($users as $user)
        <div class="border rounded-md p-2 m-2">
            <div class="font-semibold text-lg">{{ $user->name }}</div>
            <div class="text-gray-600 dark:text-gray-400">{{ $user->email }}</div>
            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
        </div>
        @endforeach

</x-infinite.loading>