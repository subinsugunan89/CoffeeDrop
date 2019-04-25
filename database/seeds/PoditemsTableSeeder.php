<?php

use Illuminate\Database\Seeder;
use App\Poditems;
use App\PodPriceDetails;
class PoditemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = Poditems::create([
            'name' => 'Ristretto',
        ]);

         PodPriceDetails::create([
            'product_id' => $p1->id,
            'min_range_limit' => 0 ,
            'max_range_limit' => 50,
            'price' => 2
        ]);
        PodPriceDetails::create([
            'product_id' => $p1->id,
            'min_range_limit' => 51 ,
            'max_range_limit' => 500,
            'price' => 3
        ]);
        PodPriceDetails::create([
            'product_id' => $p1->id,
            'min_range_limit' => 501 ,
            'max_range_limit' => 999999,
            'price' => 5
        ]);
        $p2 = Poditems::create([
            'name' => 'Espresso',
        ]);
        PodPriceDetails::create([
            'product_id' => $p2->id,
            'min_range_limit' => 0 ,
            'max_range_limit' => 50,
            'price' => 4
        ]);
        PodPriceDetails::create([
            'product_id' => $p2->id,
            'min_range_limit' => 51 ,
            'max_range_limit' => 500,
            'price' => 6
        ]);
        PodPriceDetails::create([
            'product_id' => $p2->id,
            'min_range_limit' => 501 ,
            'max_range_limit' => 999999,
            'price' => 10
        ]);
        $p3 = Poditems::create([
        'name' => 'Lungo',
        ]);
        PodPriceDetails::create([
            'product_id' => $p3->id,
            'min_range_limit' => 0 ,
            'max_range_limit' =>50,
            'price' => 6
        ]);
        PodPriceDetails::create([
            'product_id' => $p3->id,
            'min_range_limit' => 51 ,
            'max_range_limit' => 500,
            'price' => 9
        ]);
        PodPriceDetails::create([
            'product_id' => $p3->id,
            'min_range_limit' => 501 ,
            'max_range_limit' => 999999,
            'price' => 15
        ]);
    }
}
