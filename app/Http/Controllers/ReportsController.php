<?php namespace App\Http\Controllers;

use App\Report;
use App\Transformers\ReportTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ExchangeController
 *
 * @package App\Http\Controllers
 */
class ReportsController extends Controller
{
    protected $connection = 'mysql-reports';

    public function get($table, Request $request)
    {
        try {

            $this->validate($request, [
                'op'            => 'required',
                'from'          => 'required',
                'to'            => 'required',
                'acc'           => 'required',
                'cmp'           => 'nullable',
                'crid'          => 'nullable',
                'device_type'   => 'nullable',
                'country'       => 'nullable',
                'scale'         => 'nullable'
            ]);

            $report = new Report;
            $report->setTable($table);

            switch($request->op) {
                case 'sum':
                     $report = $report->getSums($request);
                     break;
                case 'summary':
                     $report = $report->getSummary($request);
                     break;
                case 'raw':
                     $report = $report->getRaw($request);
            }
           
            return (new ReportTransformer($request->from, $request->to, $request->scale, $request->fields))->transform($report, $request->op);

        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Exchange not found');
        }
    }
}
