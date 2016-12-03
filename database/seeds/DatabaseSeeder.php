<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i =0; $i < 50; $i++) {
            DB::table('projects')->insert([
                'name' => str_random(25),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);
        }

        for ($i =0; $i < 50; $i++) {
            DB::table('sets')->insert([
                'name' => str_random(25),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);
        }

        for ($i =0; $i < 50; $i++) {
            DB::table('parts')->insert([
                'name' => str_random(25),
                'weight' => $this->randomDouble(),
                'units' => random_int(1, 50),
                'stock' => random_int(1, 50),
                'length' => $this->randomDouble(),
                'width' => $this->randomDouble(),
                'sales_price' => $this->randomDouble(),
                'purchase_price' => $this->randomDouble(),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);
        }

        for ($i =0; $i < 50; $i++) {
            DB::table('project_set')->insert([
                'project_id' => random_int(1, 50),
                'set_id' => random_int(1, 50),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,

            ]);
        }

        for ($i =0; $i < 50; $i++) {
            DB::table('set_part')->insert([
                'project_set_id' => random_int(1, 50),
                'part_id' => random_int(1, 50),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);
        }
    }

    private function randomDouble() {
        return random_int(1, 50) . '.' . random_int(1, 50);
    }
}
