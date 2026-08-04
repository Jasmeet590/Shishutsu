<?php

namespace Tests\Feature;

use App\Models\Party;
use App\Models\User;
use Tests\TestCase;

class PartyAccessControlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
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

    public function test_other_user_cannot_view_or_delete_another_users_party()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
            'user_id' => $owner->id,
            'party_type' => 'client',
            'full_name' => 'Secure Party',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Secure Party',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        $this->actingAs($otherUser)
            ->get('/manage-parties')
            ->assertStatus(200)
            ->assertDontSee('Secure Party');

        $this->actingAs($otherUser)
            ->get('/edit-party/' . $party->id)
            ->assertNotFound();

        $response = $this->actingAs($otherUser)->get(route('delete', ['parties', 'id' => $party->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('parties', ['id' => $party->id, 'is_deleted' => 0]);
    }

    public function test_owner_can_view_and_update_their_own_party()
    {
        $owner = User::factory()->create();

        $party = Party::create([
            'user_id' => $owner->id,
            'party_type' => 'client',
            'full_name' => 'Owned Party',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Owned Party',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        $this->actingAs($owner)
            ->get('/edit-party/' . $party->id)
            ->assertStatus(200)
            ->assertSee('Owned Party');

        $response = $this->actingAs($owner)->put('/update-party', [
            'party_id' => $party->id,
            'party_type' => 'client',
            'full_name' => 'Updated Party',
            'phone_no' => '9876543210',
            'address' => 'Updated address',
            'account_holder_name' => 'Updated Party',
            'account_no' => '9876543210',
            'bank_name' => 'Updated Bank',
            'ifsc_code' => 'UPDT1234',
            'branch_address' => 'Updated Branch',
        ]);

        $response->assertRedirect('/manage-parties');
        $this->assertDatabaseHas('parties', ['id' => $party->id, 'full_name' => 'Updated Party']);
    }
}
