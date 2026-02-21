<?php

namespace Database\Seeders;

use App\Models\ContactRequest;
use Illuminate\Database\Seeder;

class ContactRequestSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'type' => 'demo',
                'full_name' => 'Ahmed Ali',
                'email' => 'ahmed@example.com',
                'phone' => '+966511111111',
                'company' => 'Retail One',
                'country' => 'Saudi Arabia',
                'message' => 'Need a demo for 3 branches.',
                'source_page' => '/pricing',
                'status' => 'new',
            ],
            [
                'type' => 'contact',
                'full_name' => 'Sara Khaled',
                'email' => 'sara@example.com',
                'phone' => '+966522222222',
                'company' => null,
                'country' => 'Saudi Arabia',
                'message' => 'I want details about integrations.',
                'source_page' => '/contact',
                'status' => 'in_progress',
            ],
        ];

        foreach ($rows as $row) {
            ContactRequest::updateOrCreate(
                [
                    'type' => $row['type'],
                    'email' => $row['email'],
                    'source_page' => $row['source_page'],
                ],
                $row
            );
        }
    }
}
