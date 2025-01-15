<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.pages.tags.list');
    }

    public function create()
    {
        return view('admin.pages.tags.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit');
    }

    public function update(Request $request, Tag $tag)
    {

    }

    public function destroy(Request $request)
    {

    }
}
