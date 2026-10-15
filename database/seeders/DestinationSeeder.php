<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Tarangire National Park',
                'slug' => 'tarangire-national-park',
                'region' => 'Northern Safari Circuit',
                'category' => 'National Park',
                'description' => 'Famous for its dense elephant population and magnificent centuries-old baobab trees that dot the landscape. During the dry season, the Tarangire River acts as the primary lifeblood for thousands of migratory wildlife.',
                'highlights' => 'Huge elephant herds, ancient Baobab trees, tree-climbing lions, 550+ bird species, Silale swamp game viewing.',
                'best_time_to_visit' => 'June to October (Peak wildlife migration)',
                'climate' => 'Warm and dry during safari peak; 21°C to 28°C',
                'entry_fee_info' => '$53 per non-resident adult / 24 hrs',
                'photo' => null,
                'gallery' => [],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Serengeti National Park',
                'slug' => 'serengeti-national-park',
                'region' => 'Northern Safari Circuit',
                'category' => 'National Park',
                'description' => 'A UNESCO World Heritage site and home to the legendary Great Wildebeest Migration. Endless golden savanna plains hosting the highest density of big predators in Africa.',
                'highlights' => 'Great Migration river crossings, Big Five sightings, hot air balloon safaris, Seronera Valley leopards, endless open horizons.',
                'best_time_to_visit' => 'Late June to October (River crossings) & January to March (Calving season)',
                'climate' => 'Pleasant year-round; 15°C mornings to 27°C afternoons',
                'entry_fee_info' => '$82.60 per non-resident adult / 24 hrs',
                'photo' => null,
                'gallery' => [],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Ngorongoro Conservation Area',
                'slug' => 'ngorongoro-conservation-area',
                'region' => 'Northern Safari Circuit',
                'category' => 'Conservation Area',
                'description' => 'The world’s largest intact unbroken volcanic caldera, acting as a natural sanctuary for over 25,000 large animals, including rare black rhinos and flamingos on Lake Magadi.',
                'highlights' => 'Crater floor safari drives, dense black rhino population, Maasai cultural visits, Olduvai Gorge archaeological site.',
                'best_time_to_visit' => 'Year-round wildlife viewing; June to September dry season',
                'climate' => 'Cooler rim temperatures (dropping to 10°C at night); 20-24°C in the caldera',
                'entry_fee_info' => '$70.80 conservation fee + $295 vehicle crater permit',
                'photo' => null,
                'gallery' => [],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Zanzibar Archipelago',
                'slug' => 'zanzibar-archipelago',
                'region' => 'Zanzibar & Coast',
                'category' => 'Beach Island',
                'description' => 'The exotic Spice Island paradise in the Indian Ocean, renowned for powdery white sand beaches, turquoise waters, vibrant coral reefs, and the UNESCO historic Stone Town.',
                'highlights' => 'Stone Town historic walking tour, Mnemba Atoll scuba & snorkeling, spice farm tours, Nungwi & Kendwa beaches, Jozani Forest red colobus monkeys.',
                'best_time_to_visit' => 'June to October & December to February',
                'climate' => 'Tropical coastal warmth; 28°C to 33°C',
                'entry_fee_info' => '$44 mandatory travel insurance entry + local village council conservation fees',
                'photo' => null,
                'gallery' => [],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Mount Kilimanjaro National Park',
                'slug' => 'mount-kilimanjaro-national-park',
                'region' => 'Northern Circuit',
                'category' => 'Mountain',
                'description' => 'The "Roof of Africa" and the world\'s tallest free-standing mountain at 5,895 meters (19,341 ft). Features distinct ecological zones from lush rainforest to arctic summit glaciers.',
                'highlights' => 'Uhuru Peak summit, Machame & Lemosho scenic trekking routes, alpine desert landscapes, Shira Plateau, five ecological climatic zones.',
                'best_time_to_visit' => 'January to March and late June to October (Clearest skies)',
                'climate' => 'Rainforest zone (20-25°C) to arctic summit freezing temperatures (-15°C)',
                'entry_fee_info' => '$82.60 per day park fee + rescue and conservation fees',
                'photo' => null,
                'gallery' => [],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::updateOrCreate(
                ['slug' => $destination['slug']],
                $destination
            );
        }
    }
}
