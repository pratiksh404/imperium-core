<?php

namespace Pratiksh\Imperium\Services\Resource;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Pratiksh\Imperium\Services\Resource\DataTable\DataTable;
use Pratiksh\Imperium\Services\Resource\Form\Form;
use Pratiksh\Imperium\Services\Resource\Navigation\Navigation;

abstract class Resource
{
    protected User $authUser;

    /**
     * The associated model for this resource.
     *
     * @var string
     */
    public static $model;

    /**
     * The name of the resource (singular or plural as needed).
     *
     * @var string
     */
    public static $name;

    /**
     * The icon of the resource
     *
     * @var string
     */
    public static $icon;

    /**
     * The route of the resource
     *
     * @var string
     */
    public static $route;

    public function __construct()
    {
        $this->authUser = User::find(Auth::user()->id);
    }

    public function get()
    {
        return [
            'name' => static::$name,
            'icon' => static::$icon,
            'model' => static::$model,
            'route' => static::$route,
            'dataTable' => $this->dataTable(),
            'form' => $this->form(),
            'headers' => $this->navigation()->headers,
            'menus' => $this->navigation()->menus,
        ];
    }

    /**
     * Get the base query builder for the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        if (! isset(static::$model) || ! class_exists(static::$model)) {
            throw new \RuntimeException('Resource model is not defined or invalid.');
        }

        return static::$model::query();
    }

    /**
     * Configure the dataTable for the resource.
     */
    abstract public function dataTable(): DataTable;

    /**
     * Configure the dataTable for the resource.
     */
    abstract public function form(): Form;

    /**
     * Configure the navigation for the resource.
     */
    abstract public function navigation(): Navigation;
}
