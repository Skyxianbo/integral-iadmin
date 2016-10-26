<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Error
 */
class ErrorController extends Controller
{
    public function notFoundAction()
    {
        exit('404 NotFound');
    }
}
