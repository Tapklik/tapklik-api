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

//    public function setAmountAttribute($value) {
//
//        $this->attributes['amount'] = $value * 1000000;
//    }
//
//    public function getAmountAttribute($value)
//    {
//        return number_format($value / 1000000, 2);
//    }
}
