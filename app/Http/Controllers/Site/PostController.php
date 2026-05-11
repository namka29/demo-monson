<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $posts,
    ) {}

    public function index(): View
    {
        return view('site.posts.index', [
            'posts' => $this->posts->paginatePublishedByPublishedAtDesc(12),
        ]);
    }

    public function show(Post $post): View
    {
        return view('site.posts.show', compact('post'));
    }
}
