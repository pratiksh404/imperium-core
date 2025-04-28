<?php

namespace Pratiksh\Imperium\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

interface ResourcefulInterface
{
    public function index();

    public function create();

    public function store(FormRequest $request);

    public function show(Model $module);

    public function edit(Model $module);

    public function update(FormRequest $request, Model $module);

    public function destroy(Model $module);
}
