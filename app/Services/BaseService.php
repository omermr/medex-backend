<?php

namespace App\Services;

use App\Traits\HttpResponse;
use App\Traits\FileUploader;
class BaseService
{
    use HttpResponse, FileUploader;
}

