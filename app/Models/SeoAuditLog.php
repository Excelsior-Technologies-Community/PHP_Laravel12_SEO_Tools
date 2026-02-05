<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoAuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_page_id',
        'audit_type',
        'audit_data',
        'score',
        'recommendations',
    ];

    protected $casts = [
        'audit_data' => 'array',
    ];

    public function seoPage(): BelongsTo
    {
        return $this->belongsTo(SeoPage::class);
    }
}