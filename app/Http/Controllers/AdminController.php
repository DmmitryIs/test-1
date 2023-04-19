<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = (new UserService())->getAll();

        return view('admin.users', compact('users'));
    }
}
