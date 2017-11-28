<?php namespace App\Http\Controllers;

use App\Http\Response\FractalResponse;
use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @var \Illuminate\Http\Request
     */
    protected $req;

    /**
     * @var \App\Http\Response\FractalResponse
     */
    private $_fractal;

    /**
     * @var string
     */
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

        return $currentJwtSession->get($claim) ?? '';
    }

    /**
     * Return an error response.
     *
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

    /**
     * Sets appropriate endpoint.
     */
    private function _setCurrentEndpoint()
    {
        $rootUriSegment = collect(
            explode('/', $this->req->getUri())
        );

        $this->parentEndpoint = $rootUriSegment->offsetGet(4);
    }

    protected function logActionToLoggerProvider($sentence, $attr = [])
    {

        return true;

        if(!$attr) $attr = [
            'id'   => $this->getJwtUserClaim('id'),
            'name' => $this->getJwtUserClaim('name')
        ];


        $client = new Client([
            'base_uri' => env('LOGGLY_URI')
        ]);

        try {
            $client->post('inputs/67a90950-78f3-4a24-86be-0a57c3461280/tag/account-' . $attr['id'], [
                'json' => [
                    'message' => $sentence,
                    'attr'    => $attr,
                ]
            ]);
        } catch (GuzzleException $e) {
            // drop it here
            //dd('UserActionLogger Middleware:' . $e->getMessage());
        }
    }
}
