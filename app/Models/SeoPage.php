<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_url',
        'page_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'json_ld',
        'h1_tag',
        'h2_tags',
        'word_count',
        'image_count',
        'internal_links',
        'external_links',
        'performance_score',
    ];

    protected $casts = [
        'json_ld' => 'array',
        'h2_tags' => 'array',
    ];

    public function auditLogs(): HasMany
    {
        return $this->hasMany(SeoAuditLog::class);
    }

    public function getSeoScoreAttribute()
    {
        $scores = $this->auditLogs()->latest()->first();
        return $scores ? $scores->score : 0;
    }
}