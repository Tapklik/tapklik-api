<?php namespace App;

class Exchange extends ModelSetup
{
    // Relationships

    // Methods
    public static function findByCampaignUuId($uuid) {

        return Campaign::findByUuId($uuid)->exchanges;
    }
}
