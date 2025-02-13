<?php
declare(strict_types=1);


use BackEnd\application\actions\CreateBesoins;
use BackEnd\application\actions\GetBesoinsByClient;
use BackEnd\application\actions\HomeAction;
use BackEnd\application\actions\UpdateBesoin;
use BackEnd\middlewares\CorsMiddleware;

return function(\Slim\App $app): \Slim\App {
    $app->add(CorsMiddleware::class);

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->post('/besoins', CreateBesoins::class)->setName('createBesoins');
    $app->get('/besoins', GetBesoinsByClient::class)->setName('getBesoinsByClient');
    $app->patch('/besoins/{id}', UpdateBesoin::class)->setName('updateBesoin');
    return $app;
};
