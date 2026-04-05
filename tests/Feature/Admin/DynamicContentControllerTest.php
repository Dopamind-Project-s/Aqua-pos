<?php

namespace Tests\Feature\Admin;

use App\Models\PageSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicContentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_dynamic_content(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson(route('admin.cms.save'), [
            'page_key' => 'home',
            'changes' => [
                [
                    'section_key' => 'hero',
                    'content_json' => [
                        'home.hero.title' => [
                            'type' => 'text',
                            'ar' => 'عنوان عربي',
                            'en' => 'English title',
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertOk()->assertJson(['status' => 'saved']);

        $this->assertDatabaseHas('page_sections', [
            'page_key' => 'home',
            'section_key' => 'hero',
        ]);

        $this->assertSame('English title', PageSection::first()->content_json['home.hero.title']['en']);
    }
}
