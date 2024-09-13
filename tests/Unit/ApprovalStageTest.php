<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\ApprovalStage;
use App\Models\Approver;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class ApprovalStageTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_approval_stage_test()
    {
        // Arrange
        $data = [
            [
                'approver_id' => 1,
            ],
            [
                'approver_id' => 2,
            ],
            [
                'approver_id' => 3,
            ],
        ];

        // Act
         // Act
         foreach ($data as  $item) {
            $approvalStage = ApprovalStage::create($item);

            // Assert
            $this->assertInstanceOf(ApprovalStage::class, $approvalStage);
            $this->assertEquals($item['approver_id'], $approvalStage->approver_id);
        }
    }

    public function test_put_approval_stage_test()
    {
        // Arrange
        $approvalStage = ApprovalStage::first();

        $data = [
            'approver_id' => 1,
        ];

        // Act
        $approvalStage->fill($data)->save();

        // Assert
        $this->assertInstanceOf(ApprovalStage::class, $approvalStage);
        $this->assertEquals($data['approver_id'], $approvalStage->approver_id);
    }
}
