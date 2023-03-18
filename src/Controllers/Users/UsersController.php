<?php

namespace App\Controllers\Users;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Utils\CustomResponse;
use Illuminate\Database\Capsule\Manager as DB;
class UsersController
{
    protected $user;
    private $customResponse;
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'password', 'phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function all(Request $request, Response $response): Response
    {

        return $this->customResponse->is200Response($response, "All users");
    }
    public function user(Request $request, Response $response, $id): Response
    {
        return $this->customResponse->is200Response($response, "UserID => {$id}");
    }
}