<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'title', 'body', 'image' ,'address'
    ]; //上書き可能なカラムの決まり文句


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
