<?php namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {

        return [
            'id'         => $user->uuid,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'name'       => $user->first_name.' '.$user->last_name,
            'email'      => $user->email,
            'phone'      => $user->phone,
        ];
    }
}
