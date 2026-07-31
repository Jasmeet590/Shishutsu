<?php

namespace Tests\Feature;

use App\Models\Party;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PartyAccessControlTest extends TestCase
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

    public function test_other_user_cannot_update_another_users_party()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
            'user_id' => $owner->id,
            'party_type' => 'client',
            'full_name' => 'Alice',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Alice',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        $response = $this->actingAs($otherUser)->put('/update-party', [
            'party_id' => $party->id,
            'party_type' => 'vendor',
            'full_name' => 'Hacked',
            'phone_no' => '1234567890',
            'address' => 'Updated address',
            'account_holder_name' => 'Hacked',
            'account_no' => '9999999999',
            'bank_name' => 'Changed Bank',
            'ifsc_code' => 'CHANGED1',
            'branch_address' => 'Changed Branch',
        ]);

        $response->assertNotFound();
        $this->assertDatabaseHas('parties', ['id' => $party->id, 'full_name' => 'Alice']);
    }
}
