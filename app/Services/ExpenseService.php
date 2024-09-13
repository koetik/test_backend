<?php

namespace App\Services;

use App\Models\ApprovalStage;


class ExpenseService
{
    public function canApprove($expense, $approverId)
    {
        $lastApprover = $expense->approval()->orderBy('approver_id', 'desc')->first();
        $stage = ApprovalStage::first();
        $approvalStage = ApprovalStage::where('approver_id', $approverId)->first();
        
        if(!$lastApprover && $stage->id != $approvalStage->id) {
            throw new \Exception("approver_id cannot be approved", 1);
        }

        if($approverId - $lastApprover->approver_id != 1) {
            throw new \Exception("approver_id cannot be approved", 1);
        }
    }
}