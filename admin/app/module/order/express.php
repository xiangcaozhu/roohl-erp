<?php
/*
@@acc_freet
@@acc_title="快递查询 Express"

/**
 *  Express.class.php           快递查询类
 *
 * @copyright           widuu
 * @license         http://www.widuu.com
 * @lastmodify          2013-6-19
 */
 
 function unescape($str) {
  $ret = '';
  $len = strlen ( $str );
  for($i = 0; $i < $len; $i ++) {
   if ($str [$i] == '%' && $str [$i + 1] == 'u') {
    $val = hexdec ( substr ( $str, $i + 2, 4 ) );
    if ($val < 0x7f)
    $ret .= chr ( $val );
    else if ($val < 0x800)
    $ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
    else
    $ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
    $i += 5;
   } else if ($str [$i] == '%') {
    $ret .= urldecode ( substr ( $str, $i, 3 ) );
    $i += 2;
   } else
   $ret .= $str [$i];
  }
  return $ret;
 }
 
 
class Express {
    private $expressname =array(); //封装了快递名称
    function __construct(){
        $this->expressname = $this->expressname();
    }
    /*
     * 采集网页内容的方法
     */
    private function getcontent($url){
        if(function_exists("file_get_contents")){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
    /*
     * 获取对应名称和对应传值的方法
     */
    private function expressname(){
        $result = $this->getcontent("http://www.kuaidi100.com/");
        preg_match_all("/data\-code\=\"(?P<name>\w+)\"\>\<span\>(?P<title>.*)\<\/span>/iU",$result,$data);
        $name = array();
        foreach($data['title'] as $k=>$v){
            $name[$v] =$data['name'][$k];
        }
        return $name;
    }
    /*
     * 解析object成数组的方法
     * @param $json 输入的object数组
     * return $data 数组
     */
    private function json_array($json){
        if($json){
            foreach ((array)$json as $k=>$v){
                $data[$k] = !is_string($v)?$this->json_array($v):$v;
            }
            return $data;
        }
    }
     
    /*
     * 返回$data array      快递数组
     * @param $name         快递名称
     * 支持输入的快递名称如下
     * (申通-EMS-顺丰-圆通-中通-如风达-韵达-天天-汇通-全峰-德邦-宅急送-安信达-包裹平邮-邦送物流
     * DHL快递-大田物流-德邦物流-EMS国内-EMS国际-E邮宝-凡客配送-国通快递-挂号信-共速达-国际小包
     * 汇通快递-华宇物流-汇强快递-佳吉快运-佳怡物流-加拿大邮政-快捷速递-龙邦速递-联邦快递-联昊通
     * 能达速递-如风达-瑞典邮政-全一快递-全峰快递-全日通-申通快递-顺丰快递-速尔快递-TNT快递-天天快递
     * 天地华宇-UPS快递-新邦物流-新蛋物流-香港邮政-圆通快递-韵达快递-邮政包裹-优速快递-中通快递)
     * 中铁快运-宅急送-中邮物流
     * @param $order        快递的单号
     * $data['ischeck'] ==1   已经签收
     * $data['data']        快递实时查询的状态 array
     */
    public  function getorder($name,$order){
        $keywords = $this->expressname[$name];
        $result = $this->getcontent("http://www.kuaidi100.com/query?type={$keywords}&postid={$order}");
        $result = json_decode($result);
        $data = $this->json_array($result);
        return $data;
    }
}

$a = new Express();
$result = $a->getorder(unescape($_GET['keywords']),$_GET['order']);

//{"nu":"668309355849","message":"ok","ischeck":"0","com":"shentong","updatetime":"2013-11-01 11:56:22","status":"200","condition":"H100","data":[{"time":"2013-11-01 00:56:04","context":"由【湖南衡阳航空部】发往【湖南洞口公司】","ftime":"2013-11-01 00:56:04"},{"time":"2013-10-31 19:08:37","context":"【湖南长沙航空部】正在进行【发包】扫描","ftime":"2013-10-31 19:08:37"},{"time":"2013-10-31 19:08:37","context":"由【湖南长沙航空部】发往【湖南衡阳航空部】","ftime":"2013-10-31 19:08:37"},{"time":"2013-10-31 03:16:51","context":"【广东深圳公司】正在进行【装车】扫描","ftime":"2013-10-31 03:16:51"},{"time":"2013-10-31 03:16:51","context":"由【广东深圳公司】发往【湖南长沙中转部】","ftime":"2013-10-31 03:16:51"},{"time":"2013-10-31 00:03:17","context":"由【广东龙岗公司】发往【湖南衡阳中转部】","ftime":"2013-10-31 00:03:17"},{"time":"2013-10-31 00:03:17","context":"【广东龙岗公司】正在进行【装袋】扫描","ftime":"2013-10-31 00:03:17"},{"time":"2013-10-30 21:11:28","context":"【龙岗营业点】的收件员【王向阳 】已收件","ftime":"2013-10-30 21:11:28"}],"state":"0"}
//echo $result['nu'];



$message='';
$ischeck=0;
$sign_time='';
$sign_name='';
$dataAll='';

if($result['status']==200)
{
foreach ($result['data'] as $k=>$v)
{
$dataOne=''.$result['data'][$k]['time'].'<br />'.$result['data'][$k]['context'].'<br /><br />';
$dataAll = $dataAll . $dataOne ;
}

$ischeck=$result['ischeck'];


if($ischeck==1)
{
$sign_time=$result['data'][0]['time'];
$sign_name=$result['data'][0]['context'];
$message='<font color="green">订单已签收</font>';
}
}
else
{
$message='<font color="red">单号不存在或者已经过期</font>';

}

echo PHP2JSON( array(
		'status' => $result['status'],
		'sign_time' => $sign_time,
		'sign_name' =>$sign_name,
		//'ischeck' => $ischeck,
		'dataAll' => $dataAll,
		'message' =>$message,
	) );

?>