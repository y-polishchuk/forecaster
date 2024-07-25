<?php

namespace App\EventListener;

use App\Entity\Location;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class LocationEventListener
{
  public function __construct(
    private CacheInterface $cache, 
    private LoggerInterface $logger
    )
  {
  }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->invalidateCache($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->invalidateCache($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->invalidateCache($args);
    }

    private function invalidateCache(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Location) {
          try {
            $this->logger->info('Invalidating location cache');
            $this->cache->delete('locations_list');
        } catch (\Exception $e) {
            $this->logger->error('Failed to invalidate location cache', [
                'exception' => $e
            ]);
        }
        }
    }
}