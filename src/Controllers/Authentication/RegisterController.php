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
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'password','phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function register(Request $request, Response $response): Response
    {
        DB::enableQueryLog();
        $inputData = $request->getParsedBody();

        $data = [
            "first_name"=>$inputData['first_name'],
            "surname"=>$inputData['surname'],
            "other_name"=>$inputData['other_name'],
            "email"=>$inputData['email'],
            "password"=>$inputData['password'],
            "phone_number"=>$inputData['phone_number'],
        ];

//        check for password validity and returns a boolean
        if (!passwordValidator($inputData['password'])){
            return $this->customResponse->is406Response($response, [
                "message"=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.'
            ]);
        }

        if (!$inputData['password'] === $inputData['confirmPassword']){
            return $this->customResponse->is406Response($response, [
                "message"=>"Passwords don't match"
            ]);
        }

        $email = $inputData['email'];
        $userDetail = User::where('email', $email)->first(self::userColumns);

        if (!$userDetail->email){
            DB::table("users")->insert($data);
            return $this->customResponse->is200Response($response, ["message"=>"Account created successfully."]);
        } else{
            return $this->customResponse->is406Response($response, ["message"=>"A user with this email address already exists."]);
        }
    }
}