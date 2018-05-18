<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class Category
 *
 * @package App
 */
class Report extends Model
{

	protected $connection = 'mysql-reports';

	

    
    // Methods

    /**
     * @param $code
     *
     * @return mixed
     */

    public function getSums(Request $request) 
    {

    	$acc = $request->acc;
    	$cmp = $request->cmp;
    	$crid = $request->crid;
    	$from = $request->from;
    	$to = $request->to;
    	$fields = explode(',', $request->fields);

    	$select = 'acc,';
    	if($cmp != '') $select .= 'cmp,';
    	if($crid != '') $select .= 'crid,';
    		
    	$sumFields = rtrim(array_reduce($fields, "self::getSumFields"), ',');

    	$groupBy = explode(',', $select . 'timestamp');

    	$report = $this
    				->selectRaw($select . 'timestamp,' . $sumFields)
    				->groupBy($groupBy)
    				->whereIn('acc', explode(',' , $acc))
    				->whereBetween('timestamp', [$from, $to]);

    	if($cmp != '') $report->whereIn('cmp', explode(',' , $cmp));
    	if($crid != '') $report->whereIn('crid', explode(',' , $crid));	
    	    	
    	return $report->get();
    }

    public function getSummary(Request $request) 
    {

    	$acc = $request->acc;
    	$cmp = $request->cmp;
    	$crid = $request->crid;
    	$from = $request->from;
    	$to = $request->to;
    	$fields = explode(',', $request->fields);
    		
    	$sumFields = rtrim(array_reduce($fields, "self::getSumFields"), ',');

    	$report = $this
    				->selectRaw($sumFields)
    				->whereIn('acc', explode(',' , $acc))
    				->whereBetween('timestamp', [$from, $to]);

    	if($cmp != '') $report->whereIn('cmp', explode(',' , $cmp));
    	if($crid != '') $report->whereIn('crid', explode(',' , $crid));	
    	    	
    	return $report->get();
    }

    public static function getSumFields($carry, $item) {
 		$carry = $carry . 'COALESCE(SUM(' . $item . '), 0) AS ' . $item . ',';
    	return $carry;
    }
   
}

