<?php

namespace App\Repositories;

use App\DTO\MessageDTO;
use App\Models\Message;

class WebhookEloquentORM {
    public function __construct(
        protected Message $model
    ) {
    }

    public function saveMessage(array $values): array {
        $message = $this->model->create($values);

        return $message->toArray();
    }
}
