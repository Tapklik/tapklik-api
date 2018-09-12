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
    
    protected $availableIncludes = ['campaigns'];

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
            'adm'        => $creative->adm ?: Creative::generateAdm('', $creative->uuid),
            'adm_js'     => $creative->adm_js ?: Creative::generateAdm('', $creative->uuid, 'js'),
            'adm_iframe' => $creative->adm_iframe ?: Creative::generateAdm('', $creative->uuid, 'iframe'),
            'adm_url'    => $creative->adm_url ?: Creative::generateAdm('', $creative->uuid, 'url'),
            'ctrurl'     => $creative->ctrurl,
            'iurl'       => $creative->iurl,
            'thumb'      => $creative->thumb ?: 'http://placehold.it/' . $creative->w . 'x' . $creative->h,
            'html'       => $creative->html ?: '',
            'asset'      => $creative->asset ?: '',
            'type'       => (int) $creative->type,
            'pos'        => $creative->pos,
            'approved'   => $creative->status,
            'folder'     => ['key' => $creative->folder->id, 'name' => $creative->folder->name],
            'uploaded_at' => $creative->created_at
        ];
    }
    
     public function includeAttr(Creative $creative)
     {
         return $this->collection($creative->attributes, new AttrTransformer);
     }
     
     public function includeCampaigns(Creative $creative)
     {
         return $this->collection($creative->campaign, new CampaignTransformer);
     }
}
