<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\PostsDataTable;
use Corals\Modules\CMS\Http\Requests\PostRequest;
use Corals\Modules\CMS\Models\Post;

class PostsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.post.resource_url');
        $this->title = 'CMS::module.post.title';
        $this->title_singular = 'CMS::module.post.title_singular';

        parent::__construct();
    }

    /**
     * @param PostRequest $request
     * @param PostsDataTable $dataTable
     * @return mixed
     */
    public function index(PostRequest $request, PostsDataTable $dataTable)
    {
        return $dataTable->render('CMS::posts.index');
    }

    /**
     * @param PostRequest $request
     * @return $this
     */
    public function create(PostRequest $request)
    {
        $post = new Post();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::posts.create_edit')->with(compact('post'));
    }

    /**
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PostRequest $request)
    {
        try {
            $data = $request->except('featured_image');

            $data['author_id'] = user()->id;

            $post = Post::create($data);

            if ($request->hasFile('featured_image')) {
                $post->addMedia($request->file('featured_image'))->withCustomProperties(['root' => 'user_' . user()->hashed_id])->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            $post->categories()->sync($data['categories']);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Post::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return $this
     */
    public function show(PostRequest $request, Post $post)
    {
        return redirect('admin-preview/' . $post->slug);
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return $this
     */
    public function edit(PostRequest $request, Post $post)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $post->title])]);

        return view('CMS::posts.create_edit')->with(compact('post'));
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            $data = $request->except('featured_image', 'clear');

            $post->update($data);

            if ($request->has('clear') || $request->hasFile('featured_image')) {
                $post->clearMediaCollection('featured-image');
            }

            if ($request->hasFile('featured_image') && !$request->has('clear')) {
                $post->addMedia($request->file('featured_image'))->withCustomProperties(['root' => 'user_' . user()->hashed_id])->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            $post->categories()->sync($data['categories']);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Post::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PostRequest $request, Post $post)
    {
        try {
            $post->clearMediaCollection('featured-image');
            $post->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Post::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}