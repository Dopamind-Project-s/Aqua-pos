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
        $author = User::where('email', 'admin@aquapos.com')->first();
        $retailCategory = Category::where('slug', 'retail-pos')->first();

        $rows = [
            [
                'type' => 'blog',
                'title' => 'How to choose the right POS for your store',
                'slug' => 'how-to-choose-the-right-pos-for-your-store',
                'excerpt' => 'A practical guide to selecting a scalable POS solution.',
                'content' => 'Choosing the right POS starts with your workflows, growth plan, and integrations.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $retailCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->subDays(5),
                'status' => 'published',
            ],
            [
                'type' => 'news',
                'title' => 'Aqua POS launches new analytics dashboard',
                'slug' => 'aqua-pos-launches-new-analytics-dashboard',
                'excerpt' => 'A new dashboard for deeper sales and performance insights.',
                'content' => 'The latest release introduces real-time KPIs and branch comparisons.',
                'cover_image' => 'img/defaults/placeholder.svg',
                'category_id' => $retailCategory?->id,
                'author_id' => $author?->id,
                'published_at' => now()->subDays(2),
                'status' => 'published',
            ],
        ];

        foreach ($rows as $row) {
            Post::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
