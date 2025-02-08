<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseApiResource extends JsonResource
{
    public function __construct($resource, $message = null, $errors = null, $statusCode = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    public function toArray($request)
    {
        return [
            'status' => $this->resource ? 'success' : 'error',
            'message' => $this->message ?? 'Request was successful',
            'data' => $this->resource,
            'errors' => $this->errors,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
