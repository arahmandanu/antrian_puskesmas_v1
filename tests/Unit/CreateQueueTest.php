<?php

namespace Tests\Unit;

use App\Services\Locket\CreateQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Company;
use App\Models\LocketQueue;

class CreateQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_successful_transaction()
    {
        Company::factory()->create(['printer' => 'test_printer']);
        $service = new CreateQueue('poli_test', 'A');
        $result = $service->handle();
        $this->assertNotNull($result);
    }

    public function test_handle_printer_not_installed()
    {
        Company::factory()->create(['printer' => null]);
        $service = new CreateQueue('poli_test', 'A');
        $result = $service->handle();
        $this->assertEquals('Printer belum terpasang', method_exists($result, 'getMessage') ? $result->getMessage() : $result);
    }

    public function test_handle_generate_queue_number_exception()
    {
        Company::factory()->create(['printer' => 'test_printer']);
        $stub = new class('poli_test', 'A') extends CreateQueue {
            public function generateQueueNumber()
            {
                throw new \Exception('Queue error');
            }
        };
        $result = $stub->handle();
        $this->assertStringContainsString('Terjadi kesalahan', method_exists($result, 'getMessage') ? $result->getMessage() : $result);
        $this->assertEquals(0, LocketQueue::count(), 'No queue should be inserted if exception occurs');
    }
}
