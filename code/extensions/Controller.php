<?php
class StreakControllerExtension extends Extension {
    public function onAfterInit() {
        Requirements::themedCSS('swipestreak');
        Requirements::javascript('framework/thirdparty/jquery/jquery.min.js');
        Requirements::javascript('framework/thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript('swipestreak/js/swipestreak.js');
    }
}