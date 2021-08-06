<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function variations()
    {
        return $this->hasMany('App\Models\Variation');
    }


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('featured_image')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this
                        ->addMediaConversion('medium')
                        ->crop(Manipulations::CROP_CENTER, 960, 480)
                        ->nonOptimized() //for shared hosts
                        ->nonQueued(); //for shared hosts;
                });
        
       
        $this
            ->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('medium')
                    ->crop(Manipulations::CROP_CENTER, 960, 480)
                    ->nonOptimized() //for shared hosts
                    ->nonQueued(); //for shared hosts;
                $this
                    ->addMediaConversion('thumb')
                    ->crop(Manipulations::CROP_CENTER, 240, 240)
                    ->nonOptimized()
                    ->nonQueued();
            });
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
       
        
    //     $this->addMediaConversion('thumb')
    //         ->width(360)
    //         ->height(360);
    //     // ->sharpen(10);

              
    //     $this->addMediaConversion('medium')
    //         ->width(540)
    //         ->height(540);
    //     // ->sharpen(10);

                      
    //     $this->addMediaConversion('large')
    //         ->width(960)
    //         ->height(960);
    //     // ->sharpen(10);
    // }
}
