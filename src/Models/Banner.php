<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\BannerFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class Banner extends BaseModel
{
    use HasFactory;

    protected static function newFactory()
    {
        return BannerFactory::new();
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function setImageAttribute($value): void
    {
        $data                          = storeImageWithThumb($value, 'Banner', 'Image');
        $this->attributes['thump']     = $data['thumb'];
        $this->attributes['image']     = $data['path'];
        $this->attributes['mime_type'] = $value->getClientMimeType() ?? 'image/jpeg';
    }

    public function setStoryAttribute($value): void
    {
        $data                          = storeFile($value, 'Stories', 'Story');
        $this->attributes['story']     = $data;
        $this->attributes['mime_type'] = $value->getClientMimeType() ?? 'video/mp4';
    }
}
