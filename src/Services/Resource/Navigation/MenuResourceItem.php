<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

use Pratiksh\Imperium\Services\Resource\Resource;

class MenuResourceItem
{
    public Resource $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public static function make(string $resourceClass): array
    {
        $resource = new $resourceClass;
        $instance = new self($resource);

        $navigation = $instance->resource->navigation();

        return $navigation->menus;
    }
}
