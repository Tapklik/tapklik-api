<?php namespace App\Transformers;

use App\Log;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class LogTransformer extends TransformerAbstract
{

    /**
     * @param \App\Log $log
     *
     * @return array
     */
    public function transform(Log $log)
    {

        return [
            'action' => $log->action,
            'taken_at' => $log->created_at
        ];
    }
}
