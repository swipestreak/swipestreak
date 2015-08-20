<?php
/**
 * Store page shows all products as a gridfield.
 */
class StreakProductsPage extends Page {
    private static $db = array();

    private static $has_one = array();

    public function getProductsForGrid() {
        return Product::get();
    }

}