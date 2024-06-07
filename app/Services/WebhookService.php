<?php

namespace App\Services;

use App\DTO\MessageDTO;
use App\Repositories\WebhookEloquentORM;
use Exception;

class WebhookService {
    public function __construct(
        protected WebhookEloquentORM $repository
    ) {
    }

    public function validateMessage(array $request) {
        if (!isset($request['body']['entry'][0]['changes'][0]['field'])) {
            return throw new Exception('erro no recebimento da mensagem', 500);
        }

        if (isset($request['body']['entry'][0]['changes'][0]['value']['statuses'])) {
            return [
                'status' => $request['body']['entry'][0]['changes'][0]['value']['statuses'][0]['status']
            ];
        }

        if (isset($request['body']['entry'][0]['changes'][0]['value']['messages'])) {
            return [
                'type' => $request['body']['entry'][0]['changes'][0]['value']['messages'][0]['type']
            ];
        }

        return throw new Exception('erro na validacao', 500);
    }

    public function receiveStatusMessage(array $request) {
        return '';
    }

    public function receiveTypeMessage(MessageDTO $dto) {
        return $this->repository->saveMessage($dto->prepareDataBeforeSave());
    }
}
