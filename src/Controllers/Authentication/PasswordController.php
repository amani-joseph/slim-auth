<?php

namespace App\Controllers\Authentication;

use App\Controllers\Utils\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PasswordController
{
    protected $user;
    private $customResponse;
    const userColumns = ['id', 'first_name', 'surname', 'other_name', 'email', 'password', 'phone_number'];

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
    }
    public function passwordForgot(Request $request, Response $response): Response
    {
        $inputData = $request->getParsedBody();
        return $this->customResponse->is200Response($response, "{$inputData['email']} Forgot password");
    }
    public function passwordReset(Request $request, Response $response): Response
    {
        $inputData = $request->getParsedBody();
        return $this->customResponse->is200Response($response, "{$inputData['email']} wants to reset password");
    }
    public function passwordChange(Request $request, Response $response): Response
    {
        $inputData = $request->getParsedBody();
        return $this->customResponse->is200Response($response, "{$inputData['currentPassword']}  Change to {$inputData['newPassword']}");
    }
}