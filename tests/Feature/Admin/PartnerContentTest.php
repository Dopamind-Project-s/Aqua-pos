<?php

namespace Tests\Feature\Admin;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_localized_partner_descriptions(): void
    {
        $admin = User::factory()->admin()->create();
        $partner = Partner::query()->create([
            'name' => 'Original Partner',
            'name_en' => 'Original Partner',
            'slug' => 'original-partner',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.partners.update', $partner), [
            'name_ar' => 'الشريك المحدّث',
            'name_en' => 'Updated Partner',
            'description_ar' => 'وصف عربي قابل للتعديل من لوحة الإدارة.',
            'description_en' => 'An editable English description from the admin panel.',
            'sort_order' => 3,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
            'description_ar' => 'وصف عربي قابل للتعديل من لوحة الإدارة.',
            'description_en' => 'An editable English description from the admin panel.',
        ]);
    }

    public function test_partners_hero_has_badge_and_paragraph_without_heading(): void
    {
        $response = $this->get(route('partners.index'));

        $response
            ->assertOk()
            ->assertSee('Strategic Ecosystem')
            ->assertSee('We collaborate with high-impact brands')
            ->assertDontSee('Enterprise Partnerships That Scale');
    }
}
