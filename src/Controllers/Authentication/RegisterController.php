<?php

namespace App\Controllers\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use App\Controllers\Utils\CustomResponse;
use App\Models\User;
class RegisterController
{
    protected $user;
    private $customResponse;
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'password', 'confirmPassword','phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function register(Request $request, Response $response): Response
    {
        $inputData = $request->getParsedBody();
        if ($inputData['password'] !== $inputData['confirmPassword']){
            return $this->customResponse->is406Response($response, ["message"=>"Passwords dont match"]);
        }
        if ( strlen($inputData['password'])  < 8){
            return $this->customResponse->is406Response($response, ["message"=>"Passwords length has to be between 8 - 50 characters long"]);
        }
        DB::enableQueryLog();

        $email = $inputData['email'];
        $userDetail = User::where('email', $email)->first(self::userColumns);

        if (!$userDetail->email){
            $save_results = DB::table("users")->insert($inputData);
            return $this->customResponse->is200Response($response, ["message"=>"User Created"]);
        } else{
            return $this->customResponse->is406Response($response, ["message"=>"User with this email address exists"]);
        }



    }
}