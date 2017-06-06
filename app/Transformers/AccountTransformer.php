<?php namespace App\Transformers;

use App\Account;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AccountTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['users'];

    public function transform(Account $account)
    {

        return [
            'id'           => $account->uuid,
            'name'         => $account->name,
            'localization' => [
                'country'  => $account->country,
                'city'     => $account->city,
                'timezone' => $account->timezone,
                'language' => $account->language,
            ],
            'status'       => $account->status,
        ];
    }

    public function includeUsers(Account $account)
    {

        return $this->collection($account->users, new UserTransformer());
    }
}