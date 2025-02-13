<?php

use Illuminate\Database\Seeder;

class TaxRuleGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = \DB::table('tax_rule_groups')->count();
        if ($taxes < 3) {
            \DB::statement("
                INSERT INTO `tax_rule_groups` VALUES
                (1, '19% MwSt', 1, NULL, '2015-08-15 18:02:16', '2016-07-04 03:53:34'),
                (2, '7% MwSt', 1, NULL, '2015-08-15 18:02:16', '2016-07-04 03:53:34'),
                (3, '7,8% MwSt', 1, NULL, '2019-03-21 00:00:00', '2019-03-21 00:00:00');
            ");
        }
    }
}
