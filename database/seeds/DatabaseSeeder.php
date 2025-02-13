<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    private $commonSeeders = [
        AddLangsTableInitialData::class,
        CreateSuperAdminAccount::class,
        AddInitialShopwayClient::class,
        AddClientsSeeder::class,
        CreateRolesPermissionsAndSuperAdmin::class,
        CreatePermissionsForPermissions::class,
        AddToRootUserASuperAdminRole::class,
        AddGendersTableInitialData::class,
        AddCountriesTableInitialData::class,
        BrandsSeeder::class,
        TaxesSeeder::class,
        TaxRuleGroupsSeeder::class,
        TaxRulesSeeder::class,
        ZonesSeeder::class,
        VariantGroupsTableSeeder::class,
        VariantGroupsTableSeeder::class,
        VariantsTableSeeder::class,
    ];

    /* Test Data */
    private $testSeeders = [AddAffiliatesSeeder::class,
        AddWebsitesSeeder::class,
        AddSettingsUploadsSeeder::class,
        AddCategoriesSeeder::class,
        // AddWebsiteProductCategoriesSeeder::class,
        AddCustomersSeeder::class,
        AddEmployeesSeeder::class,
        AddUsersSeeder::class,
        AssignAffiliatesToClientsSeeder::class,
        AddRolesSeeder::class,
        AddDomainsSeeder::class,
        AddProductsSeeder::class,
        //AddTagsSeeder::class, 
    ];
    /* End of Test Data */

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->commonSeeders as $seeder) {
            $this->call($seeder);
        }

        foreach ($this->testSeeders as $seeder) {
            $this->call($seeder);
        }

    }
}
