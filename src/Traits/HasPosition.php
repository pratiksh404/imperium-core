<?php

namespace Pratiksh\Imperium\Traits;

use Pratiksh\Imperium\Facades\Imperium;

trait HasPosition
{
    public static function bootHasPosition()
    {
        static::created(function ($model) {
            if (! $model->position) {
                $maxOrder = Imperium::position()->where('positionable_type', $model->getMorphClass())
                    ->max('order');

                $model->position()->create([
                    'order' => $maxOrder ? $maxOrder + 1 : 1,
                ]);
            }
        });

        // Optional: Cleanup position when model is deleted
        static::deleted(function ($model) {
            $model->position()->delete();
        });
    }

    // Relationship
    public function position()
    {
        return $this->morphOne((Imperium::position())::class, 'positionable');
    }

    // Helper Function
    public static function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $order => $id) {
            $model = self::findOrFail($id);

            if ($model->position) {
                $model->position->update(['order' => $order + 1]);
            } else {
                $model->position()->create(['order' => $order + 1]);
            }
        }
    }

    public function initializeHasPosition()
    {
        $this->with[] = 'position';
    }

    // Scope
    public function scopeSortByPosition($query)
    {
        return $query->get()->sortBy('position.order')->values();
    }
}
