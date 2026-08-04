<?php

namespace Tests\Unit;

use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartyScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_owned_by_scope_returns_only_records_for_the_given_user()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        Party::create([
            'user_id' => $owner->id,
            'party_type' => 'client',
            'full_name' => 'Owner Party',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Owner Party',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        Party::create([
            'user_id' => $otherUser->id,
            'party_type' => 'client',
            'full_name' => 'Other Party',
            'phone_no' => '9876543210',
            'address' => '456 Street',
            'account_holder_name' => 'Other Party',
            'account_no' => '1234567891',
            'bank_name' => 'Other Bank',
            'ifsc_code' => 'OTHR1234',
            'branch_address' => 'Other Branch',
        ]);

        $results = Party::ownedBy($owner->id)->pluck('full_name');

        $this->assertCount(1, $results);
        $this->assertSame(['Owner Party'], $results->all());
    }

    public function test_owned_by_scope_uses_authenticated_user_when_no_user_id_is_passed()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Party::create([
            'user_id' => $user->id,
            'party_type' => 'client',
            'full_name' => 'Authenticated Party',
            'phone_no' => '9876543210',
            'address' => '789 Street',
            'account_holder_name' => 'Authenticated Party',
            'account_no' => '1234567892',
            'bank_name' => 'Auth Bank',
            'ifsc_code' => 'AUTH1234',
            'branch_address' => 'Auth Branch',
        ]);

        $results = Party::ownedBy()->pluck('full_name');

        $this->assertCount(1, $results);
        $this->assertSame(['Authenticated Party'], $results->all());
    }
}
