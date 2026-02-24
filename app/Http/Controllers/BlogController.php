<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogIndex(Request $request): View
    {
        return $this->indexByType($request, 'blog');
    }

    public function newsIndex(Request $request): View
    {
        return $this->indexByType($request, 'news');
    }

    public function blogShow(Post $post): View
    {
        return $this->showByType($post, 'blog');
    }

    public function newsShow(Post $post): View
    {
        return $this->showByType($post, 'news');
    }

    private function indexByType(Request $request, string $type): View
    {
        $categorySlug = (string) $request->query('category', '');

        $posts = Post::query()
            ->with(['category', 'author'])
            ->where('type', $type)
            ->where('status', 'published')
            ->when($categorySlug !== '', fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $categorySlug)))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(6)
            ->withQueryString();

        $categories = Category::query()
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->whereHas('posts', fn ($query) => $query->where('type', $type)->where('status', 'published'))
            ->withCount(['posts' => fn ($query) => $query->where('type', $type)->where('status', 'published')])
            ->orderBy('name')
            ->get();

        $latestPosts = Post::query()
            ->with(['category'])
            ->where('type', $type)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return view('blogs.index', [
            'posts' => $posts,
            'type' => $type,
            'categories' => $categories,
            'selectedCategory' => $categorySlug,
            'latestPosts' => $latestPosts,
        ]);
    }

    private function showByType(Post $post, string $type): View
    {
        abort_unless($post->type === $type && $post->status === 'published', 404);

        $post->load(['category', 'author']);

        $relatedPosts = Post::query()
            ->where('type', $type)
            ->where('status', 'published')
            ->whereKeyNot($post->id)
            ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        if ($relatedPosts->count() < 4) {
            $extra = Post::query()
                ->where('type', $type)
                ->where('status', 'published')
                ->whereKeyNot($post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->orderByDesc('published_at')
                ->limit(4 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->concat($extra);
        }

        $categories = Category::query()
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->whereHas('posts', fn ($query) => $query->where('type', $type)->where('status', 'published'))
            ->withCount(['posts' => fn ($query) => $query->where('type', $type)->where('status', 'published')])
            ->orderBy('name')
            ->get();

        $latestPosts = Post::query()
            ->where('type', $type)
            ->where('status', 'published')
            ->whereKeyNot($post->id)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return view('blogs.show', compact('post', 'type', 'relatedPosts', 'categories', 'latestPosts'));
    }
}
