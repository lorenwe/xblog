<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Repositories\TagRepository;
use App\Tag;
use Illuminate\Http\Request;
use XblogConfig;

class TagController extends Controller
{
    public $tagRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags',
        ]);

        if ($this->tagRepository->create($request)) {
            $this->tagRepository->clearCache();
            return back()->with('success', 'Tag' . $request['name'] . '创建成功');
        } else
            return back()->with('error', 'Tag' . $request['name'] . '创建失败');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags',
        ]);

        if ($this->tagRepository->update($request, $tag)) {
            return redirect()->route('admin.tags')->with('success', '标签' . $request['name'] . '修改成功');
        }

        return back()->withInput()->withErrors('分类' . $request['name'] . '修改失败');
    }

    public function destroy(Tag $tag)
    {
        if ($tag->posts()->withoutGlobalScopes()->count() > 0) {
            return redirect()->route('admin.tags')->withErrors($tag->name . '下面有文章，不能刪除');
        }
        if ($tag->delete()) {
            $this->tagRepository->clearCache();
            return back()->with('success', $tag->name . '刪除成功');
        }
        return back()->withErrors($tag->name . '刪除失败');
    }
}
