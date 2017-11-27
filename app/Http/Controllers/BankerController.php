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
    private $_allowedModelBag
        = ['campaigns' => 'Campaign',
           'accounts'  => 'Account'];

    /**
     * @var array
     */
    private $_allowedRelationshipsBag
        = ['main',
            'flight',
            'spend'];

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

        return ($this->req->get('query')) ? $this->_filter($uuid, $this->req->get('query'), $relationship)
            : $this->_report($uuid, $relationship, $this->req->input('type'));
    }

    /**
     * Return data based on used filters
     *
     * @param string $uuid
     *
     * @param string $query
     *
     * @param        $relationship
     * @param bool   $type
     *
     * @return array
     */
    private function _filter(string $uuid, string $query, $relationship, $type = false)
    {

        $transformer  = $this->_getTransformer($query);
        $model        = $this->_getModel();
        $obj          = $model::findByUuId($uuid);
        $relationship = strtolower($relationship);

        return $this->item($obj, $transformer);
    }

    /**
     * Guess appropriate transformer to be used.
     *
     * @param string $query
     *
     * @return mixed
     * @throws \App\Exceptions\TransformerException
     */
    private function _getTransformer(string $query)
    {

        $lookUpTransformer = "App\\Transformers\\Banker".ucfirst(strtolower($query)).'Transformer';

        if ( !class_exists($lookUpTransformer))
            throw new TransformerException('Transformer '.$lookUpTransformer.' does not exist');

        return new $lookUpTransformer;
    }

    /**
     * Returns the instance of a polymorphic model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function _getModel()
    {

        $model = $this->_allowedModelBag[$this->parentEndpoint];
        $model = "App\\{$model}";

        return new $model();
    }

    /**
     * Return all banker entries.
     * You may limit result-set further by applying the type query string.
     *
     * @param      $uuid
     * @param      $relationship
     * @param bool $type
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function _report($uuid, $relationship, $type = false)
    {

        try {

            $model = $this->_getModel();
            $obj   = $model::findByUuId($uuid);

            $relationship = ucfirst(strtolower($relationship));
            $query        = $obj->{$relationship}();

            if ($type)
                $query->where(['type' => $type]);

            return $this->collection($query->get(), new BankerTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
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
            $relationshipModel = 'App\\Banker'.ucfirst($rel);

            $systemGeneratedUuid = Uuid::uuid1();

            $banker = new $relationshipModel(
                ['uuid'           => request('uuid') ?: $systemGeneratedUuid,
                 'updated_at'     => request('timestamp') ?: Carbon::now(),
                 'debit'          => request('debit') ?: 0,
                 'credit'         => request('credit') ?: 0,
                 'description'    => request('description') ?: '',
                 'invoice_id'     => request('invoice_id') ?: '',
                 'transaction_id' => request('transaction_id') ?: '',
                 'type'           => request('type') ?: 'system']
            );

            $obj->{$rel}()->save($banker);

            return $this->item($banker, new BankerTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Delete entry from appropriate banker table.
     *
     * @param $uuid
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {

        try {
            $model = $this->_getModel();
            $obj   = $model::findByUuId($uuid);

            $obj->banker()->delete();

            return $this->collection($obj->banker, new BankerTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }
}
