<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
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

    public function store(StoreTagRequest $request)
    {
        $this->tagService->storeTag($request);
        return redirect()->route('admin.tags.index')->with('success','Thêm thẻ thành công!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit',compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->tagService->UpdateTag($request , $tag);
        return redirect()->route('admin.tags.index')->with('success','Cập nhật thẻ thành công!');
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids',[]);
        $id = $request->input('id');
        // dd($ids);
        try {
            if($id){
                $this->tagService->delete($id);
            }
            elseif (!empty($ids)) {
                $idsArray = explode(',', $ids);
                $this->tagService->deleteAll($idsArray);
            }
            return redirect()->route('admin.tags.index')->with('success', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.tags.index')->with('error', $e->getMessage());
        }
    }
}
