<?php

namespace App\Rules;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckValidSpecificationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Kiểm tra xem giá trị có tồn tại trong bảng `attribute_values` không
        $attributeValue = AttributeValue::query()
            ->where('id', $value)
            ->first();

        if (!$attributeValue) {
            $fail("Giá trị $value không tồn tại trong bảng attribute_values.");
            return;
        }

        // Kiểm tra xem giá trị này có thuộc một attribute có `is_variant = 1` không
        $attribute = Attribute::query()
            ->where('id', $attributeValue->attribute_id)
            ->first();

        if ($attribute && $attribute->is_variant == 1) {
            $fail("Giá trị $value thuộc một attribute biến thể, không hợp lệ.");
        }

        $attributeIDs = [];
        foreach (request()->input('product_specifications') as $attributeValueID) {
            $attributeValue = AttributeValue::query()
            ->where('id', $attributeValueID)
            ->first();

            $attributeIDs[] = $attributeValue->attribute_id;
        }

        if (count($attributeIDs) !== count(array_unique($attributeIDs))) {
            $fail("Thông số kĩ thuật không được trùng nhau");
        }
    }
}
