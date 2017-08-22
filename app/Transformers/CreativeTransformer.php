<?php namespace App\Transformers;

use App\Creative;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class CreativeTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['attr'];

    /**
     * @param \App\Creative $creative
     *
     * @return array
     */
    public function transform(Creative $creative)
    {

        return [
            'id'         => $creative->uuid,
            'class'      => $creative->class,
            'name'       => $creative->name,
            'h'          => $creative->h,
            'w'          => $creative->w,
            'responsive' => (bool) $creative->responsive,
            'expdir'     => $creative->expdir,
            'adm'        => $creative->adm,
            'ctrurl'     => $creative->ctrurl,
            'iurl'       => $creative->iurl,
            'type'       => (int) $creative->type,
            'pos'        => $creative->pos,
            'approved'   => $creative->status,
            'folder'     => ['key' => $creative->folder->id, 'name' => $creative->folder->name],
        ];
    }
    
     public function includeAttr(Creative $creative)
     {
         return $this->collection($creative->attributes, new AttrTransformer);
     }
}
