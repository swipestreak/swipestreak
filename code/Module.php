<?php
class StreakModule extends Object {
    const CMSTabName = 'Root.Store';
    const CurrencySchema = 'Varchar(3)';
    const PriceSchema = 'Decimal(19,8)';

    private static $cms_tab_name = self::CMSTabName;

    public static function cms_tab_name() {
        return self::config()->get('cms_tab_name');
    }


}