<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

trait ResponseTrait
{

    public function defineResponseCodes()
    {

        if (defined('Response_Success') === true) {
            return;
        }

        // ======= HTTP Status Codes ======= \\

        define('Status_200_OK', 200);
        define('Status_400_Bad_Request', 400);
        define('Status_403_Forbidden', 403);
        define('Status_404_Not_Found', 404);
        define('Status_500_Internal_Server_Error', 500);

        // ======= Shared Response Codes ======= \\

        define('Response_Success', [
            'status' => Status_200_OK,
            'error' => false,
            'code' => 'success',
        ]);
        define('Response_Error', [
            'status' => Status_400_Bad_Request,
            'error' => true,
            'code' => 'error',
        ]);
        define('Response_Exception', [
            'status' => Status_500_Internal_Server_Error,
            'error' => true,
            'code' => 'exception',
        ]);
        define('Response_Unauthorized_Access', [
            'status' => Status_403_Forbidden,
            'error' => true,
            'code' => 'unauthorized_access',
        ]);
        define('Response_Validation_Error', [
            'status' => Status_400_Bad_Request,
            'error' => true,
            'code' => 'validation_error',
        ]);

        define('Response_Transfer_Success', [
            'status' => Status_200_OK,
            'error' => true,
            'code' => 'transfer_success',
        ]);
        define('Response_Transfer_Error', [
            'status' => Status_400_Bad_Request,
            'error' => true,
            'code' => 'transfer_error',
        ]);

    }

    /**
     * @param array $type
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function response(array $type, string $message = '', array $data = [])
    {
        // Return Response In JSON Format
        return new JsonResponse([
            'status' => $type['status'],
            'error' => $type['error'],
            'code' => $type['code'],
            'message' => trim($message) !== '' ? trim($message) : trim(Lang::get('response.' . $type['code'])),
            'data' => $data
        ], $type['status']);
    }

    /**
     * @param array $serviceResponse
     * @return JsonResponse
     */
    public function responseFromServiceResponse(array $serviceResponse)
    {
        return $this->response(
            [
                'status' => intval($serviceResponse['status']),
                'error' => boolval($serviceResponse['error']),
                'code' => trim($serviceResponse['code']),
            ],
            trim($serviceResponse['message']),
            $serviceResponse['data']
        );
    }

}
