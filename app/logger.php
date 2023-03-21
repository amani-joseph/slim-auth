<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


return function (App $app) {
    $settings = $app->getContainer()->get('settings');
    $log = $settings['logger'];
    $logger = new Logger($log['name']);
    $streamHandler = new StreamHandler($log['path'], 100);
    $logger->pushHandler($streamHandler);

    if (env('APP_DEBUG', false)) {
        $errorMiddleware = $app->addErrorMiddleware(
            $settings['displayErrorDetails'],
            $settings['logErrors'],
            $settings['logErrorDetails'],
            $logger
        );
        $errorMiddleware->setDefaultErrorHandler(function (
            ServerRequestInterface $request,
            Throwable              $exception
        ) use ($app, $logger) {
            http_request(
                env('SLK_LG'),
                json_encode(['text' => $exception->getMessage()]),
                ["Content-type: application/json"],
                "POST"
            );

            $path = $request->getUri()->getPath();
            if ($exception->getMessage() == "Not found."){

                $logger->error($exception->getMessage(), ['path' => $path, 'ip' => get_ip()]);
                $payload = [
                    "success" => false,
                    'responseCode' => 400,
                    'response' => $exception->getMessage()
                ];


            } elseif (strpos($exception->getMessage(), "Must be one of") != false) {

                $logger->error($exception->getMessage(), ['path' => $path, 'ip' => get_ip()]);

                $payload = [
                    "success" => false,
                    'responseCode' => 400,
                    'response' => $exception->getMessage()
                ];

            } else {

                $logger->error($exception->getMessage(), ['path' => $path, 'ip' => get_ip()]);
                $payload = [
                    "success" => false,
                    'responseCode' => 400,
                    'response' => "internal Error. Kindly Contact support the web Admin"
                ];

            }

            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write(json_encode($payload));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400, 'Internal Error');
        });
    }
};