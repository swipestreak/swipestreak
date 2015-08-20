<?php

class StreakCountriesBuild extends DataObject {
    public function requireTable() {
        DB::dontRequireTable(__CLASS__);
    }
    public function requireDefaultRecords() {
        if (!Country_Shipping::get()->filter('Code', 'NZ')->count()) {
            $country = new Country_Shipping(
                [
                    'Code' => 'NZ',
                    'Title' => 'New Zealand'
                ]
            );
            $country->write();
            DB::alteration_message("Added 'New Zealand' to shipping countries", "changed");
        }
    }
}