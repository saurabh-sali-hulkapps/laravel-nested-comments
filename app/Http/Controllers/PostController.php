<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the post.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $postsQuery = Post::query()->with('user');
        if ($request->search) {
            $postsQuery->where('title', $request->search);
        }
        $posts = $postsQuery
            ->sortable()
            ->latest()
            ->paginate(3, '*', 'page');
        return view('livewire.post', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $post = [
            'id' => '',
            'title' => '',
            'description' => ''
        ];
        return view('livewire.post-create', ['post' => $post]);
    }

    /**
     * Store a newly created resource in post.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string'
        ]);

        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified post.
     *
     * @param Post $post
     * @return Application|Factory|View|Response
     */
    public function show(Post $post)
    {
        return view('livewire.post-details', ['post' => $post]);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $postData = Post::find($id);
        if (Auth::user()->id === $postData->user_id) {
            $post = [
                'id' => $postData->id,
                'title' => $postData->title,
                'description' => $postData->description
            ];

            return view('livewire.post-create', ['post' => $post]);
        } else {
            return view('livewire.not-authorized');
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string'
        ]);

        Post::where('id', $id)
            ->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

        return redirect()->route('posts.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Post::destroy($id);

        return redirect()->route('posts.index');
    }
}
