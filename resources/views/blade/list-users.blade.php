@extends('layouts.app')

@section('content')

<div class="flex  justify-center">
    <x-infinite.scrolling :page="$users->currentPage()" :perPage="$perPage" :total="$users->total()">

        <div class="m-10 w-96">
            @foreach ($users as $user)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-5 flex flex-col justify-between transform hover:-translate-y-1 hover:scale-105">

                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-purple-500 via-pink-500 to-yellow-500 flex items-center justify-center text-white font-extrabold text-xl shadow-inner">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm truncate">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="text-gray-400 dark:text-gray-500 text-sm mb-4">User ID: {{ $user->id }}</div>
            </div>
            @endforeach
        </div>

    </x-infinite.scrolling>
</div>

@endsection