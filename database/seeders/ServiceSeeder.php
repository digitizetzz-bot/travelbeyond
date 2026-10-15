<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Flight Booking',
                'slug' => 'flight-booking',
                'subtitle' => 'Domestic and international flights with competitive airline fares',
                'description' => 'Fast ticketing, seat reservation, and seamless connections across East Africa (Precision Air, Coastal Air, Air Tanzania) and global international hubs.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Tour Planning & Safaris',
                'slug' => 'tour-planning-safaris',
                'subtitle' => 'Customized safari itineraries and iconic park adventures',
                'description' => 'Bespoke game drives across Serengeti, Ngorongoro Crater, Tarangire, and Lake Manyara with professional certified safari guides and rugged 4x4 pop-up vehicles.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Visa & Travel Insurance',
                'slug' => 'visa-and-insurance',
                'subtitle' => 'Hassle-free entry documentation and comprehensive trip coverage',
                'description' => 'Assistance with Tanzanian tourist e-visas, regional entry requirements, health declarations, and comprehensive medical/evacuation travel insurance.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Ferry & Island Transfers',
                'slug' => 'ferry-and-island-transfers',
                'subtitle' => 'High-speed coastal ferry bookings between Dar es Salaam and Zanzibar',
                'description' => 'Official ticketing for Azam Marine Kilimanjaro Fast Ferries (VIP, Royal, and Economy classes) plus private boat charters to Prison Island and Pemba.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Mountain Trekking Expeditions',
                'slug' => 'mountain-trekking-expeditions',
                'subtitle' => 'Mount Kilimanjaro & Mount Meru summit packages',
                'description' => 'Guided climbs along Machame, Marangu, Lemosho, and Rongai routes with experienced porters, safety briefings, oxygen monitoring, and nutritious expedition catering.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Luxury Hotel & Lodge Reservations',
                'slug' => 'luxury-hotel-lodge-reservations',
                'subtitle' => 'Curated beachfront resorts, boutique villas, and safari tented camps',
                'description' => 'Handpicked accommodations in Zanzibar (Nungwi, Kendwa, Paje) and luxury safari camps overlooking prime wildlife migration paths.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
