<?php

namespace App\Traits;

use App\Http\Controllers\api\v1\ApiController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

trait RestfulTrait
{
    /**
     * this function will determine the api response structure to make all responses has the same structure
     *
     * @param  null  $data
     * @param  int  $code
     * @param  null  $message
     * @param  null  $paginate
     * @return Application|ResponseFactory|Response
     */
    public function apiResponse($data = null, $code = 200, $message = null, $paginate = null)
    {
        $arrayResponse = [
            'data' => $data,
            'status' => $code == 200 || $code == 201 || $code == 204 || $code == 205,
            'message' => $message,
            'code' => $code,
            'paginate' => $paginate,
        ];

        return response($arrayResponse, $code);
    }

    /**
     * to handle validations
     *
     * @param $request
     * @param $array
     * @return array|Application|ResponseFactory|Response
     */
    public function apiValidation($request, $array)
    {
        $validator = Validator::make($request->all(), $array);
        if ($validator->fails()) {
            $msg = [
                'text' => 'the given data is invalid',
                'errors' => $validator->errors(),
            ];

            return $this->apiResponse(null, ApiController::STATUS_VALIDATION, $msg);
        }

        return $validator->valid();
    }

    /**
     * standard for pagination
     *
     * @param $data
     * @return array
     */
    public function formatPaginateData($data)
    {
        $paginated_arr = $data->toArray();

        return $paginateData = [
            'currentPage' => $paginated_arr['current_page'],
            'from' => $paginated_arr['from'],
            'to' => $paginated_arr['to'],
            'total' => $paginated_arr['total'],
            'per_page' => $paginated_arr['per_page'],
        ];
    }
}
