<?php

namespace App\Http\Providers\Transfer;

use App\Http\Traits\ResponseTrait;

abstract class TransferProvider
{

    use ResponseTrait;

    public abstract function transferToUser(int $trackId, int $amount, string $description, string $destinationFirstname, string $destinationLastname, string $destinationNumber, int $paymentNumber, string $reasonDescription, int $deposit, string $sourceFirstName, string $sourceLastName, int $secondPassword);

}
