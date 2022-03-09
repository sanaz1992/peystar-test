<?php

namespace App\Http\Controllers;

use App\Http\Providers\Transfer\FinotekTransfer;
use App\Http\Providers\Transfer\TransferProvider;
use App\Http\Repositories\MoneyTransferRepository;
use App\Http\TourgramProviders\SMS\FarazSMS;
use App\Http\TourgramProviders\SMS\SMSProvider;
use App\Models\MonyTransferFactor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function transfer(Request $request, MoneyTransferRepository $moneyTransferRepository)
    {
        try {
            // Validate Request Parameters
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Validator::make($request->all(), [
                'fromUserId' => 'required|integer',
                'toUserId' => 'required|integer',
                'amount' => 'required|integer',
                'description' => 'nullable|string',
                'userAccountId' => 'required|integer',
                'destinationNumber' => 'required|string|regex:/^IR[0-9]{20}|[0-9]*$/',
                'deposit' => 'required|integer',
                'reasonDescription' => 'nullable|string',
                'secondPassword' => 'required|integer'
            ]);
            // If Request Validation Failed , Return "Validation Error" Response
            if ($validator->fails() === true) {
                return $this->response(Response_Validation_Error, '', $this->formatValidationErrors($validator));
            }

            //Store Data In DB
            /** @var MonyTransferFactor $monyTransferFactor */
            $monyTransferFactor = $moneyTransferRepository->store($request);

            // Get Transfer Config From Transfer Config
            /** @var array $transferConfig */
            $transferConfig = Config::get('transfer');

            // Get Current Provider Name From Transfer Config
            /** @var string $currentProviderName */
            $currentProviderName = $transferConfig['current_provider'];
            // Get Current Provider Config From Transfer Config
            /** @var array $currentProviderConfig */
            $currentProviderConfig = $transferConfig['providers'][$currentProviderName];
            // Create Current Provider Class Instance
            /** @var TransferProvider $currentProvider */
            $currentProvider = new $currentProviderConfig['class']();

            //Get To User Detail
            /** @var User $toUser */
            $toUser = User::find($request->get('toUserId'));
            //Get To User Detail
            /** @var User $fromUser */
            $fromUser = User::find($request->get('fromUserId'));
            // Call Current Provider Class Transfer Method And Return Response
            return $currentProvider->transferToUser(
                trim($monyTransferFactor->track_id),
                intval($monyTransferFactor->amount),
                trim($monyTransferFactor->description),
                trim($toUser->fname),
                trim($toUser->lname),
                trim($request->get('destinationNumber')),
                intval($monyTransferFactor->id),
                trim($request->get('reasonDescription')),
                intval($request->get('deposit')),
                trim($fromUser->fname),
                trim($fromUser->lname),
                intval($request->get('secondPassword'))
            );

            return $this->response(Response_Success);

        } catch (\SoapFault $soapFault) {
            // If Soap Fault , Return "Transfer To User" Response With Soap Fault Message
            return $this->response(Response_Transfer_Error, $soapFault->getMessage());
        } catch (\Exception $exception) {
            // If Any Exception , Return "Transfer To User" Response With Exception Message
            return $this->response(Response_Transfer_Error, $exception->getMessage());
        }
    }
}
