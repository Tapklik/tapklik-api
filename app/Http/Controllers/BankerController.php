<?php namespace App\Http\Controllers;

use App\Banker;
use App\Transformers\BankerBalanceTransformer;
use App\Transformers\BankerTransformer;
use Carbon\Carbon;
use Illuminate\Http\Response;

/**
 * Class BankerController
 *
 * @package App\Http\Controllers
 */
class BankerController extends Controller
{

    /**
     * @var array
     */
    private $_allowedModelBag = [
        'campaigns' => 'Campaign',
        'accounts'  => 'Account'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid)
    {
        try {
            $model = $this->_getModel();
            $obj = $model::findByUuId($uuid);

            if($this->req->get('query') == 'balance') return $this->getBalance($uuid);

            return $this->collection($obj->banker, new BankerTransformer);

        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * @param $uuid
     *
     * @return array
     */
    public function getBalance($uuid)
    {
        $model = $this->_getModel();
        $obj = $model::findByUuId($uuid);

        return $this->item($obj, new BankerBalanceTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function store($uuid)
    {
        try {
            $model = $this->_getModel();

            $obj = $model::findByUuId($uuid);

            $banker = new Banker([
                'uuid'        => request('id') ?: '',
                'updated_at'  => request('timestamp') ?: Carbon::now(),
                'debit'       => request('debit') ?: 0,
                'credit'      => request('credit') ?: 0,
                'description' => request('description') ?: '',
            ]);

            $obj->banker()->save($banker);

            return $this->item($banker, new BankerTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    private function _getModel()
    {
        $model = $this->_allowedModelBag[$this->parentEndpoint];
        $model = "App\\{$model}";

        return new $model();
    }
}
