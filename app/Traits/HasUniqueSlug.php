<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    public static function bootHasUniqueSlug()
    {
        static::saving(function ($model) {
            $model->generateSlug();
        });
    }

    protected function generateSlug()
    {
        $slugSource = $this->slugSource ?? 'name';
        $baseSlug = Str::slug($this->{$slugSource});

        $slug = $baseSlug;
        $i = 1;

        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $i++;
        }

        $this->slug = $slug;
    }

    protected function slugExists($slug)
    {
        $query = static::where('slug', $slug);

        if ($this->exists) {
            $query->where('id', '<>', $this->id);
        }

        return $query->exists();
    }
}
