<?php

namespace Pratiksh\Imperium\Contracts\Imperium;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface HasActionInterface
{
    public function handleAction(Request $request): JsonResponse;
}
