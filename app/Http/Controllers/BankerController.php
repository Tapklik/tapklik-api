<?php namespace App\Http\Controllers;

use App\Banker;
use App\Exceptions\TransformerException;
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
        if($this->req->get('query')) return $this->_filter($uuid, $this->req->get('query'));

        try {
            $model = $this->_getModel();
            $obj = $model::findByUuId($uuid);

            return $this->collection($obj->banker, new BankerTransformer);

        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * @param string $uuid
     *
     * @param string $query
     *
     * @return array
     */
    private function _filter(string $uuid, string $query)
    {
        $transformer = $this->_getTransformer($query);
        $model = $this->_getModel();
        $obj = $model::findByUuId($uuid);

        return $this->item($obj, $transformer);
    }

    private function _getTransformer(string $query)
    {
        $lookUpTransformer = "App\Transformers\\Banker" . ucfirst(strtolower($query)) . 'Transformer';

        if(!class_exists($lookUpTransformer)) throw new TransformerException('Transformer ' . $lookUpTransformer . ' does not exist');

        return new $lookUpTransformer;
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
                'uuid'        => request('id') ?: null,
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

    public function destroy($uuid)
    {
        try {
            $model = $this->_getModel();
            $obj = $model::findByUuId($uuid);

            $obj->banker()->delete();

            return $this->collection($obj->banker, new BankerTransformer);

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
