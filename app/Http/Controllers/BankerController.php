<?php namespace App\Http\Controllers;

use App\Exceptions\TransformerException;
use App\Transformers\BankerTransformer;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

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

    private $_allowedRelationshipsBag = [
        'main', 'flight', 'spend'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     *
     * @param $relationship
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid, $relationship)
    {
        return ($this->req->get('query')) ?
           $this->_filter($uuid, $this->req->get('query'), $relationship) :
           $this->_report($uuid, $relationship, $this->req->input('type'));
    }

    private function _report($uuid, $relationship, $type = false)
    {
        try {

            $model        = $this->_getModel();
            $obj          = $model::findByUuId($uuid);

            $relationship = ucfirst(strtolower($relationship));
            $query = $obj->{$relationship}();

            if($type) $query->where(['type' => $type]);

            return $this->collection($query->get(), new BankerTransformer);
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
    private function _filter(string $uuid, string $query, $relationship, $type = false)
    {
        $transformer = $this->_getTransformer($query);
        $model       = $this->_getModel();
        $obj         = $model::findByUuId($uuid);
        $relationship = strtolower($relationship);

        return $this->item($obj, $transformer);
    }

    private function _getTransformer(string $query)
    {
        $lookUpTransformer = "App\\Transformers\\Banker" . ucfirst(strtolower($query)) . 'Transformer';

        if(!class_exists($lookUpTransformer)) throw new TransformerException('Transformer ' . $lookUpTransformer . ' does not exist');

        return new $lookUpTransformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     *
     * @param $relationship
     *
     * @return \Illuminate\Http\Response
     */
    public function store($uuid, $relationship)
    {

        try {
            $model             = $this->_getModel();
            $obj               = $model::findByUuId($uuid);
            $rel               = strtolower($relationship);
            $relationshipModel = 'App\\Banker' . ucfirst($rel);

            $systemGeneratedUuid = Uuid::uuid1();

            $banker = new $relationshipModel([
                'uuid'        => request('uuid') ?: $systemGeneratedUuid,
                'updated_at'  => request('timestamp') ?: Carbon::now(),
                'debit'       => request('debit') ?: 0,
                'credit'      => request('credit') ?: 0,
                'description' => request('description') ?: '',
                'type'        => request('type') ?: 'system'
            ]);

            $obj->{$rel}()->save($banker);

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

    private function _getModel()
    {
        $model = $this->_allowedModelBag[$this->parentEndpoint];
        $model = "App\\{$model}";

        return new $model();
    }

    private function _getRelationship() {}
}
