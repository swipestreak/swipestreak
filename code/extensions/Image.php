<?php

/**
 * Add to Image class to get back-link to StreakHasImages extension
 */
class StreakImageExtension extends DataExtension {
    private static $belongs_many_many = array(
        'Products' => 'Product',
        'Variants' => 'Variant'
    );
}