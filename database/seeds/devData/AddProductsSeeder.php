<?php

use Illuminate\Database\Seeder;
use App\Services\SeederServices\ProductDataSeederService;

class AddProductsSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addProducts();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addProducts()
    {
        $products = \DB::table('products')->count();
        if ($products < 2) {
            $this->createProducts();
        }
        $products_meta = \DB::table('websites_products_metas')->count();
        if ($products_meta < 1) {
            $this->createWebsitesProductsMetas();
        }
        $websites_products = \DB::table('websites_products')->count();
        if ($websites_products < 1) {
            $this->createWebsitesProducts();
        }

        $uploads = \DB::table('uploads')->count();
        if ($uploads < 3) {
            $this->uploadProductImages();
        }

    }

    private function createProducts(): void
    {
        // Uncomment if large products table seed is needed
        // $values = ProductDataSeederService::getProductSeederData();

        $values = $this->getProductsData();

        foreach ($values as $value) {
            $images = false;
            if (isset($value['images'])) {
                $images = $value['images'];
                unset($value['images']);
            }
            $product = new \App\Models\Product();
            $product->fill($value);
            $product->save();
            $value['url'] .= '-en';
            $value['name'] .= ' ENq';
            $value['description'] .= ' ENw';
            $value['meta_title'] .= ' ENe';
            $value['meta_description'] .= ' ENr';
            $value['meta_keywords'] .= ' ENt';
            $product->translateOrNew('en')->fill(\Illuminate\Support\Arr::only($value, (new \App\Models\Translatable\ProductTranslation())->getFillable()));
            $product->save();

            if ($images) {
                $this->sendToS3($product, $images);
            }
        }
    }

    private function uploadProductImages()
    {
        // Uncomment if large products table seed is needed
        // $values = ProductDataSeederService::getProductSeederData();
        $values = $this->getProductsData();

        foreach ($values as $value) {
            $product = \App\Models\Product::find($value['id']);

            if (isset($value['images'])) {
                $this->sendToS3($product, $value['images']);
            }
        }

    }

    private function createWebsitesProductsMetas(): void
    {
        $val = [
            'id' => 1,
            'name' => 'Weishäupl Klassiker Schirm',
            'description' => '<p>WEISHÄUPL Schirmstoffe<br />100% Polyacrylgewebe, spinndüsengefärbt<br />Wasser-, öl- und schmutzabweisend imprägniert (Teflon®), zusätzlich fäulnishemmend ausgerüstet.<br /><br />UV-Schutzfaktor: ca. 40 (helle Farben) bzw. ca. 80 (dunkle Farben)<br /><br /></p>',
            'description_short' => '<p>Weishäupl KLASSIKER Sonnenschirm, rund<br />In 46 Farben erhältlich<br /><br />Optional Schirmrand mit umlaufendem Streifen (15 cm) in Kontrastfarbe<br />Flaschenzug optional<br />Schirmständer nicht inklusive<br /><br /><br /><br /></p>',
            'meta_title' => 'Weishäupl Klassiker Schirm rund 450 cm',
            'meta_description' => 'Sonnenschirme aus dem Weishäupl Onlineshop - Der Klassik Sonnenschirm rund 450 cm aus Holz mit hochwertigem Dolan Bezug.',
            'meta_keywords' => 'weishäupl,gartenmöbel,sonnensegel,sonnenschirme,gartenschirme,teakholz,pagodenschirme,aluschirm,schutzhüllen,halbschirm',
            'ean13' => 'e',
            'reference' => 'KL4500',
            'reference_brand' => '',
            'price' => '1063.025210',
            'show_price' => 1,
            'width' => '0.000000',
            'height' => '0.000000',
            'depth' => '0.000000',
            'weight' => '0.000000',
            'available_text' => 'nur 3-4 Wochen',
            'available_days' => null,
            'available_date' => null,
            'redirect_type' => '',
            'redirect_product_id' => null,
            'active' => 1,
            'created_at' => '2016-11-03 00:00:00',
            'updated_at' => '2019-07-10 22:02:41',
        ];

        $meta = new \App\Models\WebsitesProductsMeta();
        $meta->fill($val);
        $meta->save();

        $val['name'] .= ' ENu';
        $val['description'] .= ' ENq';
        $val['description_short'] .= ' ENw';
        $val['meta_title'] .= ' ENe';
        $val['meta_description'] .= ' ENr';
        $val['meta_keywords'] .= ' ENt';
        $val['available_text'] .= ' ENy';
        $meta->translateOrNew('en')->fill(\Illuminate\Support\Arr::only($val, (new \App\Models\Translatable\WebsiteProductMetaTranslation())->getFillable()));
        $meta->save();
    }

    private function createWebsitesProducts(): void
    {
        $values = [
            [
                'client_id' => 2,
                'website_id' => 1,
                'brand_id' => 1,
                'category_id' => 3,
                'product_id' => 3186,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'weishaeupl-klassik-sonnenschirm-rund-450-cm',
            ],
            [
                'client_id' => 2,
                'website_id' => 1,
                'brand_id' => 1,
                'category_id' => 6,
                'product_id' => 2,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'next-12-sofa',
            ],

            [
                'client_id' => 2,
                'website_id' => 2,
                'brand_id' => 1,
                'category_id' => 3,
                'product_id' => 3186,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'weishaeupl-klassik-sonnenschirm-rund-450-cm',
            ],
            [
                'client_id' => 2,
                'website_id' => 2,
                'brand_id' => 1,
                'category_id' => 5,
                'product_id' => 2,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'next-12-sofa',
            ],

            [
                'client_id' => 2,
                'website_id' => 2,
                'brand_id' => 1,
                'category_id' => 5,
                'product_id' => 3186,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'weishaeupl-klassik-sonnenschirm-rund-450-cm',
            ],
            [
                'client_id' => 2,
                'website_id' => 2,
                'brand_id' => 1,
                'category_id' => 6,
                'product_id' => 2,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'next-12-sofa',
            ],
            [
                'client_id' => 2,
                'website_id' => 3,
                'brand_id' => 1,
                'category_id' => 5,
                'product_id' => 3,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'bitta-armlehnstuhl',
            ],
            [
                'client_id' => 2,
                'website_id' => 3,
                'brand_id' => 1,
                'category_id' => 9,
                'product_id' => 2,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'next-12-sofa',
            ],
            [
                'client_id' => 2,
                'website_id' => 3,
                'brand_id' => 1,
                'category_id' => 9,
                'product_id' => 3,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'bitta-armlehnstuhl',
            ],
            // ----------------------
            [
                'client_id' => 3,
                'website_id' => 4,
                'brand_id' => 1,
                'category_id' => 12,
                'product_id' => 4,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'manutti-san-diego',
            ],
            [
                'client_id' => 3,
                'website_id' => 4,
                'brand_id' => 1,
                'category_id' => 12,
                'product_id' => 5,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'gray-01-sessel',
            ],
            [
                'client_id' => 3,
                'website_id' => 5,
                'brand_id' => 1,
                'category_id' => 15,
                'product_id' => 4,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'manutti-san-diego',
            ],
            [
                'client_id' => 3,
                'website_id' => 5,
                'brand_id' => 1,
                'category_id' => 15,
                'product_id' => 5,
                'website_product_meta_id' => 1,
                'tax_rule_group_id' => 1,
                'url' => 'gray-01-sessel',
            ],

            // ---------
        ];

        foreach ($values as $value) {
            $websiteProducts = new \App\Models\WebsitesProduct();
            $websiteProducts->fill($value);
            $websiteProducts->save();
            $value['url'] .= '-en';
            $websiteProducts->translateOrNew('en')->fill(\Illuminate\Support\Arr::only($value, (new \App\Models\Translatable\WebsiteProductTranslation())->getFillable()));
            $websiteProducts->save();
        }
    }

    private function getProductsData()
    {
        return [
            [
                'id' => 3186, 'brand_id' => 1, 'url' => 'weishaeupl-klassik-sonnenschirm-rund-450-cm',
                'name' => 'Weishäupl Klassiker Schirm Ø 450 cm',
                'description' => '<p>WEISHÄUPL Schirmstoffe<br />100% Polyacrylgewebe, spinndüsengefärbt<br />Wasser-, öl- und schmutzabweisend imprägniert (Teflon®), zusätzlich fäulnishemmend ausgerüstet.<br /><br />UV-Schutzfaktor: ca. 40 (helle Farben) bzw. ca. 80 (dunkle Farben)<br /><br /></p>',
                'description_short' => '<p>Weishäupl KLASSIKER Sonnenschirm, rund<br />In 46 Farben erhältlich<br /><br />Optional Schirmrand mit umlaufendem Streifen (15 cm) in Kontrastfarbe<br />Flaschenzug optional<br />Schirmständer nicht inklusive<br /><br /><br /><br /></p>',
                'meta_title' => 'Weishäupl Klassiker Schirm rund 450 cm',
                'meta_description' => 'Sonnenschirme aus dem Weishäupl Onlineshop - Der Klassik Sonnenschirm rund 450 cm aus Holz mit hochwertigem Dolan Bezug.',
                'meta_keywords' => 'weishäupl,gartenmöbel,sonnensegel,sonnenschirme,gartenschirme,teakholz,pagodenschirme,aluschirm,schutzhüllen,halbschirm',
                'ean13' => 'e', 'reference' => 'KL4500', 'reference_brand' => '', 'price' => '1063.025210', 'show_price' => 1,
                'width' => '0.000000', 'height' => '0.000000', 'depth' => '0.000000', 'weight' => '0.000000',
                'available_text' => 'nur 3-4 Wochen', 'available_days' => null, 'available_date' => null, 'redirect_type' => '',
                'redirect_product_id' => null, 'active' => 1, 'deleted_at' => null, 'created_at' => '2016-11-03 00:00:00',
                'updated_at' => '2019-07-10 22:02:41',
                'images' => ['sample1.jpg'],
            ],
            [
                'id' => 2, 'brand_id' => 1, 'url' => 'next-12-sofa', 'name' => 'Gervasoni NEXT 10 /12 Sofa', 'description' => '',
                'description_short' => '<p>Gervasoni NEXT 10/12 Sofa<br />Füße amerikan. Nussbaum, natur lasiert oder Buche, farbig lackiert<br />oder Füße aus Gussaluminium, poliert<br />Stabile Polsterung aus Polyurethanschaum<br />Inkl. zwei Rückenkissen, 60 x 60 cm (Dracon & Daunen)<br /><br />Abziehbarer Bezug in 2 Ausführungen erhältlich:<br />Lose Husse mit Overlock-Nähten oder straffer Bezug mit Keder<br /><br /><br />Hinweis:<br />Waschbare Gervasoni Stoffe sind  durch die Angabe der maximal empfohlenen Waschtemperatur auf dem Pflegeetikett erkennbar.<br />Die angegebene Waschtemperatur bezieht sich sich lediglich auf die Farbbeständigkeit des Stoffs, nicht vorgewaschene Stoffe können bei einer Wäsche bis zu 10% schrumpfen.<br />Um das Schrumpfen einzuschränken, empfehlen wir den Bezug vorgewaschen zu bestellen.<br />Dieser Gervasoni Service verlängert den Liefertermin um ca. eine Woche.<br /><br /><br /><br /><br /></p>',
                'meta_title' => 'Gervasoni NEXT 12 Sofa',
                'meta_description' => 'Entdecken Sie die Gervasoni Ghost Kollektion in unserem Onlineshop. Versandkostenfreie Lieferung und attraktive Rabatte warten auf Sie.',
                'meta_keywords' => 'gervasoni,ghost,italienische,möbel,designermöbel,designer,sofas,sessel,betten,italien',
                'ean13' => 'b', 'reference' => 'NEXT 10', 'reference_brand' => '', 'price' => '2333.613445', 'show_price' => 1,
                'width' => '0.000000', 'height' => '0.000000', 'depth' => '0.000000', 'weight' => '0.000000', 'available_text' => 'nur 4 Wochen',
                'available_days' => null, 'available_date' => null, 'redirect_type' => '', 'redirect_product_id' => null, 'active' => 1,
                'deleted_at' => null, 'created_at' => '2016-06-28 14:36:56', 'updated_at' => '2019-06-27 10:26:06',
                'images' => ['sample2.jpg'],
            ],
            [
                'id' => 3, 'brand_id' => 1, 'url' => 'bitta-armlehnstuhl', 'name' => 'BITTA Armlehnstuhl', 'description' => '',
                'description_short' => '<p>Kettal BITTA Armlehnstuhl<br /><br />Gestell Aluminium, pulverbeschichtet<br />Bespannung Polyester-Band<br /> <br />Lieferung inkl. Sitzpolster 47 x 45 x 4,5 cm<br /><br /></p>',
                'meta_title' => 'Kettal BITTA Armlehnstuhl', 'meta_description' => 'Kettal BITTA Armlehnstuhl',
                'meta_keywords' => 'kettal,möbel,accessoires,design,designermöbel,designer möbel,bob,vieques,bitta,net,maia',
                'ean13' => '8421303453546', 'reference' => '70100-40A-00-... + 70160.009-...', 'reference_brand' => '',
                'price' => '839.495798', 'show_price' => 1, 'width' => '0.000000', 'height' => '0.000000', 'depth' => '0.000000',
                'weight' => '0.000000', 'available_text' => 'nur 6 Wochen', 'available_days' => null, 'available_date' => null,
                'redirect_type' => '', 'redirect_product_id' => null, 'active' => 1, 'deleted_at' => null,
                'created_at' => '2016-06-11 00:00:00', 'updated_at' => '2019-07-16 04:56:06',
                'images' => ['sample3.png'],
            ],
            [
                'id' => 4, 'brand_id' => 1, 'url' => 'manutti-san-ciego', 'name' => 'Manutti San Diego 2,5-Sitzer Gartensofa',
                'description' => '',
                'description_short' => '<p>Manutti SAN DIEGO Sofa 2,5 Sitzer<br />Gestell Aluminium, pulverbeschichtet<br />Geflechtstärke 8 mm, Farbe Old Grey<br /><br /><br />Polster = 1 Sitzkissen, 2 Rückenkissen <br />(Höhe Sitzpolster = 10 cm) <br /><br /><br /></p>',
                'meta_title' => 'Manutti San Diego 2,5-Sitzer Gartensofa',
                'meta_description' => 'Manutti Gartenmöbel! Wir sind der Spezialist für den Versand von Manutti Gartenmöbeln. Hotline: +49(0)521 944 1700',
                'meta_keywords' => 'manutti,forseasons,gartenmöbel,outdoormöbel,flechtmöbel,teak,wetterfest,terrasse,stuhl,sessel,sofa,liege,hocker,gartentisch,beistelltisch,kaffeetisch,tafel,esstisch,lounger,long beach,malibu,aspen,curacao,hawaii,atla',
                'ean13' => 'c', 'reference' => 'FS-2S96', 'reference_brand' => '', 'price' => '1743.697479', 'show_price' => 1,
                'width' => '0.000000', 'height' => '0.000000', 'depth' => '0.000000', 'weight' => '0.000000', 'available_text' => 'nur 2-4 Wochen',
                'available_days' => null, 'available_date' => null, 'redirect_type' => '', 'redirect_product_id' => null,
                'active' => 1, 'deleted_at' => null, 'created_at' => '2016-04-10 00:00:00', 'updated_at' => '2019-06-05 15:49:48',
                'images' => ['sample1.jpg', 'sample2.jpg'],
            ],
            [
                'id' => 5, 'brand_id' => null, 'url' => 'gray-01-sessel', 'name' => 'Gervasoni GRAY 01 Sessel', 'description' => '',
                'description_short' => '<p>Gervasoni GRAY 01 Sessel<br />Gestell amerikan. Nussbaum natur, lasiert oder<br />Gestell Eiche, gebleicht oder farbig lackiert<br /><br />Polster = 1 Sitzpolster inkl. 5 Wurfkissen:<br />2x Kissen 110x50 cm, 2x Kissen 50x50 cm, 1x Kissen 65x50 cm<br /><br /></p>\r\n<p>Hinweis:<br />Waschbare Gervasoni Stoffe sind  durch die Angabe der maximal empfohlenen Waschtemperatur auf dem Pflegeetikett erkennbar.<br />Die angegebene Waschtemperatur bezieht sich sich lediglich auf die Farbbeständigkeit des Stoffs, nicht vorgewaschene Stoffe können bei einer Wäsche bis zu 10% schrumpfen.<br />Um das Schrumpfen einzuschränken, empfehlen wir den Bezug vorgewaschen zu bestellen.<br />Dieser Gervasoni Service verlängert den Liefertermin um ca. eine Woche.<br /><br /></p>',
                'meta_title' => 'Gervasoni GRAY 01 Sessel',
                'meta_description' => 'Die Gervasoni Gray Designersofas und Sessel erhalten Sie versandkostenfrei bei uns. Attraktive Rabatte sichern und italienische Sofas und Sessel günstig bestellen.',
                'meta_keywords' => 'gervasoni,gray,sessel,designersessel,lounge,designer,italienische,exklusive',
                'ean13' => 'd', 'reference' => 'GRAY 01', 'reference_brand' => '', 'price' => '2019.327731', 'show_price' => 1,
                'width' => '0.000000', 'height' => '0.000000', 'depth' => '0.000000', 'weight' => '0.000000', 'available_text' => 'nur 4 Wochen',
                'available_days' => null, 'available_date' => null, 'redirect_type' => '', 'redirect_product_id' => null, 'active' => 1,
                'deleted_at' => null, 'created_at' => '2016-01-20 00:00:00', 'updated_at' => '2020-02-17 13:15:48',
                'images' => ['sample2.jpg', 'sample3.png'],
            ],
        ];
    }

    /**
     *
     * @param \App\Models\Product $product
     * @param array $images
     */
    private function sendToS3($product, $images)
    {
        $user = \App\Models\User::find(1);
        foreach($images as $imageName) {
            $file = new \Illuminate\Http\UploadedFile(database_path('seeds/devData/uploads/'.$imageName), $imageName);

            $data = [
                'data' => [
                    'filepond' => $file,
                    'model' => $product
                ],
                'clientId' => 2,
                'settingId' => 1,
                'customName' => null,
            ];

            $genericUpload = new \App\Services\UploadServices\GenericUpload($data, $user);
            $genericUpload->process();
        }
    }
}
