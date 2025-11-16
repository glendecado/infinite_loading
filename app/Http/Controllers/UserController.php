<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 7;

        $users = \App\Models\User::paginate($perPage);

        return view('blade.list-users', [
            'users'   => $users,
            'page'    => $users->currentPage(),
            'total'   => $users->total(),
            'perPage' => $perPage,
            'hasMore' => $users->hasMorePages(),
        ]);
    }


     public function indexSimple(Request $request)
    {
        $perPage = 7;

        $users = \App\Models\User::paginate($perPage);

        return view('blade.list-users-simple', [
            'users'   => $users,
            'perPage' => $perPage,
        ]);
    }
}
