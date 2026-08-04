<?php

namespace Tests\Feature;

use App\Models\GstBill;
use App\Models\Party;
use App\Models\User;
use Tests\TestCase;

class GstBillUserScopeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_users_only_see_their_own_gst_bills_and_create_with_their_user_id()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
            'user_id' => $owner->id,
            'party_type' => 'client',
            'full_name' => 'Test Party',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Test Party',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        GstBill::create([
            'user_id' => $owner->id,
            'party_id' => $party->id,
            'invoice_date' => '2026-08-01',
            'invoice_number' => 'INV-1-0001',
            'item_description' => 'Test item',
            'total_amount' => 100,
            'tax_amount' => 18,
            'net_amount' => 118,
        ]);

        $response = $this->actingAs($otherUser)->get('/manage-gst-bill');
        $response->assertStatus(200);
        $response->assertDontSee('INV-1-0001');

        $createResponse = $this->actingAs($otherUser)->post('/create-gst-bill', [
            'party_id' => $party->id,
            'invoice_date' => '2026-08-02',
            'item_description' => 'Owned item',
            'total_amount' => 200,
            'tax_amount' => 36,
            'net_amount' => 236,
        ]);

        $createResponse->assertRedirect('/manage-gst-bill');
        $this->assertDatabaseHas('gst_bills', [
            'user_id' => $otherUser->id,
            'item_description' => 'Owned item',
        ]);
    }

    public function test_add_gst_bill_page_only_shows_the_authenticated_users_parties_for_search()
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
            'full_name' => 'Other User Party',
            'phone_no' => '9876543210',
            'address' => '123 Street',
            'account_holder_name' => 'Other User Party',
            'account_no' => '1234567890',
            'bank_name' => 'Test Bank',
            'ifsc_code' => 'TEST1234',
            'branch_address' => 'Main Branch',
        ]);

        $response = $this->actingAs($owner)->get('/add-gst-bill');

        $response->assertStatus(200);
        $response->assertSee('Owner Party');
        $response->assertDontSee('Other User Party');
    }

    public function test_other_user_cannot_access_another_users_gst_bill_via_view_or_delete()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
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

        $bill = GstBill::create([
            'user_id' => $owner->id,
            'party_id' => $party->id,
            'invoice_date' => '2026-08-01',
            'invoice_number' => 'INV-SEC-0001',
            'item_description' => 'Secure item',
            'total_amount' => 100,
            'tax_amount' => 18,
            'net_amount' => 118,
        ]);

        $response = $this->actingAs($otherUser)->get(route('print-gst-bill', ['id' => $bill->id]));
        $response->assertNotFound();

        $deleteResponse = $this->actingAs($otherUser)->get(route('delete', ['gst_bills', 'id' => $bill->id]));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseHas('gst_bills', ['id' => $bill->id, 'is_deleted' => 0]);
    }

    public function test_manage_page_does_not_expose_other_users_bill_data_to_browser_javascript()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
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

        GstBill::create([
            'user_id' => $owner->id,
            'party_id' => $party->id,
            'invoice_date' => '2026-08-01',
            'invoice_number' => 'INV-PRIVATE-0001',
            'item_description' => 'Private item',
            'total_amount' => 100,
            'tax_amount' => 18,
            'net_amount' => 118,
        ]);

        $response = $this->actingAs($otherUser)->get('/manage-gst-bill');

        $response->assertStatus(200);
        $response->assertDontSee('INV-PRIVATE-0001');
        $response->assertDontSee('Private item');
    }

    public function test_gst_bill_creation_requires_valid_party_and_amounts()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/create-gst-bill', [
            'party_id' => 999,
            'invoice_date' => '2026-08-02',
            'item_description' => 'Bad bill',
            'total_amount' => -10,
            'tax_amount' => -1,
            'net_amount' => -11,
        ]);

        $response->assertSessionHasErrors(['party_id', 'total_amount', 'tax_amount', 'net_amount']);
    }

    public function test_invalid_delete_request_does_not_soft_delete_unowned_gst_bill()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $party = Party::create([
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

        $bill = GstBill::create([
            'user_id' => $owner->id,
            'party_id' => $party->id,
            'invoice_date' => '2026-08-01',
            'invoice_number' => 'INV-INVALID-0001',
            'item_description' => 'Protected item',
            'total_amount' => 100,
            'tax_amount' => 18,
            'net_amount' => 118,
        ]);

        $this->actingAs($otherUser)->get(route('delete', ['gst_bills', 'id' => $bill->id]))
            ->assertRedirect();

        $this->assertDatabaseHas('gst_bills', ['id' => $bill->id, 'is_deleted' => 0]);
    }
}
