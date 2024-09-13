<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Status;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ExpenseApprovalRequest;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    protected $service;

    public function __construct(ExpenseService $service)
    {
        $this->service = $service;
    }

    /**
    *    @OA\Get(
    *       path="/expenses/{id}",
    *       tags={"Expenses"},
    *       description="Get Expenses By Id",
    *       @OA\Parameter(
    *           description="Parameter expense id",
    *           in="path",
    *           name="id",
    *           required=true,
    *           @OA\Schema(type="string"),
    *           @OA\Examples(example="int", value="1", summary="An int value."),
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={ 
    *               "success": true,
    *               "message": "Data Berhasil diapprove",
    *               "data": {
    *                   {
    *                       "id": "1",
    *                       "amount": "1",
    *                       "status_id": "1",
    *                       "created_at": "2022-01-01T00:00:00.000000Z",    
    *                       "updated_at": "2022-01-01T00:00:00.000000Z",
    *                       "approval": {
    *                           {
    *                               "id": "1",
    *                               "approver_id": "1",
    *                               "status_id": "2",
    *                               "created_at": "2022-01-01T00:00:00.000000Z",
    *                               "updated_at": "2022-01-01T00:00:00.000000Z",
    *                               "approver": {
    *                                   "id": "1",
    *                                   "name": "Admin",
    *                               },
    *                               "status": {
    *                                   "id": "2",
    *                                   "name": "Disetujui"
    *                               }
    *                           }
    *                       }
    *                   }
    *               }
    *          }),
    *      ),
    *  )
    */
    public function show(Request $request, $id)
    {
        try {
            $data = Expense::with(['approval' => function($query) {
                $query->with('approver', 'status');
            }])->find($id);
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    /**
    *    @OA\Post(
    *       path="/expenses",
    *       tags={"Expenses"},
    *       description="Menyimpan data Expenses",
    *       @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="application/x-www-form-urlencoded",
    *               @OA\Schema(
    *                   @OA\Property(
    *                       property="amount",
    *                       type="integer"
    *                   ),
    *                   example={"amount": "1"}
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
    *                   "amount": "1",
    *                   "status_id": "1",
    *                   "created_at": "2022-01-01T00:00:00.000000Z",    
    *                   "updated_at": "2022-01-01T00:00:00.000000Z"
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function store(ExpenseRequest $request)
    {
        try {
            $status = Status::where('name', 'menunggu persetujuan')->first();
            $data = [
                'amount' => $request->amount,
                'status_id' => $status->id,
            ];
            
            $store = Expense::create($data);
            return $this->successResponse($store);

        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    /**
    *    @OA\Patch(
    *       path="/expenses/{id}/approve",
    *       tags={"Expenses"},
    *       description="Expenses Approval",
    *       @OA\Parameter(
    *           description="Parameter expense id",
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
    *                       type="integer"
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
    *               "message": "Data Berhasil diapprove",
    *               "data": {
    *                   {
    *                       "id": "1",
    *                       "amount": "1",
    *                       "status_id": "1",
    *                       "created_at": "2022-01-01T00:00:00.000000Z",    
    *                       "updated_at": "2022-01-01T00:00:00.000000Z",
    *                       "approval": {
    *                           {
    *                               "id": "1",
    *                               "approver_id": "1",
    *                               "status_id": "2",
    *                               "created_at": "2022-01-01T00:00:00.000000Z",
    *                               "updated_at": "2022-01-01T00:00:00.000000Z",
    *                               "approver": {
    *                                   "id": "1",
    *                                   "name": "Admin",
    *                               },
    *                               "status": {
    *                                   "id": "2",
    *                                   "name": "Disetujui"
    *                               }
    *                           }
    *                       }
    *                   }
    *               }
    *          }),
    *      ),
    *  )
    */
    public function update(ExpenseApprovalRequest $request, $id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $status = Status::where('name', 'disetujui')->first();

            $this->service->canApprove($expense, $request->approver_id);
            
            $data = [
                'approver_id' => $request->approver_id,
                'status_id' => $status->id,
            ];
            
            $expense->approval()->create($data);
            $expense->setStatus($status->id);

            $expense = Expense::with(['approval'=>function($query) {
                $query->with(['approver', 'status']);
            }])->find($id);
            return $this->successResponse($expense);

        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
