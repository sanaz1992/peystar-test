<?php


namespace App\Http\Repositories;


use App\Models\MonyTransferFactor;
use Illuminate\Support\Facades\Request;

class MoneyTransferRepository
{
    public function store(Request $request)
    {
        return MonyTransferFactor::create([
            'track_id' => rand(1000000, 100000000000000000000000000000),
            'amount' => $request->get('amount'),
            'description' => $request->get('description'),
            'to_user_id' => $request->get('toUserId'),
            'destination_number' => $request->get('destinationNumber'),
            'payment_number' => $request->get('paymentNumber'),
            'reason_description' => $request->get('reasonDescription'),
            'deposit' => $request->get('deposit'),
            'from_user_id' => $request->get('fromUserId')
        ]);
    }
}
