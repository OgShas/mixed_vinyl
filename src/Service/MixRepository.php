<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
class MixRepository
{
    private $httpClient;
    private $cache;
    private bool $isDebug;
    private $twigDebugCommand;

public function __construct(HttpClientInterface $httpClient,CacheInterface $cache,  #[Autowire('%kernel.debug%')] $isDebug,DebugCommand $twigDebugCommand)
{
    $this->cache=$cache;
    $this->httpClient=$httpClient;
    $this->isDebug=$isDebug;
    $this->twigDebugCommand=$twigDebugCommand;
}
    public function findAll() : array
    {

             return $this->cache->get('mixes_data',function (CacheItemInterface  $cacheItem)
             {
                  $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
                  $responese=$this->httpClient->request('GET','https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');

                  return  $responese->toArray();
           });
    }
}