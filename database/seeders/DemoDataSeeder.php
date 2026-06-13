<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder {
    private const ORGANIZATIONS = [
        [
            'name' => 'Summit Facility Services',
            'address' => '12 Business Park Road, Cairo',
            'phone_number' => '+20 100 111 1111',
            'description' => 'Commercial facility maintenance and HVAC services.',
        ],
        [
            'name' => 'Precision HVAC Solutions',
            'address' => '45 Industrial Zone, Alexandria',
            'phone_number' => '+20 100 222 2222',
            'description' => 'Industrial HVAC and energy management specialists.',
        ],
        [
            'name' => 'Metro Maintenance Group',
            'address' => '88 Smart Village, Giza',
            'phone_number' => '+20 100 333 3333',
            'description' => 'Integrated facility management and maintenance services.',
        ],
    ];

    private const CUSTOMER_TEMPLATES = [
        [
            'company_name' => 'Green Valley Mall',
            'contact_person' => 'Mahmoud Fathy',
        ],
        [
            'company_name' => 'North Star Logistics',
            'contact_person' => 'Ahmed Samir',
        ],
        [
            'company_name' => 'Blue Horizon Hotels',
            'contact_person' => 'Hany Adel',
        ],
        [
            'company_name' => 'Prime Foods Manufacturing',
            'contact_person' => 'Sherif Hassan',
        ],
        [
            'company_name' => 'Cairo Business Park',
            'contact_person' => 'Wael Nabil',
        ],
        [
            'company_name' => 'Skyline Office Towers',
            'contact_person' => 'Tarek Salah',
        ],
        [
            'company_name' => 'Elite Medical Center',
            'contact_person' => 'Mohamed Fawzy',
        ],
        [
            'company_name' => 'Rapid Distribution Hub',
            'contact_person' => 'Karim Essam',
        ],
        [
            'company_name' => 'Silver Oak Schools',
            'contact_person' => 'Amr Gamal',
        ],
        [
            'company_name' => 'Global Textiles Factory',
            'contact_person' => 'Nader Youssef',
        ],
        [
            'company_name' => 'West End Retail Group',
            'contact_person' => 'Ali Hossam',
        ],
        [
            'company_name' => 'Capital Industrial Complex',
            'contact_person' => 'Ibrahim Farouk',
        ],
    ];

    private const LOCATION_TEMPLATES = [
        [
            'name' => 'Head Office',
            'city' => 'Cairo',
        ],
        [
            'name' => 'Main Facility',
            'city' => 'Giza',
        ],
        [
            'name' => 'Distribution Center',
            'city' => 'Alexandria',
        ],
    ];

    private const ASSET_TEMPLATES = [
        [
            'name' => 'Main HVAC Unit',
            'manufacturer' => 'Carrier',
            'model' => '30XA-0802',
        ],
        [
            'name' => 'Backup Generator',
            'manufacturer' => 'Cummins',
            'model' => 'C175-16',
        ],
        [
            'name' => 'Passenger Elevator A',
            'manufacturer' => 'Otis',
            'model' => 'Gen2 Premier',
        ],
        [
            'name' => 'Water Pump Station',
            'manufacturer' => 'Grundfos',
            'model' => 'CR-64',
        ],
        [
            'name' => 'Cooling Tower',
            'manufacturer' => 'Baltimore Aircoil',
            'model' => 'VTL-E',
        ],
        [
            'name' => 'Air Compressor',
            'manufacturer' => 'Atlas Copco',
            'model' => 'GA-75',
        ],
    ];

    public function run(): void {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => UserRole::Admin,
        ]);

        foreach (self::ORGANIZATIONS as $organizationIndex => $organizationData) {
            $organization = Organization::create($organizationData);

            $prefix = $this->organizationPrefix($organization->name);

            $this->seedOrganizationUsers(
                organization: $organization,
                prefix: $prefix,
                index: $organizationIndex + 1,
            );

            $assetCounter = 1;

            foreach (self::CUSTOMER_TEMPLATES as $customerIndex => $customerTemplate) {
                $customer = Customer::create([
                    'organization_id' => $organization->id,
                    'company_name' => "{$prefix} {$customerTemplate['company_name']}",
                    'contact_person' => $customerTemplate['contact_person'],
                    'phone' => '+20 101 ' . str_pad((string) ($customerIndex + 1), 4, '0', STR_PAD_LEFT),
                    'email' => sprintf(
                        'facilities%d@%s.test',
                        $customerIndex + 1,
                        Str::slug($organization->name)
                    ),
                    'notes' => fake()->boolean(40)
                        ? fake()->randomElement([
                            'Comprehensive maintenance agreement in place.',
                            'Priority response SLA active.',
                            'Monthly inspection schedule approved.',
                            'Multi-site customer account.',
                        ])
                        : null,
                ]);

                foreach (self::LOCATION_TEMPLATES as $locationTemplate) {
                    $location = Location::create([
                        'organization_id' => $organization->id,
                        'customer_id' => $customer->id,
                        'name' => "{$prefix} {$locationTemplate['name']}",
                        'address' => "{$locationTemplate['name']} - {$customer->company_name}",
                        'city' => $locationTemplate['city'],
                        'state' => 'Egypt',
                        'notes' => fake()->boolean(30)
                            ? fake()->randomElement([
                                'Access requires facility manager approval.',
                                '24/7 operational facility.',
                                'Critical infrastructure location.',
                                'Restricted maintenance window during business hours.',
                            ])
                            : null,
                    ]);

                    foreach (self::ASSET_TEMPLATES as $assetTemplate) {
                        Asset::create([
                            'organization_id' => $organization->id,
                            'location_id' => $location->id,

                            'name' => "{$prefix} {$assetTemplate['name']}",

                            'asset_code' => sprintf(
                                '%s-AST-%04d',
                                $prefix,
                                $assetCounter++
                            ),

                            'manufacturer' => $assetTemplate['manufacturer'],
                            'model' => $assetTemplate['model'],

                            'serial_number' => sprintf(
                                '%s-SN-%06d',
                                $prefix,
                                fake()->unique()->numberBetween(100000, 999999)
                            ),

                            'notes' => fake()->boolean(25)
                                ? fake()->randomElement([
                                    'Installed during facility expansion project.',
                                    'Under manufacturer warranty until 2028.',
                                    'Requires quarterly preventive maintenance.',
                                    'Control panel upgraded recently.',
                                    'Critical asset for daily operations.',
                                    'Recently passed annual inspection.',
                                ])
                                : null,
                        ]);
                    }
                }
            }
        }
    }

    private function seedOrganizationUsers(
        Organization $organization,
        string $prefix,
        int $index,
    ): void {
        User::create([
            'organization_id' => $organization->id,
            'name' => "{$prefix} Owner",
            'email' => "owner{$index}@demo.test",
            'password' => Hash::make('password'),
            'role' => UserRole::Owner,
        ]);

        foreach ([1, 2] as $managerNumber) {
            User::create([
                'organization_id' => $organization->id,
                'name' => "{$prefix} Manager {$managerNumber}",
                'email' => "manager{$index}{$managerNumber}@demo.test",
                'password' => Hash::make('password'),
                'role' => UserRole::Manager,
            ]);
        }

        foreach (range(1, 6) as $technicianNumber) {
            User::create([
                'organization_id' => $organization->id,
                'name' => "{$prefix} Technician {$technicianNumber}",
                'email' => "tech{$index}{$technicianNumber}@demo.test",
                'password' => Hash::make('password'),
                'role' => UserRole::Technician,
            ]);
        }
    }

    private function organizationPrefix(string $organizationName): string {
        return collect(explode(' ', $organizationName))
            ->map(fn(string $word) => strtoupper($word[0]))
            ->join('');
    }
}
