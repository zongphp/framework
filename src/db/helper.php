<?php
//表名加前缀
if ( ! function_exists( 'tablename' ) ) {
	function tablename( $table ) {
		return c( 'database.prefix' ) . $table;
	}
}

/*
 * 获取格式化后的时间戳
 */
if ( ! function_exists( 'getDateTimeStamp' ) ) {
    function getDateTimeStamp($str = ''){
        if($str == ''){
            $str = 'today';
        }
        $returnTime = [
            'start_time' =>'',
            'end_time' =>''
        ];
        switch ($str) {
            case 'today':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00")),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59"))
                ];
                break;
            case 'yesterday':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00",strtotime("-1 day"))),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59",strtotime("-1 day")))
                ];
                break;
            case 'tomorrow':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00",strtotime("+1 day"))),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59",strtotime("+1 day")))
                ];
                break;
            case 'lastweek':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))))
                ];
                break;
            case 'thisweek':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))))
                ];
                break;
            case 'lastmonth':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))))
                ];
                break;
            case 'thismonth':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))))
                ];
                break;
            case 'thisquarter':
                $getMonthDays = date("t",mktime(0, 0 , 0,date('n')+(date('n')-1)%3,1,date("Y")));
                $returnTime = [
                    'start_time' =>strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y')))),
                    'end_time' =>strtotime(date('Y-m-d H:i:s', mktime(23,59,59,date('n')+(date('n')-1)%3,$getMonthDays,date('Y'))))
                ];
                break;
						case 'lastyear':
		            $time = strtotime('-1 year', time());
		            $returnTime = [
		                'start_time' =>strtotime(date('Y-m-d 00:00:00', mktime(0, 0,0, 1, 1, date('Y', $time)))),
		                'end_time' =>strtotime(date('Y-m-d 23:39:59', mktime(0, 0, 0, 12, 31, date('Y',$time))))
		            ];
		            break;
            case 'thisyear':
                $returnTime = [
                    'start_time' =>strtotime(date('Y-m-d 00:00:00', mktime(0, 0,0, 1, 1, date('Y', time())))),
                    'end_time' =>strtotime(date('Y-m-d 23:39:59', mktime(0, 0, 0, 12, 31, date('Y'))))
                ];
                break;
          default:
            # code...
            break;
        }
        return $returnTime;
    }
}
