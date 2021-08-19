<?php

namespace Helpers;

use HubSpot\Discovery\Discovery;
use HubSpot\Factory;

class HubspotClientHelper
{
    public static function createFactory(): Discovery
    {
        if (OAuth2Helper::isAuthenticated()) {
            $accessToken = OAuth2Helper::refreshAndGetAccessToken();

            return Factory::createWithAccessToken($accessToken);
        }

        throw new \Exception('Please authorize via OAuth');
    }

    public static function createFactoryWithDeveloperAPIKey(): Discovery
    {
        return Factory::createWithApiKey(
            getEnvOrException('HUBSPOT_DEVELOPER_API_KEY')
        );
    }
}
