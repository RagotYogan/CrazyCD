<?php

namespace BackEnd\application\actions;

use BackEnd\application\actions\AbstractAction;
use BackEnd\application\renderer\JsonRenderer;
use BackEnd\core\services\ServiceOpti;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateOptimisation extends AbstractAction
{
    private ServiceOpti $serviceOpti;

    public function __construct(ServiceOpti $serviceOpti) {
        $this->serviceOpti = $serviceOpti;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $uploadedFiles = $rq->getUploadedFiles();
        $file = $uploadedFiles['file'] ?? null;

        if ($file && $file->getError() === UPLOAD_ERR_OK) {
            $filePath = $file->getStream()->getMetadata('uri');
            $result = $this->serviceOpti->createOptimisation($filePath);

            return JsonRenderer::render($rs, 200, $result);
        } else {
            return JsonRenderer::render($rs, 400, ["error" => "Erreur lors du téléchargement du fichier."]);
        }
    }
}
