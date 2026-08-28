<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasUuidV7;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, HasUuidV7;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($page) {
            if (empty($page->slug) || $page->isDirty('title')) {
                $slug = Str::slug($page->title);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $page->slug = $slug;
            }
        });
    }
}
