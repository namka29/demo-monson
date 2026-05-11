<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait GeneratesSlug
{
    abstract protected function slugSourceColumn(): string;

    protected static function bootGeneratesSlug(): void
    {
        static::saving(function (Model $model): void {
            if (! $model instanceof static) {
                return;
            }

            $key = $model->slugSourceColumn();
            $source = (string) ($model->{$key} ?? '');
            $base = Str::slug($source);

            if ($base === '') {
                return;
            }

            if (filled($model->slug)) {
                return;
            }

            $model->slug = static::uniqueSlug($model, $base);
        });
    }

    protected static function uniqueSlug(Model $model, string $base): string
    {
        $slug = $base;
        $i = 2;

        while (static::slugQuery($model, $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    /**
     * @param  static  $model
     */
    protected static function slugQuery(Model $model, string $slug): \Illuminate\Database\Eloquent\Builder
    {
        $query = static::query()->where('slug', $slug);

        if ($model->exists) {
            $query->whereKeyNot($model->getKey());
        }

        return $query;
    }
}
