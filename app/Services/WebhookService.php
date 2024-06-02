<?php

namespace App\Services;

use App\Repositories\WebhookEloquentORM;

class WebhookService {
    public function __construct(
        protected WebhookEloquentORM $repository
    ) {
    }


}
