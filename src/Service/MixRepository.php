<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
class MixRepository
{
    private $githubContentClient;
    private $cache;
    private bool $isDebug;
    private $twigDebugCommand;

public function __construct(HttpClientInterface $githubContentClient,CacheInterface $cache,
                            #[Autowire('%kernel.debug%')] bool $isDebug,
                            #[Autowire(service: 'twig.command.debug')]   DebugCommand $twigDebugCommand  )
{
    $this->cache=$cache;
    $this->githubContentClient=$githubContentClient;
    $this->isDebug=$isDebug;
    $this->twigDebugCommand=$twigDebugCommand;
}
    public function findAll() : array
    {        /*
             $output=new BufferedOutput();
             $this->twigDebugCommand->run(new ArrayInput([]),$output);
             dd($output);
              */


             return $this->cache->get('mixes_data',function (CacheItemInterface  $cacheItem)
             {
                  $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
                  $responese=$this->githubContentClient->request('GET','/SymfonyCasts/vinyl-mixes/main/mixes.json');

                  return  $responese->toArray();
           });
    }
}