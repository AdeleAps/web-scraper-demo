<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'link', 'points', 'deleted_by', 'origin_id', 'origin_date'];

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
