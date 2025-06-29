<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = ['converted_at'];

    public function click()
    {
        return $this->belongsTo(Click::class);
    }
}
