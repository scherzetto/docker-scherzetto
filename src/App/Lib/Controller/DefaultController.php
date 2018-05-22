<?php

namespace App\Lib\Controller;

class DefaultController extends AbstractController
{
    public function notFoundAction()
    {
        return $this->returnResponse('Not Found', 404);
    }
}
