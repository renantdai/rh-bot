<?php

namespace App\Http\Controllers;

use App\DTO\MessageDTO;
use App\Services\MessageReceiveService;
use App\Services\WebhookService;
use Exception;
use Illuminate\Http\Request;

class WebhookController extends Controller {
    const TOKEN_REGISTER_WHATSAPP = 'renan123';

    public function __construct(
        protected WebhookService $service
    ) {
    }

    public function registerWebhook(Request $request) {
        $data = $request->all();

        $token = $data['query']['hub.verify_token'];

        return ($token == self::TOKEN_REGISTER_WHATSAPP) ? $data : false;
    }

    public function receiveMessage(Request $request) {
        $typeMessage = $this->service->validateMessage($request->all());
        try {
            if (isset($typeMessage['status'])) {
                return $this->service->receiveStatusMessage($request->all());
            }

            if (isset($typeMessage['type'])) {
                $this->service->receiveTypeMessage(MessageDTO::makeFromRequest($request));
            }

            $serviceMessage = new MessageReceiveService(MessageDTO::makeFromRequest($request));

            return $serviceMessage->verifyStatus();
        } catch (Exception $e) {
            return ['error' => 'requisição falhou', 'msg' => $e->getMessage()];
        }
    }
}
