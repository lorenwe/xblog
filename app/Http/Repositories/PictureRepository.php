<?php

namespace App\Http\Repositories;

use App\Picture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lufficc\MarkDownParser;
use Lufficc\FileUploadManager;

/**
 * design for cache
 *
 *
 * Class PictureRepository
 * @package App\Http\Repository
 */
class PictureRepository extends Repository
{

    static $tag = 'picture';

    public function model()
    {
        return app(Picture::class);
    }

    public function count()
    {
        $count = $this->remember($this->tag() . '.count', function () {
            return $this->model()->withoutGlobalScopes()->count();
        });
        return $count;
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function pagedPicturesWithoutGlobalScopes($page = 20)
    {
        $pictures = $this->remember('picture.WithOutContent.' . $page . '' . request()->get('page', 1), function () use ($page) {
            return Picture::withoutGlobalScopes()->orderBy('created_at', 'desc')->select(['id', 'title', 'description', 'thumbnail', 'deleted_at', 'published_at', 'status'])->paginate($page);
        });
        return $pictures;
    }

    public function pictureCount()
    {
        $count = $this->remember('picture-count', function () {
            return Picture::count();
        });
        return $count;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $this->clearAllCache();

        $status = $request->get('status', 0);
        if ($status == 1) {
            $request['published_at'] = Carbon::now();
        }

        $markDownParser = new MarkDownParser($request->get('content'));
        $html_content = $markDownParser->clean(false)
            ->gallery(true)
            ->figure(true)
            ->toc(true)
            ->parse();
        $picture = auth()->user()->pictures()->create(
            array_merge(
                $request->except(['_token']),
                [
                    'content' => $html_content,
                    'img_category_id' => 1,
                ]
            )
        );

        return $picture;
    }

    /**
     * @param Request $request
     * @param Picture $picture
     * @return bool|int
     */

    public function update(Request $request, Picture $picture)
    {
        $this->clearAllCache();

        $status = $request->get('status', 0);
        if ($status == 1) {
            $request['published_at'] = Carbon::now();
        }

        $markDownParser = new MarkDownParser($request->get('content'));
        $html_content = $markDownParser->clean(false)
            ->gallery(true)
            ->figure(true)
            ->toc(true)
            ->parse();
        return  $picture->update(
            array_merge(
                $request->except(['_token', 'description', '_method']),
                [
                    'content' => $html_content,
                    'description' => $markDownParser->with($request->get('description'))->clean(false)->parse(),
                ]
            ));
    }

    public function tag()
    {
        return PictureRepository::$tag;
    }


    public function uploadThumbnail(Picture $picture, $file, $folder, $file_prefix, $name = null)
    {
        if(empty($name)){
            $name = getMilliseconds();
        }
        $file_path = sprintf("picture/%s/", $folder);

        $file_name = sprintf('%s.%s', $name, $file_prefix);

        $key = $file_path . $file_name;

        if(stripos($file, 'data:image/jpeg;base64,') === 0) {
            $img = base64_decode(str_replace('data:image/jpeg;base64,', '', $file));
        } else if(stripos($file, 'data:image/png;base64,') === 0) {
            $img = base64_decode(str_replace('data:image/png;base64,', '', $file));
        } else {
            return false;
        }
        $temp_file_path = tempnam(sys_get_temp_dir(), 'ThumbnailImg');
        $result = file_put_contents($temp_file_path, $img); //返回的是字节数
        if($result == false) {
            return false;
        }
        $FileUploadManager = new FileUploadManager();
        list($upload_result, $disk_name) = $FileUploadManager->uploadFile($key, $temp_file_path);

        if ($upload_result) {
            $url = $FileUploadManager->url($key, $disk_name);
            if($picture->update(['thumbnail' => $url])){
                return $url;
            }
        } else {
            return false;
        }
    }

    /**
     *  将base64数据的图片存入指定位置指定名字下
     *  $file base64文件
     *  $folder 文件夹名
     *  $name 文件名
     *  $file_prefix 后缀名
     */
    public function save_base64_image($file, $folder, $file_prefix, $name = null)
    {
        if(empty($name)){
            $name = getMilliseconds();
        }
        $file_path = sprintf("picture/%s/", $folder);

        $file_name = sprintf('%s.%s', $name, $file_prefix);

        $key = $file_path . $file_name;

        if(stripos($file, 'data:image/jpeg;base64,') === 0) {
            $img = base64_decode(str_replace('data:image/jpeg;base64,', '', $file));
        } else if(stripos($file, 'data:image/png;base64,') === 0) {
            $img = base64_decode(str_replace('data:image/png;base64,', '', $file));
        } else {
            return false;
        }
        $temp_file_path = tempnam(sys_get_temp_dir(), 'ThumbnailImg');
        $result = file_put_contents($temp_file_path, $img); //返回的是字节数
        if($result == false) {
            return false;
        }
        $FileUploadManager = new FileUploadManager();
        list($upload_result, $disk_name) = $FileUploadManager->uploadFile($key, $temp_file_path);

        if ($upload_result) {
            return $FileUploadManager->url($key, $disk_name);
        } else {
            return false;
        }
    }
}