<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pages.users.list');
    }

    public function lock()
    {
        return view('admin.pages.users.lock');
    }

    public function show(User $user)
    {
        return view('admin.pages.users.show');
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit(User $user)
    {
        return view('admin.pages.users.edit');
    }

    public function update(Request $request, User $user)
    {

    }
}
