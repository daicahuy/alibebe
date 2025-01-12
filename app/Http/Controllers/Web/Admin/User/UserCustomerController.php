<?php

namespace App\Http\Controllers\Web\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserCustomerController extends Controller
{
    public function index()
    {
        return view('admin.pages.users.customer.list');
    }

    public function create()
    {
        return view('admin.pages.users.customer.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit($id)
    {
        return view('admin.pages.users.customer.edit');
    }

    public function update(Request $request, $id)
    {

    }
}
