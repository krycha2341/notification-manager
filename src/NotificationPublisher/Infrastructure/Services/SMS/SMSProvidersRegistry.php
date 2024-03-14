<?php

namespace App\NotificationPublisher\Infrastructure\Services\SMS;

use Doctrine\Common\Collections\ArrayCollection;

readonly class SMSProvidersRegistry
{
    public function __construct(private iterable $smsProviders)
    {
    }

    /**
     * @return ArrayCollection<SMSProvider>
     */
    public function getProviders(): ArrayCollection
    {
        $providers = new ArrayCollection();
        foreach ($this->smsProviders as $provider) {
            if ($provider instanceof SMSProvider) {
                $providers->add($provider);
            }
        }

        return $providers;
    }
}
