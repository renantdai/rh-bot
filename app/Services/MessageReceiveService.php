<?php

namespace App\Services;

use App\DTO\MessageDTO;

class MessageReceiveService {
    public function __construct(
        public MessageDTO $dto
    ) {
    }

    public function verifyStatus() {
        if ($this->dto->type == 'text') {
            return ['msg' => 'sucesso'];
        }
    }
}
