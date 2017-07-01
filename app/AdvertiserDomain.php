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

    public static function deleteForCampaignId($id)
    {
        $advertiserDomains = self::where(['campaign_id' => $id]);

        if(!$advertiserDomains->count()) return;

        $advertiserDomains->each(function($adomain) {
            $adomain->delete();
        });
    }
}
