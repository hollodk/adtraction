<?php

require_once(__DIR__.'/vendor/autoload.php');

$adtraction = new \Mh\Adtraction\Adtraction([
    'token' => 'MY_TOKEN',
]);

dump($adtraction->getMarkets());

dump($adtraction->getChannels());

dump($adtraction->getPrograms('DK', '1420540963'));

dump($adtraction->getNewPartners('1'));
