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

    /**
     * @var array
     */
    protected $availableIncludes = ['users'];

    /**
     * @param \App\Account $account
     *
     * @return array
     */
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

    /**
     * @param \App\Account $account
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUsers(Account $account)
    {

        return $this->collection($account->users, new UserTransformer());
    }
}
