<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(Post $model, UserRepositoryInterface $userRepository)
    {
        parent::__construct($model);
        $this->userRepository = $userRepository;
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        // get authenticated user
        $user = $this->userRepository->authUser();
        $attributes = array_merge(['slug' => Str::slug($attributes['title']), 'user_id' => $user->id], $attributes);

        // for admin post will be auto approved
        if ($user->is_admin) {
            $attributes = array_merge(['status' => config('app.const.status.approved')], $attributes);
        }

        return $this->model->create($attributes);
    }

    /**
     * @return Model
     */
    public function getAllApprovedPosts($postId = null)
    {
        return $this->model
            ->with(['comments' => function($q){
                $q->orderBy('created_at', 'ASC');
            }, 'comments.replyComments' => function($q1){
                $q1->orderBy('created_at', 'ASC');
            },'user','product'])
            ->withCount('comments')
            //->where('status', config('app.const.status.approved'))
            ->paginate();
    }

    public function getPostById($id)
    {
        $postQry = $this->model
            ->with(['comments' => function ($q) {
                $q->withCount('replyComments')->orderBy('created_at', 'ASC');
            }, 'comments.replyComments' => function ($q1) {
                $q1->orderBy('created_at', 'ASC');
            }, 'user', 'product']);

        $postQry->withCount('comments')
            ->where('status', config('app.const.status.approved'));

        $post = $postQry->where('id', $id)->first();

        return $post;
    }

    /**
     * @return mixed
     */
    public function getAllPendingPosts()
    {
        return $this->model->where('status', config('app.const.status.pending'))->paginate();
    }

    public function getAllPendingUserPosts($id ,$status)
    {
        $status = ($status == 'pending') ? config('app.const.status.pending'): config('app.const.status.approved');
        return $this->model
            ->where('user_id', $id)
//            ->where('status', $status)
            ->paginate();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function approve($data)
    {
        return $this->model->where('id', $data['post_id'])->update([
            'status' => $data['status']
        ]);
    }


    /**
     * @param $data
     * @return mixed
     */
    public function reject($data)
    {
        return $this->model->where('id', $data['post_id'])->update([
            'status' => $data['status']
        ]);
    }

    public function destroy($model)
    {
        $user = $this->userRepository->authUser();

        $post = $this->model::where('user_id',$user->id)->findOrFail($model->id);

        return $post->delete();
    }

}
