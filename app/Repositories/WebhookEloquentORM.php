<?php

namespace App\Repositories;

use App\Models\Funcionario;

class WebhookEloquentORM {
    public function __construct(
        protected Funcionario $model
    ) {
    }
}
