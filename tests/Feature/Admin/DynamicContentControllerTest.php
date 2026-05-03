<?php

namespace Tests\Feature\Admin;

use App\Models\PageSection;
use App\Models\User;
use App\Support\DynamicContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_dynamic_content_resolves_cms_keys_that_contain_dots(): void
    {
        PageSection::query()->create([
            'page_key' => 'home',
            'section_key' => 'hero',
            'content_json' => [
                'home.hero.title' => [
                    'type' => 'text',
                    'ar' => 'Arabic title',
                    'en' => 'English title',
                ],
                'home.hero.cta' => [
                    'type' => 'button',
                    'ar' => 'Arabic CTA',
                    'en' => 'English CTA',
                    'link' => '/demo',
                ],
            ],
            'style_json' => [
                'home.hero.title' => [
                    'font_size' => '42px',
                ],
            ],
        ]);

        $dynamicContent = app(DynamicContent::class);

        $this->assertSame('English title', $dynamicContent->get('home.hero.home.hero.title.en'));
        $this->assertSame('/demo', $dynamicContent->get('home.hero.home.hero.cta.link'));
        $this->assertSame('42px', $dynamicContent->get('home.hero.style.home.hero.title.font_size'));
    }

    public function test_saved_cms_text_image_and_style_are_available_after_reload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->postJson(route('admin.cms.save'), [
            'page_key' => 'home',
            'changes' => [
                [
                    'section_key' => 'hero',
                    'content_json' => [
                        'home.hero.title' => [
                            'type' => 'text',
                            'ar' => 'Updated Arabic title',
                            'en' => 'Updated English title',
                        ],
                        'home.hero.image_1' => [
                            'type' => 'image',
                            'path' => 'cms/demo-image.jpg',
                            'src' => '/storage/cms/demo-image.jpg',
                        ],
                    ],
                    'style_json' => [
                        'home.hero.title' => [
                            'text_color' => [
                                'light_value' => '#112233',
                                'dark_value' => '#ddeeff',
                            ],
                        ],
                        '__section' => [
                            'background_color' => [
                                'light_value' => '#ffffff',
                                'dark_value' => '#000000',
                            ],
                        ],
                    ],
                ],
                [
                    'section_key' => 'hero-slide-1',
                    'content_json' => [
                        'home.hero.image_1' => [
                            'type' => 'image',
                            'path' => 'cms/slide-image.jpg',
                            'src' => '/storage/cms/slide-image.jpg',
                        ],
                    ],
                ],
            ],
        ])->assertOk()->assertJson(['status' => 'saved']);

        $dynamicContent = app(DynamicContent::class);

        $this->assertSame('Updated English title', $dynamicContent->get('home.hero.home.hero.title.en'));
        $this->assertSame('/storage/cms/demo-image.jpg', $dynamicContent->get('home.hero.home.hero.image_1.src'));
        $this->assertSame('#112233', $dynamicContent->get('home.hero.style.home.hero.title.text_color.light_value'));
        $this->assertSame('#000000', $dynamicContent->page('home')['hero']['style']['__section']['background_color']['dark_value']);
        $this->assertSame('/storage/cms/slide-image.jpg', $dynamicContent->page('home')['hero-slide-1']['content']['home.hero.image_1']['src']);
    }

    public function test_shared_header_content_is_saved_globally_from_any_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->postJson(route('admin.cms.save'), [
            'page_key' => 'products-show',
            'changes' => [[
                'section_key' => 'header',
                'content_json' => [
                    'nav.products' => [
                        'type' => 'text',
                        'ar' => 'Global Arabic Products',
                        'en' => 'Global Products',
                    ],
                ],
            ]],
        ])->assertOk()->assertJson(['status' => 'saved']);

        $this->assertDatabaseHas('page_sections', [
            'page_key' => 'global',
            'section_key' => 'header',
        ]);

        $this->assertDatabaseMissing('page_sections', [
            'page_key' => 'products-show',
            'section_key' => 'header',
        ]);

        $dynamicContent = app(DynamicContent::class);

        $this->assertSame('Global Products', $dynamicContent->page('home')['header']['content']['nav.products']['en']);
        $this->assertSame('Global Products', $dynamicContent->page('products-show')['header']['content']['nav.products']['en']);
    }

    public function test_global_header_overrides_legacy_page_specific_header(): void
    {
        PageSection::query()->create([
            'page_key' => 'global',
            'section_key' => 'header',
            'content_json' => [
                'nav.home' => [
                    'type' => 'text',
                    'en' => 'Global Home',
                ],
            ],
        ]);

        PageSection::query()->create([
            'page_key' => 'products-show',
            'section_key' => 'header',
            'content_json' => [
                'nav.home' => [
                    'type' => 'text',
                    'en' => 'Product Page Home',
                ],
            ],
        ]);

        $dynamicContent = app(DynamicContent::class);

        $this->assertSame('Global Home', $dynamicContent->page('home')['header']['content']['nav.home']['en']);
        $this->assertSame('Global Home', $dynamicContent->page('products-show')['header']['content']['nav.home']['en']);
        $this->assertSame('Global Home', $dynamicContent->get('products-show.header.nav.home.en'));
    }

    public function test_admin_image_upload_returns_domain_relative_storage_url(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $image = UploadedFile::fake()->image('hero.jpg');

        $response = $this->actingAs($admin)->postJson(route('admin.cms.upload-image'), [
            'image' => $image,
        ]);

        $response->assertOk();

        $path = $response->json('path');
        $url = $response->json('url');

        $this->assertStringStartsWith('cms/', $path);
        $this->assertSame('/storage/'.$path, $url);
        Storage::disk('public')->assertExists($path);
    }
}
