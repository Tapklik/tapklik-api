<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelSetup
 *
 * @package App
 */
class ModelSetup extends Model
{

    /**
     * @var array
     */
    protected $guarded = ['id', 'uuid'];
}
