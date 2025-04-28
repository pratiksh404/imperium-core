<?php

namespace Pratiksh\Imperium\Traits;

trait HasProfile
{
    public function initializeHasProfile()
    {
        $this->fillable[] = 'data';
        $this->appends[] = 'profile';
        $this->appends[] = 'data';
        $this->casts['data'] = 'array';
    }

    public function getProfileAttribute()
    {
        return $this->data['profile'] ?? null;
    }
}
