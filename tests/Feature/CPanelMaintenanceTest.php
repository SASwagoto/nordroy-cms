<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CPanelMaintenanceTest extends TestCase
{
    public function test_cpanel_hub_renders_successfully(): void
    {
        $response = $this->get('/cpanel?key=nordroy');
        $response->assertStatus(200);
        $response->assertSee('cPanel Maintenance Hub');
        $response->assertSee('Clear All Caches');
        $response->assertSee('Storage Link');
    }

    public function test_cpanel_clear_cache_executes_successfully(): void
    {
        $response = $this->get('/cpanel/clear-cache?key=nordroy');
        $response->assertRedirect('/cpanel?key=nordroy');
        $response->assertSessionHas('success');
    }

    public function test_cpanel_clear_cache_json_api(): void
    {
        $response = $this->getJson('/cpanel/clear-cache?key=nordroy');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    public function test_cpanel_storage_link_executes(): void
    {
        $response = $this->get('/cpanel/storage-link?key=nordroy');
        $response->assertRedirect('/cpanel?key=nordroy');
    }

    public function test_cpanel_download_sql_generates_and_downloads(): void
    {
        $response = $this->get('/cpanel/download-sql?key=nordroy');
        $response->assertStatus(200);
        $this->assertEquals('application/sql', $response->headers->get('content-type'));
    }
}
