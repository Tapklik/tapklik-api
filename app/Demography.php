<?php namespace App;


use Exception;

class Demography extends ModelSetup
{

    /**
     * @param string $gender
     * @param int    $from_age
     * @param int    $to_age
     *
     * @param string $campaignId
     *
     * @return mixed
     * @throws \Exception
     * @internal param string $uuid
     *
     */
    public static function saveDemography(string $gender = "O", int $from_age = 18, int $to_age = 55, string
    $campaignId =
    '')
    {

        try {
            return self::create(
                [
                    'gender'      => $gender,
                    'from_age'    => $from_age,
                    'to_age'      => $to_age,
                    'campaign_id' => $campaignId,
                ]
            );
        } catch (Exception $e) {

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
