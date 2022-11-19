<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(CreateUserRequest $request)
    {
        // create user
        try {
            $user = $this->userRepository->create($request->all());
            return $this->respondSuccess([
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(LoginRequest $request)
    {
        // user login
        try {
            $data = $this->userRepository->loginUser($request->all());
            if (!$data) {
                return $this->respondUnauthorized('Incorrect username or password');
            }
            return $this->respondSuccess($data);
        } catch (\Throwable $th) {
            return $this->respondInternalError(['message' => $th->getMessage()]);
        }
    }


    public function logout(Request $request)
    {
        $this->userRepository->logoutUser($request);

        return $this->respondSuccess([
            'user' => 'Logout success'
        ]);
    }
}
