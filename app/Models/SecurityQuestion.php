<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityQuestion extends Model
{
    protected $fillable = [
        'question_text',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user security answers for this question.
     */
    public function userSecurityAnswers(): HasMany
    {
        return $this->hasMany(UserSecurityAnswer::class);
    }
}