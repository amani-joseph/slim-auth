<?php

namespace App\Controllers\Utils;

const HEADER_SET = "application/json";

class CustomResponse
{
    public function is200Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => true,
            "responseCode" => 200,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(200);
    }

    public function is201Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => true,
            "responseCode" => 201,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(201);
    }

    public function is204Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => true,
            "responseCode" => 204,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(204);
    }

    public function is400Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 400,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(400);
    }

    public function is403Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 406,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(406);
    }

    public function is406Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 406,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(406);
    }

    public function is401Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 401,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(401);
    }

    public function is422Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => true,
            "responseCode" => 422,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->witHeader("Content-Type", HEADER_SET)
            ->withStatus(422);
    }

    public function is404Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 404,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(404);
    }

    public function is500Response($response, $responseMessage)
    {
        $responseMessage = json_encode([
            "success" => false,
            "responseCode" => 500,
            "response" => $responseMessage
        ]);

        $response->getBody()->write($responseMessage);

        return $response->withHeader("Content-Type", HEADER_SET)
            ->withStatus(500);
    }
}