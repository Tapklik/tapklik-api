<?php namespace App\Http\Controllers;

use App\Http\Response\FractalResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal\Manager;

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

    protected $req;

    /**
     * Controller constructor.
     *
     * @param \App\Http\Response\FractalResponse $fractal
     *
     * @internal param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request, FractalResponse $fractal)
    {

        $this->_fractal = $fractal;

        $this->req = $request;

        $this->_parseIncludes($request);
    }

    private function _parseIncludes(Request $request) {

        if( ! $includes = $request->get('include')) return;

        $fractalManager = new Manager();
        $fractalManager->parseIncludes($includes);
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

    protected function error($code = Response::HTTP_NOT_FOUND, $message = "There was an error", $details = "N/A")
    {

        return response()->json(
            [
                'error' => [
                    'code'    => $code,
                    'message' => $message,
                    'details' => $details,
                    'request' => '' // create a hash function that will match the logs
                ],
            ],
            $code
        );
    }
}
