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

    	$device_type = $request->device_type;
    	$country = $request->country;

    	$from = $request->from;
    	$to = $request->to;
    	$fields = explode(',', $request->fields);

    	$scale = $request->scale;

    	$result = [];

    	switch($scale) {
    		case 'dd':
    			$timestamp = 'DATE_FORMAT(timestamp, "%Y-%m-%d")';
    			break;
    		case 'mm':			
		      	$timestamp = 'DATE_FORMAT(timestamp, "%Y-%m")';
    			break;
    		default:
    			$timestamp = 'timestamp';
    	}

    	$select = '';
    	if($device_type != '') $select .= 'device_type,';
    	if($country != '') $select .= 'country,';

    		
    	$sumFields = rtrim(array_reduce($fields, "self::getSumFields"), ',');

    	$groupBy = explode(',', $select . 'time');

    	$report = Report::selectRaw($select . $timestamp . ' AS time,' . $sumFields)
    				->groupBy($groupBy)
    				->whereIn('acc', explode(',' , $acc))
    				->whereBetween('timestamp', [$from, $to])
    				->orderBy('time');

    	if($cmp != '') $report->whereIn('cmp', explode(',' , $cmp));
    	if($crid != '') $report->whereIn('crid', explode(',' , $crid));	

    	if($device_type != '') $report->whereIn('device_type', explode(',' , $device_type));	
    	if($country != '') $report->whereIn('country', explode(',' , $country));	
    	    	
    	return $report->get();
    }

    public function getSummary(Request $request) 
    {

    	$acc = $request->acc;
    	$cmp = $request->cmp;
    	$crid = $request->crid;

		$device_type = $request->device_type;
    	$country = $request->country;

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

    	if($device_type != '') $report->whereIn('device_type', explode(',' , $device_type));	
    	if($country != '') $report->whereIn('country', explode(',' , $country));	
    	    	
    	return $report->get();
    }

    public static function getSumFields($carry, $item) {
 		$carry = $carry . 'IFNULL(SUM(' . $item . '), 0) AS ' . $item . ',';
    	return $carry;
    }
   
   
}

