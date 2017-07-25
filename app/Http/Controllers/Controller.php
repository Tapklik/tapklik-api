<?php namespace App\Http\Controllers;

use App\Http\Middleware\JWT;
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
     * @var \Illuminate\Http\Request
     */
    protected $req;

    /**
     * @var \App\Http\Response\FractalResponse
     */
    private $_fractal;

    protected $parentEndpoint = '';

    /**
     * Controller constructor.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \App\Http\Response\FractalResponse $fractal
     *
     * @internal param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request, FractalResponse $fractal)
    {

        $this->_fractal = $fractal;
        $this->req      = $request;

        $this->_setCurrentEndpoint();
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

    /**
     * Returns a claim from passed JWT token
     *
     * @param string $claim
     *
     * @return string
     */
    public function getJwtUserClaim(string $claim) : string
    {
        $currentJwtSession = collect($this->req->attributes->get('session'));

        return $currentJwtSession->get($claim);
    }

    /**
     * @param int    $code
     * @param string $message
     * @param string $details
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    private function _setCurrentEndpoint()
    {
        $rootUriSegment = collect(
            explode('/', $this->req->getUri())
        );

        $this->parentEndpoint = $rootUriSegment->offsetGet(4);
    }
}
