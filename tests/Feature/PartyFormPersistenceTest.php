<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PartyFormPersistenceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        Artisan::call('migrate:fresh');
    }

    public function test_failed_party_submission_keeps_form_values()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from('/add-party')->post('/create-party', [
            'party_type' => 'Client',
            'full_name' => 'John Doe',
            'phone_no' => '123',
            'address' => 'Main Street',
            'account_holder_name' => 'John Doe',
            'account_no' => '123456',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'ABCD1234',
            'branch_address' => 'Branch',
            'user_id' => $user->id,
        ]);

        $response->assertRedirect('/add-party');
        $response->assertSessionHasErrors(['phone_no']);

        $viewResponse = $this->actingAs($user)->get('/add-party');
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('value="John Doe"', false);
        $viewResponse->assertSee('value="Main Street"', false);
        $viewResponse->assertSee('value="Branch"', false);
    }
}
