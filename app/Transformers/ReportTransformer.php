<?php namespace App\Transformers;


use App\Report;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

/**
 * Class ReportSumTransformer
 *
 * @package \app\Transformers
 */
class ReportTransformer extends TransformerAbstract
{


    function __construct($from, $to, $scale, $fields) {       
            $this->from = $from;   
            $this->to = $to;        
            $this->scale = $scale == null ? 'hh' : $scale;        
            $this->fields = $fields;
    }   


    public function transform(Collection $report, string $op)
    {
        $result = [];

        switch($op) {

            case 'sum':
                $zeros = $this->_fillDateGaps();

                $reportArray = $report->keyBy('time')->toArray();
                $result = array_values(array_merge($zeros, $reportArray));
                $resultFields = explode(',', 'time,' . $this->fields);
                break;

            case 'summary':
                $result = $report->toArray();                
                $resultFields = explode(',', $this->fields);
                break;

        }

        foreach( $result as $k=>$r ) {
                    $temp = [];
                    foreach( $resultFields as $field) {
                        $temp[$field] = $r[$field];
                    }
                    $result[$k] = $temp;
                }

        return json_encode($result);
    }


    private function _fillDateGaps() {

        $zeroData = [];
        $from = $this->from;
        $to = $this->to;
        $scale = $this->scale;

        switch($scale) {
            case 'dd':
                $period = new DatePeriod( new DateTime($from), new DateInterval('P1D'), new DateTime($to));
                foreach($period as $time){
                    $point = [
                        'time'      => $time->format("Y-m-d"),
                        'clicks'    => '0',
                        'imps'      => '0',
                        'wins'      => '0',
                        'win_price' => '0',
                        'spend'     => '0',
                    ];
                    $zeroData[$time->format("Y-m-d")] = $point;
                }
                break;

            case 'mm':
                $period = new DatePeriod( new DateTime($from), new DateInterval('P1M'), new DateTime($to));
                foreach($period as $time){
                    $point = [
                        'time'      => $time->format("Y-m"),
                        'clicks'    => '0',
                        'imps'      => '0',
                        'wins'      => '0',
                        'win_price' => '0',
                        'spend'     => '0',
                    ];
                    $zeroData[$time->format("Y-m")] = $point;  
                }          
                break;

            default:
                $period = new DatePeriod( new DateTime($from), new DateInterval('PT1H'), new DateTime($to));
                foreach($period as $time){
                    $point = [
                        'time'      => $time->format("Y-m-d H:00:00"),
                        'clicks'    => '0',
                        'imps'      => '0',
                        'wins'      => '0',
                        'win_price' => '0',
                        'spend'     => '0',
                    ];
                    $zeroData[$time->format("Y-m-d H:00:00")] = $point;
                }
        }

        return $zeroData;
    }
}
