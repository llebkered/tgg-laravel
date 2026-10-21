<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('large')
                    ->fit(Fit::Crop, 1200, 1200)
                    ->nonOptimized() //for shared hosts
                    ->nonQueued(); //for shared hosts;
                $this
                    ->addMediaConversion('medium')
                    ->fit(Fit::Crop, 480, 480)
                    ->nonOptimized() //for shared hosts
                    ->nonQueued(); //for shared hosts;
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Fit::Crop, 240, 240)
                    ->nonOptimized()
                    ->nonQueued();
            });
    }
}
