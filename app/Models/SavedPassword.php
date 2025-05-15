<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPassword extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'platform',
    'account_identifier',
    'password',
    'purpose',
    'strength'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 

}
