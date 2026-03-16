<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $requests = [
            [
                'type' => 'demo_request',
                'full_name' => 'Ahmad Al-Khatib',
                'email' => 'ahmad.demo@retailone.com',
                'phone' => '+962790000001',
                'company' => 'Retail One Group',
                'country' => 'Jordan',
                'product_interest' => 'Aqua Retail Pro',
                'branch_count' => 4,
                'preferred_contact_time' => '10:00 AM - 12:00 PM',
                'subject' => 'Enterprise demo for multi-branch operations',
                'message' => 'Need a full walk-through for POS, inventory, and branch reports.',
                'source_page' => '/request-product-demo',
                'status' => 'new',
            ],
            [
                'type' => 'demo_request',
                'full_name' => 'Rana Haddad',
                'email' => 'rana.ops@cedarhotels.com',
                'phone' => '+962790000002',
                'company' => 'Cedar Hotels',
                'country' => 'Jordan',
                'product_interest' => 'Aqua Hospitality Desk',
                'branch_count' => 2,
                'preferred_contact_time' => '2:00 PM - 4:00 PM',
                'subject' => 'Hospitality module demo request',
                'message' => 'Looking for centralized billing and outlet-level reporting.',
                'source_page' => '/request-product-demo',
                'status' => 'in_progress',
            ],
            [
                'type' => 'support_request',
                'full_name' => 'Lina Saadeh',
                'email' => 'support@urban-market.com',
                'phone' => '+962790000010',
                'company' => 'Urban Market',
                'country' => 'Jordan',
                'subject' => 'Receipt printer mapping issue',
                'message' => 'Branch 3 printer profiles need to be remapped after update.',
                'source_page' => '/support',
                'status' => 'new',
            ],
            [
                'type' => 'support_request',
                'full_name' => 'Mohammad Nimer',
                'email' => 'it@royalbistro.com',
                'phone' => '+962790000011',
                'company' => 'Royal Bistro',
                'country' => 'Jordan',
                'subject' => 'Kitchen display delays',
                'message' => 'Orders are delayed between cashier and kitchen display.',
                'source_page' => '/support',
                'status' => 'closed',
            ],
            [
                'type' => 'contact_request',
                'full_name' => 'Sara Mansour',
                'email' => 'sara.mansour@example.com',
                'phone' => '+962790000020',
                'company' => 'Nexa Pharmacy',
                'country' => 'Jordan',
                'subject' => 'Partnership inquiry',
                'message' => 'Interested in discussing rollout for pharmacy chain branches.',
                'source_page' => '/contact',
                'status' => 'new',
            ],
            [
                'type' => 'contact_request',
                'full_name' => 'Faris Yaseen',
                'email' => 'faris.yaseen@example.com',
                'phone' => '+962790000021',
                'company' => 'Independent Consultant',
                'country' => 'Saudi Arabia',
                'subject' => 'Regional deployment question',
                'message' => 'Need deployment and onboarding details for GCC expansion.',
                'source_page' => '/contact',
                'status' => 'in_progress',
            ],
        ];

        foreach ($requests as $request) {
            ServiceRequest::query()->updateOrCreate(
                [
                    'type' => $request['type'],
                    'email' => $request['email'],
                    'source_page' => $request['source_page'],
                ],
                $request
            );
        }
    }
}
