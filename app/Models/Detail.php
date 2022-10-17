<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'phone',
        'email',
        'dob',
        'companyName',
        'position',
        'address',
    ];
}
