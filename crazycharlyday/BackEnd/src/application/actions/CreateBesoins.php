<?php

namespace BackEnd\application\actions;

use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceCompetence;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCompetences
{
    private ServiceCompetence $competenceService;

    public function __construct(ServiceCompetence $competenceService){
        $this->competenceService = $competenceService;
    }

    function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $competences = $this->competenceService->getAllCompetences();

        return JsonRenderer::render($rs, 200, $competences);
    }
}
