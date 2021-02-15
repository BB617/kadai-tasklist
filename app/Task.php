<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
    protected $fillable = ['content'];
    
    public function user()
    {
        return $this->belongsTO(User::class);
    }
}
