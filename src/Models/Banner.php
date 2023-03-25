<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends BaseModel
{
    use HasFactory;

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
