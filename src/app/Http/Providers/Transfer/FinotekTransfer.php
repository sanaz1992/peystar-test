<?php

namespace App\Http\Providers\Transfer;


use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use SoapClient;
use SoapFault;

class FinotekTransfer extends TransferProvider
{

    /** @var array $config */
    private $config;

    /** @var SoapClient $soapClient */
    private $soapClient;

    /**
     * @throws SoapFault
     */
    public function __construct()
    {
        // Get Faraz SMS Config From Tourgram Config
        /** @var array $config */
        $this->config = Config::get('transfer.providers.finotek');
        // Create A SOAP Client For Finotek Service
        $this->soapClient = new SoapClient();
    }

    public function transferToUser(int $trackId, int $amount, string $description, string $destinationFirstname, string $destinationLastname, string $destinationNumber, int $paymentNumber, string $reasonDescription, int $deposit, string $sourceFirstName, string $sourceLastName, int $secondPassword)
    {
        try {
            // Transfer Money For User
            /** @var int|array $trackingCode */
            $trackingCode = $this->transfer(
                'transferTo',
                $trackId,
                $amount,
                $description,
                $destinationFirstname,
                $destinationLastname,
                $destinationNumber,
                $paymentNumber,
                $reasonDescription,
                $deposit,
                $sourceFirstName,
                $sourceLastName,
                $secondPassword
            );
            // If Any Error , Return "Transfer Error" Response With Error Message
            if (is_array($trackingCode) === true) {
                return $this->response(Response_Transfer_Error, $trackingCode[1]);
            }
            // Return "Transfer Success" Response
            return $this->response(Response_Transfer_Success);
        } catch (Exception $exception) {
            // If Any Exception , Return "Transfer Error" Response With Exception Message
            return $this->response(Response_Transfer_Error, $exception->getMessage());
        }
    }

    public function transfer(string $type, int $trackId, int $amount, string $description, string $destinationFirstname, string $destinationLastname, string $destinationNumber, int $paymentNumber, string $reasonDescription, int $deposit, string $sourceFirstName, string $sourceLastName, int $secondPassword)
    {
        //Complete Url
        /** @var string $url */
        $url = $this->config['url'] . '/' . $this->config['clientId'] . '/' . $type;
        //Create Request
        /** @var Request $request */
        $request = new Request('POST', $url);
        // Send Data For Finotek Service
        /** @var string $response */
        $response = $this->soapClient->send($request, [
            'trackId'=>$trackId,
            'amount'=>$amount,
            'description'=>$description,
            'destinationFirstname'=> $destinationFirstname,
            'destinationLastname'=> $destinationLastname,
            'destinationNumber'=> $destinationNumber,
            'paymentNumber'=> $paymentNumber,
            'reasonDescription'=> $reasonDescription,
            'deposit'=> $deposit,
            'sourceFirstName'=> $sourceFirstName,
            'sourceLastName'=> $sourceLastName,
            'secondPassword'=> $secondPassword
        ]);
        // Return Response
        return json_decode($response, true, 512, JSON_OBJECT_AS_ARRAY | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
