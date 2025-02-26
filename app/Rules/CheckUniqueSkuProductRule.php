<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckUniqueSkuProductRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productVariantSkus = request()->input('product_variants');  
                
        if ($productVariantSkus) {  
            $variantSkus = collect($productVariantSkus)  
                ->pluck('info.sku')  
                ->filter()  
                ->toArray();  
            
            if (in_array($value, $variantSkus)) {  
                $fail('SKU sản phẩm không được trùng với SKU các biến thể');  
            }
        }  
    }
}
