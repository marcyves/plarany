<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['name', 'sessions', 'session_length', 'school_id', 'year', 'semester', 'rate'];

    protected $withCount = [
        'groups',
    ];
    
    public function groups(): HasMany
    {
        return $this->HasMany(Group::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function getGroups()
    {
        return Group::where(['course_id' => $this->id])->get();
    }

}
