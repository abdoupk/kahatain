<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // TODO: Implement getPath() method.
    }

    public function getPathForConversions(Media $media): string
    {
        // TODO: Implement getPathForConversions() method.
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        // TODO: Implement getPathForResponsiveImages() method.
    }

    protected function getBasePath(Media $media): string
    {
        return $media->getAttribute('uuid');
    }
}
