<?php

namespace App\Core;

use App\Core\DB;

class DBAlt extends DB
{
    public function __construct()
    {
        parent::__construct(config('database.alt'));
    }
}
