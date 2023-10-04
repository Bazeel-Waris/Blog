<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['title', 'body', 'user_id'];

    // Defining the relationship with users table
    public function postOwner()
    {
        return $this->belongsTo(User::class);
    }

    // Defining the relationship with comments table
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
