<?php

namespace App\Services\ProductServices;

use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantGroup;
use Illuminate\Support\Collection;

class CombinationService
{
    /**
     * Raw combination data.
     * @var array
     */
    private $combinations;

    /**
     * Collection of variant groups.
     * @var Collection
     */
    private $variantGroups;

    /**
     * Collection of variants
     * @var Collection
     */
    private $variants;

    /**
     * Array of combinations ready for inserting
     * @var array
     */
    private $preparedCombinations;

    /**
     * Main function for variants, variant groups data modeling and preparation
     * @param array $combinations
     */
    public function manageCombinations(array $combinations) : void
    {
        $this->setCombinationsData($combinations);

        $this->manageVariantGroups();

        $this->manageVariants();

        $this->manageCombinationData();
    }

    /**
     * Assign prepared variants to the given product.
     * @param int $productId
     */
    public function storeCombinations(int $productId) : void
    {
        $product = Product::find($productId);

        foreach ($this->preparedCombinations as $combination) {
            if((array_key_exists('combination_data', $combination) && !is_null($combination['combination_data']))) {
                $data = $combination['combination_data'];
            } else {
                $data = [];
            }
            $productCombination = $product->variantsCombinations()->create($data);
            $productCombination->variants()->save($this->variants->where('id', $combination['variant_id'])->first());
        }
    }

    /**
     * Data setter
     * @param array $combinations
     */
    private function setCombinationsData(array $combinations) :void
    {
        $this->combinations = $combinations;
    }

    /**
     * Manage variant groups - if group already exists use it
     * else create and use new one and store in collection.
     */
    private function manageVariantGroups(): void
    {
        $groups = $this->buildGroupsArray();

        $this->variantGroups = collect([]);
        foreach ($groups as $group) {
            $variantGroup = VariantGroup::query()
                ->whereTranslation('name', $group)
                ->first();

            if (is_null($variantGroup)) {
                $group = VariantGroup::create([
                    'name' => $group,
                    'title' => $group
                ]);
                $this->variantGroups->push($group);
            } else {
                $this->variantGroups->push($variantGroup);
            }
        }
    }

    /**
     * Manage variants - get variants form database
     * or create new one and store in collection.
     */
    private function manageVariants(): void
    {
        $variants = $this->buildVariantsArray();

        $this->variants = collect([]);
        foreach ($variants as $variant => $group) {
            $dbVariant = Variant::query()
                ->whereTranslation('title', $variant)
                ->first();

            foreach ($this->variantGroups as $variantGroup) {
                if ($variantGroup->name == $group) {
                    if (is_null($dbVariant)) {
                        $dbVariant = $variantGroup->variants()->create([
                            'title' => $variant,
                            'subtitle' => $variant
                        ]);
                    }
                }
            }
            $this->variants->push($dbVariant);
        }
    }

    /**
     * Prepare the variants and combination information for db inserts.
     */
    private function manageCombinationData() : void
    {
        $preparedCombinations = [];
        foreach ($this->combinations as $key => $combination) {
            foreach ($combination as $id => $combinationVariant) {
                if (array_key_exists('variant', $combinationVariant)) {
                    $preparedCombinations[] = [
                        'variant_id' => array_search($combinationVariant['variant'], $this->variants->pluck('title', 'id')->toArray()),
                        'combination_data' => array_key_exists(2, $combination) ? $combination[2] : null
                    ];
                }
            }
        }
        $this->preparedCombinations = $preparedCombinations;
    }

    /**
     * Builds an array of variants from given data.
     * @return array
     */
    private function buildVariantsArray(): array
    {
        $variants = [];
        foreach ($this->combinations as $combination) {
            foreach ($combination as $element) {
                if (array_key_exists('variant', $element)) {
                    if (!array_key_exists($element['variant'], $variants)) {
                        $variants[$element['variant']] = $element['group'];
                    }
                }
            }
        }
        return $variants;
    }

    /**
     * Builds an array of variant groups from given data.
     * @return array
     */
    private function buildGroupsArray(): array
    {
        $groups = [];
        for ($i = 0; $i < count($this->combinations[0]); $i++) {
            if (array_key_exists('group', $this->combinations[0][$i])) {
                $groups[] = $this->combinations[0][$i]['group'];
            }
        }
        return $groups;
    }
}
