<?php namespace App;

/**
 * Class Exchange
 *
 * @package App
 */
class Exchange extends ModelSetup
{
    // Relationships

    // Methods
    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByCampaignUuId($uuid) {

        return Campaign::findByUuId($uuid)->exchanges;
    }
}
