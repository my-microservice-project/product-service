<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Product API Documentation",
    title: "Product Service",
    contact: new OA\Contact(email: "bugrabozkurtt@gmail.com"),
    license: new OA\License(name: "MIT", url: "https://opensource.org/licenses/MIT")
)]
abstract class Controller
{
    use ResponseTrait;
    //
}
