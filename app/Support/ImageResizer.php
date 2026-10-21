<?php

namespace App\Support;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Resized JPEG copies of backend uploads (Intervention Image 3).
 */
class ImageResizer
{
    /**
     * Page image: 400px wide, aspect ratio kept.
     *
     * @param  string|\SplFileInfo  $file
     */
    public static function pageImage($file): string
    {
        return self::manager()->read($file)
            ->scale(width: 400)
            ->toJpeg(80)
            ->toString();
    }

    /**
     * Block background: scaled to 1366px wide, then centred on a 1366x768
     * canvas (cropped top and bottom, or padded with white).
     *
     * @param  string|\SplFileInfo  $file
     */
    public static function blockBackground($file): string
    {
        return self::manager()->read($file)
            ->scale(width: 1366)
            ->resizeCanvas(1366, 768, 'ffffff', 'center')
            ->toJpeg(80)
            ->toString();
    }

    private static function manager(): ImageManager
    {
        return new ImageManager(new Driver());
    }
}
