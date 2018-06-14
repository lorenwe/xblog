<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PictureRepository;
use App\Picture;
use App\PictureImgs;
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

        $initial_preview = array();
        $initial_preview_config = '[]';
        if(!empty($picture->json_pack)){
            foreach(json_decode($picture->json_pack, true) as $value){
                array_push($initial_preview, $value['downloadUrl']);
            }
            $initial_preview_config = $picture->json_pack;
        }
        return view('admin.picture.edit', [
            'picture' => $picture,
            'initial_preview' => json_encode($initial_preview),
            'initial_preview_config' => $initial_preview_config,
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
        if(!empty($picture->thumbnail)){
            abort(500, '不允许覆盖上传');
        }
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

    public function thumbnail_del(Request $request)
    {
        $this->validate($request, [
            'picture_id' => 'required'
        ]);
        $picture_id = $request->picture_id;
        $picture = Picture::withoutGlobalScopes()->find($picture_id);
        $this->checkPolicy('update', $picture);
        $thumbnail_info = json_decode($picture->thumbnail_info, true);
        if ($this->pictureRepository->delete($thumbnail_info['key'], $thumbnail_info['disk'])) {
            $result = $picture->update([
                'thumbnail' => null,
                'thumbnail_info' => null,
            ]);
        } else {
            $result = false;
        }
        if($result){
            return response()->json(['status'=>true, 'message'=>'删除成功']);
        }else{
            return response()->json(['status'=>false, 'message'=>'删除失败']);
        }
    }

    public function upload(Request $request)
    {
        $picture_id = '';
        $this->validate($request, [
            'file_data' => 'required|image|max:5000'
        ]);
        if($request->has('picture_id')) {
            $picture_id = $request->picture_id;
        } else {
            abort(500);
        }

        $picture = Picture::withoutGlobalScopes()->find($picture_id);
        $this->checkPolicy('update', $picture);

        $result = $this->pictureRepository->uploadImgPack($picture, $request);
        //更新数据库
        if(empty($picture->json_pack)){
            $picture_pack = array();
        }else{
            $picture_pack = json_decode($picture->json_pack, true);
        }

        if($result['status'] == true){
            // {caption: "Moon.jpg", downloadUrl: url1, size: 930321, key: 1}
            $img = array(
                'caption' => $result['filename'],
                'downloadUrl' => $result['url'],
                'size' => $result['size'],
                'key' => $result['key'],
            );
            array_push($picture_pack, $img);
            $picture->update([
                'json_pack' => json_encode($picture_pack),
            ]);
        }
        if ($request->expectsJson()) {
            return response()->json($result, array_key_exists('error', $result) ? 500 : 200);
        } else {
            if (!array_key_exists('error', $result)){
                return back()->with('success', '上传成功');
            }
            return back()->withErrors('上传失败');
        }
    }

    public function pack_delete(Request $request)
    {
        $this->validate($request, [
            'key' => 'required',
            'picture_id' => 'required'
        ]);
        $picture_id = $request->picture_id;
        $picture_img_id = $request->key;
        $picture = Picture::withoutGlobalScopes()->find($picture_id);
        $this->checkPolicy('update', $picture);
        if (!empty($picture->json_pack)) {
            $picture_img = PictureImgs::find($picture_img_id);
            if (!$picture_img) {
                abort(500);
            }
            if ($this->pictureRepository->delete($picture_img->key, $picture_img->disk)) {
                $img_pack = json_decode($picture->json_pack, true);
                $new_img_pack = array();
                if (!empty($img_pack)) {
                    foreach($img_pack as $value){
                        if($value['caption'] != $picture_img->name){
                            array_push($new_img_pack, $value);
                        }
                    }
                }
                $new_json_pack = json_encode($new_img_pack);
                $result = $picture->update([
                    'json_pack' => $new_json_pack,
                ]);
            } else {
                $result = false;
            }
        }else{
            $result = false;
        }
        if ($request->expectsJson()) {
            if ($result) {
                return response()->json(['status'=>true, 'message'=>'删除成功']);
            }
            abort(500);
        } else {
            if ($result) {
                return back()->with('success', '删除成功');
            }
            return back()->withErrors('删除失败');
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
