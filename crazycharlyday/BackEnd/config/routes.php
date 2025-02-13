<?php
declare(strict_types=1);


use BackEnd\application\actions\CreateBesoins;
use BackEnd\application\actions\HomeAction;

return function(\Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->post('/besoins', CreateBesoins::class)->setName('createBesoins');

    return $app;
};
