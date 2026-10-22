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
        'images_missing_alt',
        'internal_links',
        'external_links',
        'performance_score',
        'ttfb_ms',
        'page_weight_kb',
        'load_time_ms',
        'gzip_enabled',
        'ssl_valid',
        'http_status',
        'reading_time_min',
        'links_data',
        'core_web_vitals',
    ];

    protected $casts = [
        'json_ld' => 'array',
        'h2_tags' => 'array',
        'links_data' => 'array',
        'core_web_vitals' => 'array',
        'gzip_enabled' => 'boolean',
        'ssl_valid' => 'boolean',
        'performance_score' => 'float',
        'ttfb_ms' => 'float',
        'page_weight_kb' => 'float',
        'load_time_ms' => 'float',
    ];

    public function auditLogs(): HasMany
    {
        return $this->hasMany(SeoAuditLog::class);
    }

    public function getSeoScoreAttribute()
    {
        $latest = $this->auditLogs()->latest()->first();
        return $latest ? $latest->score : ($this->performance_score ?? 0);
    }

    /**
     * Get letter grade based on SEO performance score.
     */
    public function getHealthGradeAttribute(): array
    {
        $score = $this->performance_score ?? 0;

        if ($score >= 90) {
            return ['grade' => 'A+', 'color' => 'success', 'badge' => 'Excellent'];
        } elseif ($score >= 80) {
            return ['grade' => 'A', 'color' => 'primary', 'badge' => 'Good'];
        } elseif ($score >= 65) {
            return ['grade' => 'B', 'color' => 'info', 'badge' => 'Moderate'];
        } elseif ($score >= 50) {
            return ['grade' => 'C', 'color' => 'warning', 'badge' => 'Needs Attention'];
        } else {
            return ['grade' => 'F', 'color' => 'danger', 'badge' => 'Critical Issues'];
        }
    }
}
