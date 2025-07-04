<?php

namespace App\Services\HubSpot;

use App\Models\Company;

class CompanyService
{
    protected HubSpotService $hubSpot;

    public function __construct(HubSpotService $hubSpot)
    {
        $this->hubSpot = $hubSpot;
    }

    public function sync(int $userId, HubSpotTokenManager $tokenManager): bool
    {
        // Get a fresh token (refreshing if expired)
        $token = $tokenManager->getAccessToken($userId);

        $response = $this->hubSpot->getCompanies($userId, $tokenManager);

        if (!isset($response['results'])) {
            logger()->error('Company sync failed', ['response' => $response]);
            return false;
        }

        foreach ($response['results'] as $item) {
            $props = $item['properties'] ?? [];

            Company::updateOrCreate(
                ['hubspot_id' => $item['id']],
                [
                    'name' => $props['name'] ?? null,
                    'domain' => $props['domain'] ?? null,
                ]
            );
        }

        return true;
    }
}
