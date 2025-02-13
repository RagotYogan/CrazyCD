<?php

namespace BackEnd\application\actions;

use BackEnd\application\actions\AbstractAction;
use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceSalaries;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateSalarie extends AbstractAction
{
    private ServiceSalaries $serviceSalaries;

    public function __construct(ServiceSalaries $serviceSalaries) {
        $this->serviceSalaries = $serviceSalaries;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();
        $this->serviceSalaries->createSalarie($data);

        return JsonRenderer::render($rs, 201);
    }
}