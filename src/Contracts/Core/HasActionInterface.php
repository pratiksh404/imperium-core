<?php

namespace Pratiksh\Imperium\Contracts\Core;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface HasActionInterface
{
    public function handleAction(Request $request): JsonResponse;
}
