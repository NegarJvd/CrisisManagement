<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function users_list(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::query()
            ->orderByDesc('id')
            ->paginate();

        return view('users', [
            'users' => $users,
        ]);
    }
}
