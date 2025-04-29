<?php

namespace Pratiksh\Imperium\Contracts\Core;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface HasActionInterface
{
    public function handleAction(Request $request): JsonResponse;
}
