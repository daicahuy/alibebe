<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckUniqueSkuVariantRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productSku = request()->input('product.sku');  
                
        if ($value === $productSku) {  
            $fail('SKU biến thể không được trùng với SKU sản phẩm');  
        }
        
        // Kiểm tra tính duy nhất giữa các SKU của variants  
        $productVariantSkus = request()->input('product_variants');  
        $variantSkus = collect($productVariantSkus)
            ->pluck('info.sku')  
            ->filter()  
            ->toArray();  
        
        $occurrences = array_count_values($variantSkus);  
        if ($occurrences[$value] > 1) {  
            $fail('SKU biến thể không được trùng nhau');  
        }
    }
}
