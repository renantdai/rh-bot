<?php

namespace App\Services;

class MessageReceiveService {
    public function __construct(
        public string $type
    ) {
    }

    public function validateMessage(array $request) {
        if(isset($request['body']['entry'][0]['changes'][0]['field'])){
            return MessageReceiveService();

        }

        $body = $request;
    }


}
