<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use App\Traits\FileUploader;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HttpResponse, FileUploader;
}
