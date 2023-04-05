<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{
    private $httpClient;
    private $cache;

public function __construct(HttpClientInterface $httpClient,CacheInterface $cache)
{
    $this->cache=$cache;
    $this->httpClient=$httpClient;
}
    public function findAll() : array
    {
             return $this->cache->get('mixes_data',function (CacheItemInterface  $cacheItem)
             {
                  $cacheItem->expiresAfter(5);
                  $responese=$this->httpClient->request('GET','https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');

                  return  $responese->toArray();
           });
    }
}