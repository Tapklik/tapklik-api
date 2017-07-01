<?php namespace App;

/**
 * Class Budget
 *
 * @package App
 */
class Budget extends ModelSetup
{

    public static function deleteForCampaignId($id)
    {
        $budgets = self::where(['campaign_id' => $id]);

        if(!$budgets->count()) return;

        $budgets->get()->each(function ($budget) {
            $budget->delete();
        });
    }
}
