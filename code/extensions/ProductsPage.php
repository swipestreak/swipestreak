<?php

class StreakProductsPageExtension extends SiteTreeExtension {
    public function XupdateCMSFields(FieldList $fields) {
        $fields->addFieldToTab(
            'Root.Main',
            singleton('Product')->editableGrid('Products', 'Products', $this->owner->getProductsForGrid())
        );
    }
    public function ProductList() {
        return Product::get();
    }
}