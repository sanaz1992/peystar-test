<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonyTransferFactor extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'mony_transfer_factors';

    public $timestamps = false;

    /** @var array $fillable */
    protected $fillable = [
        'track_id',
        'amount',
        'description',
        'to_user_id',
        'destination_number',
        'payment_number',
        'reason_description',
        'deposit',
        'from_user_id',
        'inquiry_date',
        'inquiry_time',
        'message',
        'ref_code',
        'source_number',
        'type',
        'status',
        'error'
    ];

    /** @var array $casts */
    protected $casts = [
        'track_id'=>'string',
        'amount'=>'int',
        'description'=>'string',
        'to_user_id'=>'int',
        'destination_number'=>'string',
        'payment_number'=>'int',
        'reason_description'=>'string',
        'deposit'=>'int',
        'from_user_id'=>'int',
        'inquiry_date'=>'int',
        'inquiry_time'=>'int',
        'message'=>'string',
        'ref_code'=>'int',
        'source_number'=>'int',
        'type'=>'string',
        'status'=>'string',
        'error'=>'string'
    ];

}
