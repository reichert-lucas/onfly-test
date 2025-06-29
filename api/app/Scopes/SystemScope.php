<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SystemScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $systemId = Auth::user()?->system_id;

        if (!$systemId) return;

        $builder->where($model->getTable() . '.system_id', Auth::user()->system_id);
    }
}
