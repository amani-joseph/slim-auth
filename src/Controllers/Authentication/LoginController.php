<?php

namespace App\Controllers\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Utils\CustomResponse;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\User;
class LoginController
{
    protected $user;
    private $customResponse;
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'password', 'phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function login(Request $request, Response $response): Response
    {
        $inputData = $request->getParsedBody();
        DB::enableQueryLog();

        $email = $inputData['email'];
        $password = $inputData['password'];
        $userDetail = User::where('email', $email)->first(self::userColumns);
        if($password === $userDetail->password && $email === $userDetail->email)
        {
            return $this->customResponse->is200Response($response,['message'=>'Login Successful']);
        }
        else
        {
            return $this->customResponse->is401Response($response,['message'=>'Wrong email or password, try again']);
        }
    }
}