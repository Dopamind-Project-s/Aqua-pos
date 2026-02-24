<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'type' => 'demo_request',
                'full_name' => 'Aqua Demo Lead',
                'email' => 'demo@example.com',
                'phone' => '+962790000000',
                'company' => 'Retail One',
                'country' => 'Jordan',
                'product_interest' => 'POS + Inventory',
                'branch_count' => 3,
                'preferred_contact_time' => '10:00 AM',
                'subject' => 'Product Demo',
                'message' => 'Need a full product demo for 3 branches.',
                'source_page' => '/request-product-demo',
                'status' => 'new',
            ],
            [
                'type' => 'support_request',
                'full_name' => 'Aqua Support User',
                'email' => 'support@example.com',
                'phone' => '+962791111111',
                'company' => 'Restaurant X',
                'country' => 'Jordan',
                'subject' => 'Printer issue',
                'message' => 'Need urgent support for receipt printer setup.',
                'source_page' => '/support',
                'status' => 'in_progress',
            ],
        ];

        foreach ($rows as $row) {
            ServiceRequest::updateOrCreate(
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
