<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PictureRepository;
use App\Picture;
use Illuminate\Http\Request;

use App\Http\Requests;

class PictureController extends Controller
{

    protected $pictureRepository;

    /**
     * PageController constructor.
     * @param $pageRepository
     */
    public function __construct(PictureRepository $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.picture.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        $picture = $this->pictureRepository->create($request);
        if ($picture) {
            if ($picture->isPublished()) {
                $link = route('picture.show');
            } else {
                $link = '';//route('picture.preview');
            }
            return redirect('admin/pictures')->with('success', '文章' . "<a href='$link'>$picture->title</a>" . '创建成功.');
        } else {
            return redirect('admin/pictures')->withErrors('文章' . $request['name'] . '创建失败');
        }

    }

    public function edit($id)
    {
        // 取消全局查询作用域进行查询
        $picture = Picture::withoutGlobalScopes()->find($id);

        // 检测权限
        $this->checkPolicy('update', $picture);

        return view('admin.picture.edit', [
            'picture' => $picture,
            /*'categories' => $this->categoryRepository->getAll(),
            'tags' => $this->tagRepository->getAll(),*/
        ]);
    }

    public function update(Request $request, $id)
    {
        $picture = Picture::withoutGlobalScopes()->find($id);
        $this->checkPolicy('update', $picture);
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        if ($this->pictureRepository->update($request, $picture)) {
            $link = $this->getPictureLink($picture);
            return redirect('admin/pictures')->with('success', "<a href='$link'>$picture->title</a> " . '修改成功.');
        } else
            return redirect('admin/pictures')->withErrors('文章' . $request['name'] . '修改失败');
    }

    public function thumbnail(Request $request)
    {
        $picture_id = '';
        if($request->has('picture_id')) {
            $picture_id = $request->picture_id;
        } else {
            abort(500);
        }
        $picture = Picture::withoutGlobalScopes()->find($picture_id);
        $this->checkPolicy('update', $picture);
        if($request->has('slim') && $request->slim[0]) {
            $output = $request->slim[0];
            $output = json_decode($output, TRUE);
            if(isset($output) && isset($output['output']) && isset($output['output']['image'])){
                $image = $output['output']['image'];
                if(isset($image)) {
                    $data = $this->pictureRepository->uploadThumbnail($picture, $image, 'picture_'.$picture_id, 'jpg');
                    if($data) {
                        return $data;
                    }else{
                        abort(500);
                    }
                }
            }else{
                abort(500);
            }
        }
    }

    private function getPictureLink(Picture $picture)
    {
        if ($picture->isPublished()) {
            $link = ''; //route('picture.show', $picture->id);
        } else {
            $link = ''; //route('picture.preview', $picture->id);
        }
        return $link;
    }

}
