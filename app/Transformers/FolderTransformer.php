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

    public function transform(Folder $folder)
    {

        return [
            'id'     => $folder->uuid,
            'name'   => $folder->name,
            'status' => $folder->status,
        ];
    }
}
