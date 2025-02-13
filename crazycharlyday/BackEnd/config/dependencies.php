<?php


use BackEnd\application\actions\CreateBesoins;
use BackEnd\application\actions\CreateCompetence;
use BackEnd\application\actions\CreateSalarie;
use BackEnd\application\actions\GetBesoinsByClient;
use BackEnd\application\actions\GetCompetence;
use BackEnd\application\actions\GetSalaries;
use BackEnd\application\actions\UpdateBesoin;
use BackEnd\core\services\ServiceBesoins;
use BackEnd\core\services\ServiceCompetence;
use BackEnd\core\services\ServiceSalaries;
use BackEnd\infrastructure\BesoinsRepository;
use BackEnd\infrastructure\CompetenceRepository;
use BackEnd\infrastructure\SalariesRepository;
use Psr\Container\ContainerInterface;

return [

    'pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db;dbname=db', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    // Repositories
    BesoinsRepository::class => function(ContainerInterface $c) {
        return new BesoinsRepository($c->get('pdo'));
    },

    CompetenceRepository::class => function(ContainerInterface $c) {
        return new CompetenceRepository($c->get('pdo'));
    },

    SalariesRepository::class => function(ContainerInterface $c) {
        return new SalariesRepository($c->get('pdo'));
    },

    // Services
    ServiceCompetence::class => function(ContainerInterface $c) {
        return new ServiceCompetence($c->get(CompetenceRepository::class));
    },

    ServiceBesoins::class => function(ContainerInterface $c) {
        return new ServiceBesoins($c->get(BesoinsRepository::class));
    },

    ServiceSalaries::class => function(ContainerInterface $c) {
        return new ServiceSalaries($c->get(SalariesRepository::class));
    },

    // Actions
    CreateBesoins::class => function(ContainerInterface $c) {
        return new CreateBesoins($c->get(ServiceBesoins::class));
    },

    GetBesoinsByClient::class => function(ContainerInterface $c) {
        return new GetBesoinsByClient($c->get(ServiceBesoins::class));
    },

    UpdateBesoin::class => function(ContainerInterface $c) {
        return new UpdateBesoin($c->get(ServiceBesoins::class));
    },

    GetCompetence::class => function(ContainerInterface $c) {
        return new GetCompetence($c->get(ServiceCompetence::class));
    },

    CreateCompetence::class => function(ContainerInterface $c) {
        return new CreateCompetence($c->get(ServiceCompetence::class));
    },

    GetSalaries::class => function(ContainerInterface $c) {
        return new GetSalaries($c->get(ServiceSalaries::class));
    },

    CreateSalarie::class => function(ContainerInterface $c) {
        return new CreateSalarie($c->get(ServiceSalaries::class));
    }
];