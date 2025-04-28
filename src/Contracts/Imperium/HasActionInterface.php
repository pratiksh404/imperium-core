<?php

namespace Pratiksh\Imperium\Contracts\Imperium;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface HasActionInterface
{
    public function handleAction(Request $request): JsonResponse;
}
