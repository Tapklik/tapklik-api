<?php namespace App\Transformers;


use App\Creative;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class ErlangCreativeTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['attr'];


    /**
     * @param \App\Campaign $campaign
     *
     * @return array
     */
    public function transform(Creative $creative)
    {

        if ($creative->status == '') {
            return '';
        }

        return [
            'crid'       => $creative->uuid,
            'class'      => $creative->class,
            'type'       => $creative->type,
            'h'          => $creative->h,
            'w'          => $creative->w,
            'attr'       => $creative->attr,
            'expdir'     => $creative->expdir,
            'pos'        => $creative->pos,
            'ctrurl'     => $creative->ctrurl,
            'iurl'       => $creative->iurl,
            'adm'        => $creative->adm,
            'adm_js'     => $creative->adm_js,
            'adm_iframe' => $creative->adm_iframe,
            'adm_url'    => $creative->adm_url,
            'path'       => $this->_parseUrl($creative->iurl),
            'dim'        => [$creative->w.'x'.$creative->h],
            'status'     => $creative->status,
	    ];
    }

    private function _parseUrl(string $url) {

    	$url = parse_url($url);
    	$path = explode('/', $url['path']);
    	$path = array_pop($path);
    	$path = implode('/', $path);

    	return $url['scheme'] . '://' . $url['host'] . '/' . $path;
    }

    public function includeAttr(Creative $creative)
    {

        return $this->collection($creative->attributes, new AttrTransformer);
    }

}
