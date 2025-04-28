<?php

namespace Pratiksh\Imperium\Repositories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Pratiksh\Imperium\Contracts\ResourcefulInterface;

class ResourcefulRepository implements ResourcefulInterface
{
    protected $model;

    protected $name;

    public function __construct($model)
    {
        $this->model = $model;
        $this->name = strtolower(class_basename($model));
    }

    public function index()
    {
        $user = Auth::user();
        $model = $this->model::all()->map(function ($item) use ($user) {
            $item->can = [
                'view' => $user->can('view', $item),
                'update' => $user->can('update', $item),
                'delete' => $user->can('delete', $item),
                'restore' => $user->can('restore', $item),
                'forceDelete' => $user->can('forceDelete', $item),
            ];

            return $item;
        });
        $trashed_model = $this->model::onlyTrashed()->get()->map(function ($item) use ($user) {
            $item->can = [
                'view' => $user->can('view', $item),
                'update' => $user->can('update', $item),
                'delete' => $user->can('delete', $item),
                'restore' => $user->can('restore', $item),
                'forceDelete' => $user->can('forceDelete', $item),
            ];

            return $item;
        });

        return [
            Str::plural($this->name) => $model,
            'trashed_' . Str::plural($this->name) => $trashed_model,
        ];
    }

    public function create()
    {
        return [];
    }

    public function store(FormRequest $request)
    {
        $model = $this->model::create($request->validated());

        return $model;
    }

    public function show(Model $model)
    {
        return [
            strtolower($this->name) => $model,
        ];
    }

    public function edit(Model $model)
    {
        return [
            strtolower($this->name) => $model,
        ];
    }

    public function update(FormRequest $request, Model $model)
    {
        $model = $model->update($request->validated());

        return $model;
    }

    public function destroy(Model $model)
    {
        return $model->delete();
    }
}
