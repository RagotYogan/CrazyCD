<?php

namespace BackEnd\application\actions;

use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceBesoins;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetBesoinsByClient extends AbstractAction
{
    private ServiceBesoins $besoinsService;
    public function __construct(ServiceBesoins $besoinsService){
        $this->besoinsService = $besoinsService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $client = $rq->getBody();
        $client = json_decode($client->getContents(), true)['client'];
        $besoins = $this->besoinsService->getBesoinsByClient($client);

        return JsonRenderer::render($rs, 200, $besoins);
    }
}