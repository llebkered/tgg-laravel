<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Plant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('featured_image')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this
                    ->addMediaConversion('medium')
                    ->crop(Manipulations::CROP_CENTER, 470, 350)
                    ->nonOptimized() //for shared hosts
                    ->nonQueued(); //for shared hosts;
                });
    }
}
