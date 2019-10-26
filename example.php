<?php

require_once(__DIR__.'/vendor/autoload.php');

$adtraction = new \Mh\Adtraction\Adtraction([
    'token' => 'MY_TOKEN',
]);

$res = $adtraction->getMarkets();

$res = $adtraction->getChannels();

$res = $adtraction->getNewPartners('1');

$res = $adtraction->getPrograms('DK', '1420540963');

$res = $adtraction->getProgram('DK', '1420540963', $res[0]->programId);

$res = $adtraction->getAds('DK', '1420540963', '1272117412');
