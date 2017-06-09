<?php namespace App;

/**
 * Class AdvertiserDomain
 *
 * @package App
 */
class AdvertiserDomain extends ModelSetup
{
    // Methods

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByCampaignUuId($uuid)
    {
        return Campaign::findByUuId($uuid)->advertiserDomains;
    }
}
