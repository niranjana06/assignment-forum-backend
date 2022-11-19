<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StatusUpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResourceById;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostController extends ApiController
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = $this->postRepository->getAllApprovedPosts();
            return new PostResource($posts);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    public function getPostById($postId)
    {
        try {
            $posts = $this->postRepository->getPostById($postId);
            return new PostResourceById($posts);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }    }

    public function pendingPosts()
    {
        try {
            $posts = $this->postRepository->getAllPendingPosts();
            return new PostResource($posts);
            //return $this->respondSuccessWithPagination($posts, $posts->count());
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    public function userPosts($id, $status)
    {
        try {
            $posts = $this->postRepository->getAllPendingUserPosts($id, $status);
            return new PostResource($posts);
            //return $this->respondSuccessWithPagination($posts, $posts->count());
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        // create post
        try {
            $this->postRepository->create($request->all());
            return $this->respondSuccess(['message' => 'Post Created Successfully',]);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request)
    {
        //
    }

    public function approvePost(StatusUpdatePostRequest $request)
    {
        try {
            $this->postRepository->approve($request->all());
            return $this->respondSuccess(['message' => 'Post Approved Successfully',]);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    public function rejectPost(StatusUpdatePostRequest $request)
    {
        try {
            $this->postRepository->reject($request->all());
            return $this->respondSuccess(['message' => 'Post Rejected',]);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $this->postRepository->destroy($post);
            return $this->respondSuccess(['message' => 'Post Deleted',]);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }
}
