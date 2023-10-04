<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['body', 'post_id', 'user_id'];

    // Defining the relationship with users table
    public function tableUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Defining the relationship with posts table
    public function tablePost()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
