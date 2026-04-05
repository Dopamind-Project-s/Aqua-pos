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

    public function test_save_uses_deep_merge_for_nested_payloads(): void
    {
        $admin = User::factory()->admin()->create();
        PageSection::query()->create([
            'page_key' => 'home',
            'section_key' => 'hero',
            'content_json' => [
                'title' => ['type' => 'text', 'ar' => 'قديم', 'en' => 'Old'],
            ],
            'style_json' => [
                'title' => ['text_color' => ['light_value' => '#111111', 'dark_value' => '#ffffff']],
            ],
        ]);

        $this->actingAs($admin)->postJson(route('admin.cms.save'), [
            'page_key' => 'home',
            'changes' => [[
                'section_key' => 'hero',
                'content_json' => [
                    'title' => ['en' => 'New only'],
                ],
                'style_json' => [
                    'title' => ['background_color' => ['light_value' => '#ff0000', 'dark_value' => '#000000']],
                ],
            ]],
        ])->assertOk();

        $section = PageSection::query()->first();
        $this->assertSame('قديم', $section->content_json['title']['ar']);
        $this->assertSame('New only', $section->content_json['title']['en']);
        $this->assertSame('#111111', $section->style_json['title']['text_color']['light_value']);
        $this->assertSame('#ff0000', $section->style_json['title']['background_color']['light_value']);
    }
}
