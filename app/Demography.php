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
    public static function saveDemography(array $gender = [], int $from_age = 18, int $to_age = 55, string
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

    // Getters
    public function getGenderAttribute($value)
    {
        return ($value == "O") ? ["F", "M"] : [$value];
    }

    // Getters
    public function setGenderAttribute($value) {

        if(!$value) $value = ['M', 'F'];

        $this->attributes['gender'] = (count($value) == 2) ? 'O' : implode('', $value);
    }

}
