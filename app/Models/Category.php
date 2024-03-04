<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $appends = [
        'thumbnail',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('small')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    protected function getThumbnailAttribute()
    {
        if (!empty($this->getMedia('images')->first())) {
            return $this->getMedia('images')->first()->getUrl('small');
        }
        return url('assets/no-img.jpg');
    }
}
