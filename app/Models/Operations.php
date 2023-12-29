<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operations extends Model
{
    use HasFactory;
    protected $fillable = ['operation_name','amount','user_id','status'];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
