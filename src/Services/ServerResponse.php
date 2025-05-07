<?php

namespace Pratiksh\Imperium\Services;

use Illuminate\Http\JsonResponse;

class ServerResponse
{
    protected bool $success = true;

    protected string $message = 'Success';

    protected ?string $redirect = null;

    protected array $data = [];

    public static function success(string $message = 'Success'): self
    {
        return (new self)->withMessage($message);
    }

    public static function error(string $message = 'Error'): self
    {
        $instance = new self;
        $instance->success = false;
        $instance->message = $message;

        return $instance;
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function redirectTo(string $url): self
    {
        $this->redirect = $url;

        return $this;
    }

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function toResponse(): JsonResponse
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
            'redirect' => $this->redirect,
            'data' => $this->data,
        ]);
    }
}
