<?php

namespace App\NotificationPublisher\Infrastructure\Services\Push;

use Doctrine\Common\Collections\ArrayCollection;

readonly class PushProvidersRegistry
{
    public function __construct(private iterable $pushProviders)
    {
    }

    /**
     * @return ArrayCollection<PushProvider>
     */
    public function getProviders(): ArrayCollection
    {
        $providers = new ArrayCollection();
        foreach ($this->pushProviders as $provider) {
            if ($provider instanceof PushProvider) {
                $providers->add($provider);
            }
        }

        return $providers;
    }
}
