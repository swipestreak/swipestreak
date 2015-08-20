<?php
class StreakAccessoryPage extends StreakProductsPage {
    private static $singular_name = 'Accessory Page';

    private static $db = array();

    private static $has_one = array();

    private static $belongs_many_many = array(
        'Products' => 'Product'
    );
}