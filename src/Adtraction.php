<?php

namespace Mh\Adtraction;

/**
 * Adtraction
 */
class Adtraction
{
    private $token = null;

    public function __construct(array $option)
    {
        $this->token = $option['token'];
    }

    public function getMarkets()
    {
        $uri = 'markets/?token='.$this->token;

        return $this->_request($uri);
    }

    public function getChannels()
    {
        $uri = 'channels/?token='.$this->token;

        return $this->_request($uri);
    }

    public function getOffers($market)
    {
        $uri = 'offers/?token='.$this->token;

        $client = new \GuzzleHttp\Client();

        $body = new \StdClass();
        $body->market = $market;

        return $this->_request($uri, 'POST', $body);
    }

    public function getPrograms($market)
    {
        if (strlen($market) != 2) {
            throw new \Exception('Has to be DK, SE or simular');
        }

        $uri = 'programs/?token='.$this->token.'&market='.$market;

        return $this->_request($uri);
    }

    public function getProgram($market, $channelId, $programId)
    {
        if (strlen($market) != 2) {
            throw new \Exception('Has to be DK, SE or simular');
        }

        if (!preg_match("/^\d+$/", $channelId)) {
            throw new \Exception('ChannelId has to be numeric');
        }

        $uri = 'programs/?token='.$this->token.'&market='.$market.'&channelId='.$channelId.'&programId='.$programId;

        return $this->_request($uri)[0];
    }

    public function getNewPartners($marketId)
    {
        if (!preg_match("/^\d+$/", $marketId)) {
            throw new \Exception('MarketId has to be numeric');
        }

        $uri = 'programs/new/'.$marketId.'/?token='.$this->token;

        return $this->_request($uri);
    }

    private function _request($uri, $method='GET', $body=null)
    {
        $url = sprintf('https://api.adtraction.com/v2/affiliate/%s', $uri);

        if ($body != null) {
            $body = json_encode($body);
        }

        $client = new \GuzzleHttp\Client();
        $res = $client->request($method, $url, [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
            ],
        ]);

        $headers = $res->getHeaders();
        $remaining = preg_replace("/: /", "", $headers['X-RateLimit-Remaining'][0]);

        if ($remaining < 2) {
            throw new \Exception('too many api calls, slow down');
        }

        return json_decode($res->getBody()->getContents());
    }

}
