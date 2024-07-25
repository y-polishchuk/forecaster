<?php

namespace App\Twig;

use App\Repository\LocationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public function __construct(
      private LocationRepository $locationRepository, 
      private CacheInterface $cache,
      private LoggerInterface $logger
      )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_locations', [$this, 'getLocations']),
        ];
    }

    public function getLocations()
    {
      try {
        return $this->cache->get('locations_list', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->locationRepository->findAll();
        });
      } catch (\Exception $e) {
        $this->logger->error('Error retrieving locations: ' . $e->getMessage(), ['exception' => $e]);
        return [];
      }
    }
}