<?php

namespace App\NotificationPublisher\Infrastructure\Services\Email;

use Doctrine\Common\Collections\ArrayCollection;

readonly class EmailProvidersRegistry
{
    public function __construct(private iterable $emailProviders)
    {
    }

    /**
     * @return ArrayCollection<EmailProvider>
     */
    public function getProviders(): ArrayCollection
    {
        $providers = new ArrayCollection();
        foreach ($this->emailProviders as $provider) {
            if ($provider instanceof EmailProvider) {
                $providers->add($provider);
            }
        }

        return $providers;
    }
}
