<?php

namespace App\Core;

use App\Core\DB;

abstract class Model
{
    protected $db;
    private $table;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
}
