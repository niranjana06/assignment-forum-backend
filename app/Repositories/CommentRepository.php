<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param Comment $model
     */
    public function __construct(Comment $model, UserRepositoryInterface $userRepository)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->userRepository = $userRepository;
    }

    public function create(array $attributes): Model
    {
        $user = $this->userRepository->authUser();
        $attributes = array_merge([ 'user_id' => $user->id], $attributes);

        return $this->model->create($attributes);
    }
}
