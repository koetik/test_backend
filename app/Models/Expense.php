<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function approval()
    {
        return $this->hasMany(Approval::class);
    }

    public function setStatus($statusId)
    {
        if($this->approval()->count() == ApprovalStage::count()) {
            $this->status_id = $statusId;
            $this->save();   
        }
    }
}
