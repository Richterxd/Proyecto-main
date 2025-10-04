<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class UserSecurityAnswer extends Model
{
    protected $fillable = [
        'user_cedula',
        'security_question_id',
        'answer_hash'
    ];

    /**
     * Get the user that owns this security answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_cedula', 'persona_cedula');
    }

    /**
     * Get the security question for this answer.
     */
    public function securityQuestion(): BelongsTo
    {
        return $this->belongsTo(SecurityQuestion::class);
    }

    /**
     * Set the answer attribute with hashing.
     */
    public function setAnswerAttribute($value)
    {
        $this->attributes['answer_hash'] = Hash::make(strtolower(trim($value)));
    }

    /**
     * Check if the provided answer matches the stored hash.
     */
    public function checkAnswer($answer): bool
    {
        return Hash::check(strtolower(trim($answer)), $this->answer_hash);
    }
}