<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Review::create([
            'name' => 'Rahul Sharma',
            'bike' => 'Classic 350',
            'text' => 'The absolute best service experience! My bike feels like it just came out of the showroom.',
            'initials' => 'RS',
            'stars' => 5
        ]);

        \App\Models\Review::create([
            'name' => 'Ananya Iyer',
            'bike' => 'Duke 390',
            'text' => 'Finally a workshop that understands high-performance bikes. The AI diagnosis was spot on.',
            'initials' => 'AI',
            'stars' => 5
        ]);

        \App\Models\Review::create([
            'name' => 'Vikram Singh',
            'bike' => 'CB350RS',
            'text' => 'Transparent pricing and super professional staff. I love how I can track my service progress.',
            'initials' => 'VS',
            'stars' => 5
        ]);

        \App\Models\Review::create([
            'name' => 'Sameer Khan',
            'bike' => 'Pulsar NS200',
            'text' => 'Fastest service! My bike was ready in 2 hours and the results are amazing. Highly efficient.',
            'initials' => 'SK',
            'stars' => 5
        ]);

        \App\Models\Review::create([
            'name' => 'Divya Reddy',
            'bike' => 'Access 125',
            'text' => 'Affordable and genuine. No hidden charges. They explained everything clearly before starting.',
            'initials' => 'DR',
            'stars' => 5
        ]);

        \App\Models\Review::create([
            'name' => 'Arjun Kapoor',
            'bike' => 'Ninja 650',
            'text' => 'Impressive technical knowledge. Best place for superbikes in the city. Truly premium service.',
            'initials' => 'AK',
            'stars' => 5
        ]);
    }
}
