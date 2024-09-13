<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approver;
use App\Http\Requests\ApproverRequest;

class ApproverController extends Controller
{
    /**
    *    @OA\Post(
    *       path="/approver",
    *       tags={"Approver"},
    *       description="Menyimpan data Approver",
    *       @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="application/x-www-form-urlencoded",
    *               @OA\Schema(
    *                   @OA\Property(
    *                       property="name",
    *                       type="string"
    *                   ),
    *                   example={"name": "Ani"}
    *               )
    *           )
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={ 
    *               "success": true,
    *               "message": "Data Berhasil ditambahkan",
    *               "data": {
    *                   {
    *                   "id": "1",
    *                   "name": "Ani",
    *                   "created_at": "2022-01-01T00:00:00.000000Z",    
    *                   "updated_at": "2022-01-01T00:00:00.000000Z"
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function store(ApproverRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
            ];
            
            $store = Approver::create($data);
            return $this->successResponse($store);

        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
