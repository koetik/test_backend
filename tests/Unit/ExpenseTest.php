<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Expense;

class ExpenseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_expense_test()
    {
        // Arrange
        $data = [
            [
                'amount' => 1,
                'status_id' => 1,
            ],
            [
                'amount' => 2,
                'status_id' => 1,
            ],
            [
                'amount' => 3,
                'status_id' => 1,
            ],
            
        ];
        
        // Act
        foreach($data as $item) {
            $expense = Expense::create($item);

            // Assert
            $this->assertInstanceOf(Expense::class, $expense);
            $this->assertEquals($item['status_id'], $expense->status_id);
            $this->assertEquals($item['amount'], $expense->amount);
        }
    }
}
