<?php

namespace SahamLibs\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait Translatable
{
    private $dir;
    private $langs;

    protected function initializeTranslatable(): void
    {
        $this->dir   = App::langPath();
        $this->langs = array_diff(scandir($this->dir), ['..', '.']);

        if (!empty($this->translatable) && is_array($this->translatable)) {
            $this->appends = array_unique(array_merge($this->appends, $this->translatable));
        }
    }

    protected function mutateAttribute($key, $value): mixed
    {
        if (is_array($this->translatable) && !in_array($key, $this->translatable, true)) {
            $value = parent::mutateAttribute($key, $value);
        } elseif (method_exists($this, 'get' . Str::studly($key) . 'Attribute')) {
            $value = parent::mutateAttribute($key, $value);
        }

        return $this->applyAccessors($key, $value);
    }

    protected function applyAccessors($key, $value): mixed
    {
        return parent::getAttributeValue($key . '_' . App::getLocale());
    }

    // public function getAttribute($key)
    // {
    //     if (!empty($this->translatable) && in_array($key, $this->translatable)) {
    //         return parent::getAttributeValue($key . '_' . app()->getLocale());
    //     }

    //     return  parent::getAttributeValue($key);
    // }
}
