<?php

namespace BackEnd\application\actions;

use BackEnd\application\actions\AbstractAction;
use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceCompetence;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCompetence extends AbstractAction
{
    private ServiceCompetence $serviceCompetence;

    public function __construct(ServiceCompetence $serviceCompetence) {
        $this->serviceCompetence = $serviceCompetence;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $body = $rq->getParsedBody();
        $this->serviceCompetence->createCompetence($body);

        return JsonRenderer::render($rs, 201);
    }
}