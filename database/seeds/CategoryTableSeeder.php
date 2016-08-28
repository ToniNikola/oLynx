<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        $category = array(
            array('code' => 'Beg', 'name' => 'Beg'),
            array('code' => 'OpenS', 'name' => 'OpenS'),
            array('code' => 'OpenL', 'name' => 'OpenL'),
            array('code' => 'M10', 'name' => 'M10'),
            array('code' => 'M12', 'name' => 'M12'),
            array('code' => 'M14', 'name' => 'M14'),
            array('code' => 'M16', 'name' => 'M16'),
            array('code' => 'M18', 'name' => 'M18'),
            array('code' => 'M20', 'name' => 'M20'),
            array('code' => 'M21', 'name' => 'M21'),
            array('code' => 'M21A', 'name' => 'M21A'),
            array('code' => 'M21B', 'name' => 'M21B'),
            array('code' => 'M21C', 'name' => 'M21C'),
            array('code' => 'M21E', 'name' => 'M21E'),
            array('code' => 'M35', 'name' => 'M35'),
            array('code' => 'M40', 'name' => 'M40'),
            array('code' => 'M45', 'name' => 'M45'),
            array('code' => 'M50', 'name' => 'M50'),
            array('code' => 'M55', 'name' => 'M55'),
            array('code' => 'M60', 'name' => 'M60'),
            array('code' => 'M65', 'name' => 'M65'),
            array('code' => 'M70', 'name' => 'M70'),
            array('code' => 'W10', 'name' => 'W10'),
            array('code' => 'W12', 'name' => 'W12'),
            array('code' => 'W14', 'name' => 'W14'),
            array('code' => 'W16', 'name' => 'W16'),
            array('code' => 'W18', 'name' => 'W18'),
            array('code' => 'W20', 'name' => 'W20'),
            array('code' => 'W21', 'name' => 'W21'),
            array('code' => 'W21A', 'name' => 'W21A'),
            array('code' => 'W21B', 'name' => 'W21B'),
            array('code' => 'W21C', 'name' => 'W21C'),
            array('code' => 'W21E', 'name' => 'W21E'),
            array('code' => 'W30', 'name' => 'W30'),
            array('code' => 'W35', 'name' => 'W35'),
            array('code' => 'W40', 'name' => 'W40'),
            array('code' => 'W45', 'name' => 'W45'),
            array('code' => 'W50', 'name' => 'W50'),
            array('code' => 'W55', 'name' => 'W55'),
            array('code' => 'W60', 'name' => 'W60'),
            array('code' => 'W65', 'name' => 'W65'),
            array('code' => 'W70', 'name' => 'W70'),
        );

        DB::table('categories')->insert($category);
    }
}
