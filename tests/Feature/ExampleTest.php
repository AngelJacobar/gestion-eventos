<?php

namespace Tests\Feature;

use App\Models\Prueba;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Tests\TestCase;


class ExampleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
            
        $flywayBaselineProcess = new Process(['flyway', '-environment=test', 'baseline']);
        $flywayBaselineProcess->run();

        $flywayMigrateProcess = new Process(['flyway', '-environment=test', 'migrate']);
        $flywayMigrateProcess->run();        
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $flywayCleanProcess = new Process(['flyway', '-environment=test', 'clean']);
        $flywayCleanProcess->run();
    }    
}
