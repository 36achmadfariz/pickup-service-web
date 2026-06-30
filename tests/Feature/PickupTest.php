<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pickup;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class PickupTest extends TestCase
{
    // ─── SEEDER ───────────────────────────────────────────────
    protected function setUp(): void
    {
        parent::setUp();
        // Pastikan user test exist
        if (!User::where('email', 'admin@pickup.com')->exists()) {
            User::create([
                'name' => 'Admin Pickup',
                'email' => 'admin@pickup.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }
        if (!User::where('email', 'kurir@pickup.com')->exists()) {
            User::create([
                'name' => 'Kurir Satu',
                'email' => 'kurir@pickup.com',
                'password' => Hash::make('kurir123'),
                'role' => 'kurir',
            ]);
        }
    }

    // ═══════════════════════════════════════════════════════════
    //  LANDING PAGE
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function landing_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Kirim Paket dari Rumah');
        $response->assertSee('Gratis, Kami Jemput');
    }

    // ═══════════════════════════════════════════════════════════
    //  PICKUP STORE — SUCCESS & VALIDATION
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function store_pickup_success()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $response = $this->post('/pickup', [
            'nama' => 'Achmad Fariz',
            'email' => 'fariz@test.com',
            'nomor_kontak' => '08990752617',
            'alamat_pickup' => 'Jl. Merdeka No.1',
            'alamat_tujuan' => 'Jl. Sudirman No.2',
            'deskripsi_barang' => 'Buku dan dokumen',
            'g-recaptcha-response' => 'fake-token',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pickups', [
            'nama' => 'Achmad Fariz',
            'email' => 'fariz@test.com',
            'status' => 'menunggu',
        ]);
    }

    /** @test */
    public function store_pickup_validation_error()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $response = $this->post('/pickup', [
            'nama' => '',
            'email' => '',
            'nomor_kontak' => '',
            'alamat_pickup' => '',
            'alamat_tujuan' => '',
            'deskripsi_barang' => '',
            'g-recaptcha-response' => 'fake-token',
        ]);

        $response->assertSessionHasErrors(['nama', 'email', 'nomor_kontak', 'alamat_pickup', 'alamat_tujuan', 'deskripsi_barang']);
    }

    // ═══════════════════════════════════════════════════════════
    //  LAYER 1: HONEYPOT
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function honeypot_rejects_bot()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $response = $this->post('/pickup', [
            'nama' => 'Bot Spam',
            'email' => 'spam@bot.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Nowhere',
            'alamat_tujuan' => 'Somewhere',
            'deskripsi_barang' => 'SPAM',
            'website' => 'http://spam.com',  // honeypot field
            'g-recaptcha-response' => 'fake-token',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('pickups', ['nama' => 'Bot Spam']);
    }

    // ═══════════════════════════════════════════════════════════
    //  LAYER 2: EMAIL BLACKLIST
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function email_blacklist_rejects_disposable()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $response = $this->post('/pickup', [
            'nama' => 'Test',
            'email' => 'spammer@mailinator.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'g-recaptcha-response' => 'fake-token',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('pickups', ['email' => 'spammer@mailinator.com']);
    }

    // ═══════════════════════════════════════════════════════════
    //  LAYER 3: reCAPTCHA v3
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function recaptcha_rejects_low_score()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.1], 200),
        ]);

        $response = $this->post('/pickup', [
            'nama' => 'Test',
            'email' => 'test@test.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'g-recaptcha-response' => 'fake-token',
        ]);

        $response->assertSessionHasErrors(['recaptcha']);
    }

    // ═══════════════════════════════════════════════════════════
    //  LAYER 4: RATE LIMIT
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function rate_limit_blocks_after_5_requests()
    {
        Http::fake([
            'google.com/recaptcha/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $payload = [
            'nama' => 'Test',
            'email' => 'test@test.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'g-recaptcha-response' => 'fake-token',
        ];

        // 5 requests — should pass
        for ($i = 0; $i < 5; $i++) {
            $this->post('/pickup', $payload);
        }

        // 6th — should be throttled
        $response = $this->post('/pickup', $payload);
        $response->assertStatus(429);
    }

    // ═══════════════════════════════════════════════════════════
    //  AUTH
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function admin_cannot_access_dashboard_without_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_login()
    {
        $response = $this->post('/login', [
            'email' => 'admin@pickup.com',
            'password' => 'admin123',
        ]);
        $response->assertRedirect('/admin/dashboard');
    }

    /** @test */
    public function admin_can_see_dashboard()
    {
        $admin = User::where('email', 'admin@pickup.com')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
    }

    // ═══════════════════════════════════════════════════════════
    //  ADMIN: SEARCH
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function admin_can_search_pickups()
    {
        $admin = User::where('email', 'admin@pickup.com')->first();

        $response = $this->actingAs($admin)->get('/admin/search?q=test');
        $response->assertStatus(200);
    }

    // ═══════════════════════════════════════════════════════════
    //  ADMIN: ASSIGN KURIR
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function admin_can_assign_kurir()
    {
        $admin = User::where('email', 'admin@pickup.com')->first();
        $kurir = User::where('email', 'kurir@pickup.com')->first();

        // Buat pickup
        $pickup = Pickup::create([
            'nama' => 'Customer',
            'email' => 'customer@test.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->post('/admin/assign', [
            'pickup_id' => $pickup->id,
            'kurir_id' => $kurir->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pickups', [
            'id' => $pickup->id,
            'assigned_to' => $kurir->id,
            'status' => 'diproses',
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    //  ADMIN: DELETE PICKUP
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function admin_can_delete_pickup()
    {
        $admin = User::where('email', 'admin@pickup.com')->first();

        $pickup = Pickup::create([
            'nama' => 'Delete Me',
            'email' => 'delete@test.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->delete('/admin/pickup/' . $pickup->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('pickups', ['id' => $pickup->id]);
    }

    // ═══════════════════════════════════════════════════════════
    //  KURIR DASHBOARD
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function kurir_can_see_dashboard()
    {
        $kurir = User::where('email', 'kurir@pickup.com')->first();

        $response = $this->actingAs($kurir)->get('/kurir/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function kurir_can_update_pickup_status()
    {
        $kurir = User::where('email', 'kurir@pickup.com')->first();

        $pickup = Pickup::create([
            'nama' => 'Customer',
            'email' => 'customer2@test.com',
            'nomor_kontak' => '08111111',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'status' => 'diproses',
            'assigned_to' => $kurir->id,
        ]);

        $response = $this->actingAs($kurir)->post('/kurir/pickup/' . $pickup->id . '/status', [
            'pickup_id' => $pickup->id,
            'status' => 'dalam_perjalanan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pickups', [
            'id' => $pickup->id,
            'status' => 'dalam_perjalanan',
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    //  CANCEL PICKUP
    // ═══════════════════════════════════════════════════════════

    /** @test */
    public function customer_can_cancel_pickup()
    {
        $pickup = Pickup::create([
            'nama' => 'Cancel Test',
            'email' => 'cancel@test.com',
            'nomor_kontak' => '08123456789',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'status' => 'menunggu',
        ]);

        $response = $this->delete('/pickup/cancel/' . $pickup->id, [
            'nama' => 'Cancel Test',
            'nomor_kontak' => '08123456789',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('pickups', ['id' => $pickup->id]);
    }

    /** @test */
    public function cancel_fails_with_wrong_name()
    {
        $pickup = Pickup::create([
            'nama' => 'Real Name',
            'email' => 'real@test.com',
            'nomor_kontak' => '08123456789',
            'alamat_pickup' => 'Alamat A',
            'alamat_tujuan' => 'Alamat B',
            'deskripsi_barang' => 'Barang',
            'status' => 'menunggu',
        ]);

        $response = $this->delete('/pickup/cancel/' . $pickup->id, [
            'nama' => 'Wrong Name',
            'nomor_kontak' => '08123456789',
        ]);

        $response->assertSessionHasErrors(['nama']);
        $this->assertDatabaseHas('pickups', ['id' => $pickup->id]);
    }
}
