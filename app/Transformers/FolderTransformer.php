<?php namespace App\Transformers;

use App\Folder;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class FolderTransformer extends TransformerAbstract
{

    /**
     * @param \App\Folder $folder
     *
     * @return array
     */
    public function transform(Folder $folder)
    {

        return [
            'id'     => $folder->uuid,
            'name'   => $folder->name,
            'status' => $folder->status,
            'items'  => $folder->creatives()->count(),
            'key'    => $folder->id,
        ];
    }
}
