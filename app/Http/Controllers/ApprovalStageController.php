<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovalStage;
use App\Http\Requests\ApprovalStageRequest;

class ApprovalStageController extends Controller
{
    /**
    *    @OA\Post(
    *       path="/approval-stages",
    *       tags={"Approval Stage"},
    *       description="Menyimpan data Approval Stage",
    *       @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="application/x-www-form-urlencoded",
    *               @OA\Schema(
    *                   @OA\Property(
    *                       property="approver_id",
    *                       type="string"
    *                   ),
    *                   example={"approver_id": "1"}
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
    *                   "approver_id": "1",
    *                   "created_at": "2022-01-01T00:00:00.000000Z",    
    *                   "updated_at": "2022-01-01T00:00:00.000000Z"
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function store(ApprovalStageRequest $request)
    {
        try {
            $data = [
                'approver_id' => $request->approver_id,
            ];
            
            $store = ApprovalStage::create($data);
            return $this->successResponse($store);

        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    /**
    *    @OA\Put(
    *       path="/approval-stages/{id}",
    *       tags={"Approval Stage"},
    *       description="Mengubah data Approval Stage",
    *       @OA\Parameter(
    *           description="Parameter approval id",
    *           in="path",
    *           name="id",
    *           required=true,
    *           @OA\Schema(type="string"),
    *           @OA\Examples(example="int", value="1", summary="An int value."),
    *       ),
    *       @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="application/x-www-form-urlencoded",
    *               @OA\Schema(
    *                   @OA\Property(
    *                       property="approver_id",
    *                       type="string"
    *                   ),
    *                   example={"approver_id": "2"}
    *               )
    *           )
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={ 
    *               "success": true,
    *               "message": "Data Berhasil diubah",
    *               "data": {
    *                   {
    *                   "id": "1",
    *                   "approver_id": "2",
    *                   "created_at": "2022-01-01T00:00:00.000000Z",    
    *                   "updated_at": "2022-01-01T00:00:00.000000Z"
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function update(ApprovalStageRequest $request, ApprovalStage $approvalStages)
    {
        try {
            $data = [
                'approver_id' => $request->approver_id,
            ];
            
            $approvalStages->fill($data)->save();
            return $this->successResponse($approvalStages, "Data Berhasil diubah");

        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
