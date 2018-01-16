<?php namespace App\Transformers;

use App\AccountExchange;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AccountExchangeTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param \App\AccountExchange $exchange
     *
     * @return array
     */
    public function transform(AccountExchange $exchange)
    {

        return ['id'        => $exchange->identifier,
                'name'      => $exchange->name,
                'endpoint'  => $exchange->endpoint,
                'seatId'    => $exchange->seatId,
                'billingId' => $exchange->billingId,
                'token'     => $exchange->token,
                'prefix'    => $exchange->prefix,
                'postfix'   => $exchange->postfix,];
    }
}
