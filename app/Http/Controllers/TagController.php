<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PostRepository;
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

    public function index()
    {
        $tags = $this->tagRepository->getAll()->reject(function ($tag) {
            return $tag->posts_count == 0;
        });
        $total = app(PostRepository::class)->count();
        return view('tag.index', compact('tags', 'total'));
    }

    public function show($name)
    {
        $tag = $this->tagRepository->get($name);
        $page_size = $page_size = get_config('page_size', 7);

        $posts = $this->tagRepository->pagedPostsByTag($tag, $page_size);
        return view('tag.show', compact('posts', 'name'));
    }
}
