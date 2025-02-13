<?php


use BackEnd\application\actions\CreateBesoins;
use BackEnd\application\actions\GetBesoinsByClient;
use BackEnd\application\actions\UpdateBesoin;
use BackEnd\core\services\ServiceBesoins;
use BackEnd\infrastructure\BesoinsRepository;
use Psr\Container\ContainerInterface;

return [

    'pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db;dbname=db', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    BesoinsRepository::class => function(ContainerInterface $c) {
        return new BesoinsRepository($c->get('pdo'));
    },

    ServiceBesoins::class => function(ContainerInterface $c) {
        return new ServiceBesoins($c->get(BesoinsRepository::class));
    },

    CreateBesoins::class => function(ContainerInterface $c) {
        return new CreateBesoins($c->get(ServiceBesoins::class));
    },

    GetBesoinsByClient::class => function(ContainerInterface $c) {
        return new GetBesoinsByClient($c->get(ServiceBesoins::class));
    },

    UpdateBesoin::class => function(ContainerInterface $c) {
        return new UpdateBesoin($c->get(ServiceBesoins::class));
    }

];