<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\Approver;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class ApproverTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

     
    public function test_store_approver_test()
    {
        // Arrange
        $data = [
            [
                'name' => 'Ana',
            ],
            [
                'name' => 'Ani',
            ],
            [
                'name' => 'Ina',
            ],
            
        ];

        // Act
        foreach ($data as  $item) {
            $approver = Approver::create($item);

            // Assert
            $this->assertInstanceOf(Approver::class, $approver);
            $this->assertEquals($item['name'], $approver->name);
        }
    }
}
