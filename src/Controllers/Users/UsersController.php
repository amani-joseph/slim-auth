<?php

namespace App\Controllers\Users;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Utils\CustomResponse;
use Illuminate\Database\Capsule\Manager as DB;
class UsersController
{
    protected $user;
    private $customResponse;
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function all(Request $request, Response $response): Response
    {
        DB::enableQueryLog();
        $users = User::all();
        return $this->customResponse->is200Response($response, $users);
    }
    public function user(Request $request, Response $response, $id): Response
    {
        DB::enableQueryLog();
        $userDetail = User::where('id', $id)->first(self::userColumns);
        return $this->customResponse->is200Response($response, $userDetail);
    }
}