<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    use HasApiTokens;
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        $attributes['password'] = bcrypt($attributes['password']);
        return $this->model->create($attributes);
    }

    /**
     * @return mixed
     */
    public function loginUser($data)
    {
        if (!$token = auth()->attempt($data)) {
            return false;
        }

        $token = auth()->user()->createToken("API TOKEN", ['*']);

        return [
            'id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'is_admin' => auth()->user()->is_admin,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->accessToken['expires_at'])->toDateTimeString()
        ];
    }

    public function logoutUser($request)
    {
        return auth('web')->logout();
    }

    public function authUser()
    {
        return auth('sanctum')->user();
    }
}
