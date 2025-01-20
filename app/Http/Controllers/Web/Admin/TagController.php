<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\Web\Admin\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;
    public function __construct(TagService $tagService) {
        $this->tagService = $tagService;
    }
    public function index(Request $request)
    {
        $keyWord = $request->input('_keyword');
        $perPage = $request->get('per_page',10);
        $tags = $this->tagService->listTag15($perPage, $keyWord);
        return view('admin.pages.tags.list',compact('tags','perPage','keyWord'));
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
