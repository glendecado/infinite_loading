# Infinite Scrolling with Livewire & Blade PHP (Vanilla JS)

This project demonstrates **infinite scrolling ** functionality using **Livewire**, **Blade PHP**, and **vanilla JavaScript**. It allows you to load data progressively without refreshing the page, which is ideal for displaying long lists of items like users, posts, or products.

---

## Features
- **Two User List Types**
  1. **Styled User List** – a visually enhanced layout with borders, padding, and typography.
  2. **Simple User List** – a plain list without design for quick integration or lightweight usage.

- **Reusable Blade Component**
  - `x-infinite.loading` handles the infinite scroll logic.
  - Easily configurable with `hasMore`, `page`, `perPage`, and `total` parameters.

- **Backend Pagination**
  - Uses Laravel's `paginate()` to efficiently fetch data per page.
  - `perPage` determines how many items are loaded per request.

- **Frontend Integration**
  - Vanilla JavaScript handles loading more data as the user scrolls.
  - Fully compatible with Blade components.

---



## For Blade that uses components
- **layouts/app.blade.php is required**
    - Example app layout:
    
 ````php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @yield('content')

        @stack('scrpts')
    </body>
    </html>
````   
    - @yield('content') and @stack('scripts') are required for Blade components and JavaScript to work properly.


- **Backend Example**
    - Create a controller method for fetching paginated data:
````php
    public function index(Request $request)
    {
        $perPage = 7;

        // Fetch paginated users
        $users = \App\Models\User::paginate($perPage);

        return view('user-list', [
            'users'   => $users,
            'perPage' => $perPage,
        ]);
    }
````
- **Frontend Blade Example**
    - Use the infinite scrolling component to display users:
````php
<x-infinite.scrolling :hasMore="$users->hasMorePages()" :page="$users->currentPage()" :perPage="$perPage" :total="$users->total()">

    @foreach ($users as $user)
    <div class="border rounded-md p-2 m-2">
        <div class="font-semibold text-lg">{{ $user->name }}</div>
        <div class="text-gray-600 dark:text-gray-400">{{ $user->email }}</div>
        <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
    </div>
    @endforeach

</x-infinite.scrolling>
````
- **You can redesign the "Load More" button or infinite loader in resources/views/components/infinite/load-more.blade.php**