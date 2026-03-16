<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('email', env('SEED_ADMIN_EMAIL', 'admin@aquapos.com'))->first();
        $retailCategory = Category::query()->where('slug', 'retail-pos')->first();
        $restaurantCategory = Category::query()->where('slug', 'restaurant-pos')->first();

        $posts = [
            [
                'type' => 'blog',
                'title' => 'How to Choose the Right POS for Your Store',
                'slug' => 'how-to-choose-the-right-pos-for-your-store',
                'excerpt' => 'A practical framework for selecting a scalable POS solution.',
                'content' => 'Choosing the right POS starts with evaluating transaction speed, inventory depth, integrations, and long-term branch expansion plans.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $retailCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->subDays(10),
                'status' => 'published',
            ],
            [
                'type' => 'blog',
                'title' => 'Inventory Accuracy Playbook for Multi-Branch Retail',
                'slug' => 'inventory-accuracy-playbook-for-multi-branch-retail',
                'excerpt' => 'Reduce stock variance and automate replenishment decisions.',
                'content' => 'Retail teams can dramatically improve inventory accuracy by combining barcode discipline, branch cycle counts, and centralized transfer controls.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $retailCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->subDays(7),
                'status' => 'published',
            ],
            [
                'type' => 'news',
                'title' => 'AQUA POS Launches New Operations Dashboard',
                'slug' => 'aqua-pos-launches-new-operations-dashboard',
                'excerpt' => 'A unified dashboard for KPIs, branch comparisons, and operational alerts.',
                'content' => 'The latest release introduces a cleaner admin experience with consolidated operational cards and request snapshots.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $restaurantCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->subDays(3),
                'status' => 'published',
            ],
            [
                'type' => 'news',
                'title' => 'Upcoming Product Update: Expanded Integrations',
                'slug' => 'upcoming-product-update-expanded-integrations',
                'excerpt' => 'Preview of upcoming financial and logistics integrations.',
                'content' => 'The roadmap includes richer ERP connectors, improved order routing, and stronger reconciliation workflows.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $retailCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->addDays(5),
                'status' => 'draft',
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
