<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'user_accounts';

    public $timestamps = false;

    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'account',
        'type'
    ];

    /** @var array $casts */
    protected $casts = [
        'user_id'=>'int',
        'account'=>'string',
        'type'=>'string'
    ];
}
