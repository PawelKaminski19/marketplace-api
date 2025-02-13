<?php

use Illuminate\Database\Seeder;


class AddInitialShopwayClient extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = \DB::table('clients')->where('username','Shopway')->count();
        if ($clients == 0) {
           
            $slug = "4e5c9b1-db05-4d3b-8c67-0745a21f2b37"; //easier to debug
            $idClient = \DB::table('clients')->insert(['username' => 'Shopway',
                                                 'slug' => $slug,
                                                 'active' => 1,
                                                 'softwareowner_flag' => 1,
                                                 'created_at' => \Carbon\Carbon::now(),
                                                 'updated_at' => \Carbon\Carbon::now()
                                               ]);

            \DB::table('roles')->whereNull('client_id')->where('name','!=','SuperAdmin')->where('name','!=','Admin')
                               ->update(['client_id' => $idClient]);

            $idSoftwareOwner = \DB::table('softwareowners')->insert(['client_id' => $idClient,
                                                                    'lang_id' => 1,
                                                                    'created_at' => \Carbon\Carbon::now(),
                                                                    'updated_at' => \Carbon\Carbon::now()
                                                                  ]);
            $idUser = \DB::table('users')->where('name','SuperAdmin')
                                         ->update(['softwareowner_id' => $idSoftwareOwner,
                                                   'updated_at' => \Carbon\Carbon::now()
                                                  ]);
        }

    }
}
