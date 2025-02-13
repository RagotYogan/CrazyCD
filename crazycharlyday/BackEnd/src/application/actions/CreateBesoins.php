<?php

namespace BackEnd\application\actions;

use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceBesoins;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateBesoins
{
    private ServiceBesoins $besoinsService;
    public function __construct(ServiceBesoins $besoinsService){
        $this->besoinsService = $besoinsService;
    }
    function __invoke( ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $body = $rq->getBody();
        $data = json_decode($body->getContents(), true);
        $this->besoinsService->createBesoins($data);


        return JsonRenderer::render($rs, 201);
    }

}