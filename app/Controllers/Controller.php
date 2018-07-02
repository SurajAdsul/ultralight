<?php

namespace App\Controllers;

use App\Model\Transformers\ResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return ResponseData::make('Hello world!!', Response::HTTP_OK);
    }
}