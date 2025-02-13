<?php

use Illuminate\Database\Seeder;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = \DB::table('taxes')->count();
        if ($taxes < 29) {
            \DB::statement(
                "INSERT INTO `taxes` (`id`, `rate`, `title`, `active`) VALUES
                (1, '19.000', 'MwSt. DE 19%', 1),
                (2, '7.000', 'MwSt. DE 7%', 1),
                (3, '20.000', 'USt. AT 20%', 1),
                (4, '21.000', 'TVA BE 21%', 1),
                (5, '20.000', 'ДДС BG 20%', 1),
                (6, '19.000', 'ΦΠΑ CY 19%', 1),
                (7, '21.000', 'DPH CZ 21%', 1),
                (8, '25.000', 'moms DK 25%', 1),
                (9, '20.000', 'km EE 20%', 1),
                (10, '21.000', 'IVA ES 21%', 1),
                (11, '24.000', 'ALV FI 24%', 1),
                (12, '20.000', 'TVA FR 20%', 1),
                (13, '20.000', 'VAT UK 20%', 1),
                (14, '23.000', 'ΦΠΑ GR 23%', 1),
                (15, '25.000', 'Croatia PDV 25%', 1),
                (16, '27.000', 'ÁFA HU 27%', 1),
                (17, '23.000', 'VAT IE 23%', 1),
                (18, '22.000', 'IVA IT 22%', 1),
                (19, '21.000', 'PVM LT 21%', 1),
                (20, '17.000', 'TVA LU 17%', 1),
                (21, '21.000', 'PVN LV 21%', 1),
                (22, '18.000', 'VAT MT 18%', 1),
                (23, '21.000', 'BTW NL 21%', 1),
                (24, '23.000', 'PTU PL 23%', 1),
                (25, '23.000', 'IVA PT 23%', 1),
                (26, '24.000', 'TVA RO 24%', 1),
                (27, '25.000', 'Moms SE 25%', 1),
                (28, '22.000', 'DDV SI 22%', 1),
                (29, '20.000', 'DPH SK 20%', 1);"
            );
        }

    }
}
