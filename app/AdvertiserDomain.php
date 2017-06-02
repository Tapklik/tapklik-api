<?php namespace App;

class AdvertiserDomain extends ModelSetup
{
    // Methods
    public static function findByCampaignUuId($uuid)
    {
        return Campaign::findByUuId($uuid)->advertiserDomains;
    }
}
