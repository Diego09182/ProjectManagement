<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
