<?php namespace App\Http\Controllers;

use App\Http\Response\FractalResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Http\Response\FractalResponse
     */
    private $_fractal;

    /**
     * Controller constructor.
     *
     * @param \App\Http\Response\FractalResponse $fractal
     */
    public function __construct(FractalResponse $fractal) {

        $this->_fractal = $fractal;
    }

    /**
     * Returns a collection resource
     *
     * @param      $data
     * @param      $transformer
     * @param null $resource
     *
     * @return array
     */
    public function collection($data, $transformer, $resource = null)
    {
        return $this->_fractal->collection($data, $transformer, $resource);
    }

    /**
     * Returns an array of one item
     *
     * @param      $data
     * @param      $transformer
     * @param null $resource
     *
     * @return array
     */
    public function item($data, $transformer, $resource = null)
    {
        return $this->_fractal->item($data, $transformer, $resource);
    }
}
