<?php

namespace BackEnd\application\actions;

use BackEnd\application\actions\AbstractAction;
use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceBesoins;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateBesoin extends AbstractAction
{
    private ServiceBesoins $serviceBesoins;

    public function __construct(ServiceBesoins $serviceBesoins){
        $this->serviceBesoins = $serviceBesoins;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        $body = $rq->getParsedBody();
        $this->serviceBesoins->updateBesoin($id, $body);

        return JsonRenderer::render($rs, 200);
    }
}