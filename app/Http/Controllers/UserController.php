<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 7;
        $page = $request->get('page', 1);
        $skip = ($page - 1) * $perPage;
        $users = \App\Models\User::skip($skip)->take($perPage)->get();
        $total = \App\Models\User::count();
        $hasMore = $skip + $perPage < $total;

        return view('blade.list-users', compact('users', 'hasMore', 'page', 'total', 'perPage'));
    }
}
