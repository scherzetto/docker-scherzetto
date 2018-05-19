<?php

namespace App\Controller;

class AbstractController
{
    public static function create()
    {
        return new self();
    }
}
