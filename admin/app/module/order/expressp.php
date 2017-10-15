<?php
/*
@@acc_freet
@@acc_title="快递查询新接口 Express"
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
 
$expresses=array (
  '邮政包裹/平邮' => 'youzhengguonei',
  '国际包裹' => 'youzhengguoji',
  'EMS' => 'ems',
  '顺丰' => 'shunfeng',
  '申通' => 'shentong',
  '圆通' => 'yuantong',
  '中通' => 'zhongtong',
  '汇通' => 'huitongkuaidi',
  '韵达' => 'yunda',
  '宅急送' => 'zhaijisong',
  '天天' => 'tiantian',
  '德邦' => 'debangwuliu',
  '国通' => 'guotongkuaidi',
  '增益' => 'zengyisudi',
  '速尔' => 'suer',
  '中铁物流' => 'ztky',
  '中铁快运' => 'zhongtiewuliu',
  '能达' => 'ganzhongnengda',
  '优速' => 'youshuwuliu',
  '全峰' => 'quanfengkuaidi',
  '京东' => 'jd',
  'FedEx-国际' => 'fedex',
  'FedEx-美国' => 'fedexus',
  'DHL全球件' => 'dhlen',
  'DHL' => 'dhl',
  'DHL-德国' => 'dhlde',
  'TNT全球件' => 'tnten',
  'TNT' => 'tnt',
  'UPS全球件' => 'upsen',
  'UPS' => 'ups',
  'USPS' => 'usps',
  'DPD' => 'dpd',
  'DPD Germany' => 'dpdgermany',
  'DPD Poland' => 'dpdpoland',
  'DPD UK' => 'dpduk',
  'GLS' => 'gls',
  'Toll' => 'dpexen',
  'Toll Priority(Toll Online)' => 'tollpriority',
  'Aramex' => 'aramex',
  'DPEX' => 'dpex',
  '宅急便' => 'zhaijibian',
  '黑猫雅玛多' => 'yamato',
  '一统飞鸿' => 'yitongfeihong',
  '如风达' => 'rufengda',
  '海红网送' => 'haihongwangsong',
  '通和天下' => 'tonghetianxia',
  '郑州建华' => 'zhengzhoujianhua',
  '红马甲' => 'sxhongmajia',
  '芝麻开门' => 'zhimakaimen',
  '乐捷递' => 'lejiedi',
  '立即送' => 'lijisong',
  '银捷' => 'yinjiesudi',
  '门对门' => 'menduimen',
  '河北建华' => 'hebeijianhua',
  '微特派' => 'weitepai',
  '风行天下' => 'fengxingtianxia',
  '尚橙' => 'shangcheng',
  '新蛋奥硕' => 'neweggozzo',
  '鑫飞鸿' => 'xinhongyukuaidi',
  '全一' => 'quanyikuaidi',
  '彪记' => 'biaojikuaidi',
  '星晨急便' => 'xingchengjibian',
  '亚风' => 'yafengsudi',
  '源伟丰' => 'yuanweifeng',
  '全日通' => 'quanritongkuaidi',
  '安信达' => 'anxindakuaixi',
  '民航' => 'minghangkuaidi',
  '凤凰' => 'fenghuangkuaidi',
  '京广' => 'jinguangsudikuaijian',
  '配思货运' => 'peisihuoyunkuaidi',
  'AAE-中国件' => 'aae',
  '大田' => 'datianwuliu',
  '新邦' => 'xinbangwuliu',
  '龙邦' => 'longbanwuliu',
  '一邦' => 'yibangwuliu',
  '联昊通' => 'lianhaowuliu',
  '广东邮政' => 'guangdongyouzhengwuliu',
  '中邮' => 'zhongyouwuliu',
  '天地华宇' => 'tiandihuayu',
  '盛辉' => 'shenghuiwuliu',
  '长宇' => 'changyuwuliu',
  '飞康达' => 'feikangda',
  '元智捷诚' => 'yuanzhijiecheng',
  '万家' => 'wanjiawuliu',
  '远成' => 'yuanchengwuliu',
  '信丰' => 'xinfengwuliu',
  '文捷航空' => 'wenjiesudi',
  '全晨' => 'quanchenkuaidi',
  '佳怡' => 'jiayiwuliu',
  '快捷' => 'kuaijiesudi',
  'D速' => 'dsukuaidi',
  '全际通' => 'quanjitong',
  '青岛安捷' => 'anjiekuaidi',
  '越丰' => 'yuefengwuliu',
  '急先达' => 'jixianda',
  '百福东方' => 'baifudongfang',
  'BHT' => 'bht',
  '伍圆' => 'wuyuansudi',
  '蓝镖' => 'lanbiaokuaidi',
  'COE' => 'coe',
  '南京100' => 'nanjing',
  '恒路' => 'hengluwuliu',
  '金大' => 'jindawuliu',
  '华夏龙' => 'huaxialongwuliu',
  '运通中港' => 'yuntongkuaidi',
  '佳吉' => 'jiajiwuliu',
  '盛丰' => 'shengfengwuliu',
  '源安达' => 'yuananda',
  '加运美' => 'jiayunmeiwuliu',
  '万象' => 'wanxiangwuliu',
  '宏品' => 'hongpinwuliu',
  '上大' => 'shangda',
  '中铁' => 'zhongtiewuliu',
  '原飞航' => 'yuanfeihangwuliu',
  '海外环球' => 'haiwaihuanqiu',
  '三态' => 'santaisudi',
  '晋越' => 'jinyuekuaidi',
  '联邦' => 'lianbangkuaidi',
  '飞快达' => 'feikuaida',
  '忠信达' => 'zhongxinda',
  '共速达' => 'gongsuda',
  '嘉里大通' => 'jialidatong',
  'OCS' => 'ocs',
  '美国' => 'meiguokuaidi',
  '成都立即送' => 'lijisong',
  '递四方' => 'disifang',
  '康力' => 'kangliwuliu',
  '跨越' => 'kuayue',
  '海盟' => 'haimengsudi',
  '圣安' => 'shenganwuliu',
  '中速' => 'zhongsukuaidi',
  'OnTrac' => 'ontrac',
  '七天连锁' => 'sevendays',
  '明亮' => 'mingliangwuliu',
  '凡客配送（作废）' => 'vancl',
  '华企' => 'huaqikuaiyun',
  '城市100' => 'city100',
  '穗佳' => 'suijiawuliu',
  '飞豹' => 'feibaokuaidi',
  '传喜' => 'chuanxiwuliu',
  '捷特' => 'jietekuaidi',
  '隆浪' => 'longlangkuaidi',
  '中天万运' => 'zhongtianwanyun',
  '邦送' => 'bangsongwuliu',
  '澳大利亚(Australia Post)' => 'auspost',
  '加拿大(Canada Post)' => 'canpost',
  '加拿大邮政' => 'canpostfr',
  '汇强' => 'huiqiangkuaidi',
  '希优特' => 'xiyoutekuaidi',
  '昊盛' => 'haoshengwuliu',
  '亿领' => 'yilingsuyun',
  '大洋' => 'dayangwuliu',
  '递达' => 'didasuyun',
  '易通达' => 'yitongda',
  '邮必佳' => 'youbijia',
  '亿顺航' => 'yishunhang',
  '飞狐' => 'feihukuaidi',
  '潇湘晨报' => 'xiaoxiangchenbao',
  '巴伦支' => 'balunzhi',
  '闽盛' => 'minshengkuaidi',
  '佳惠尔' => 'syjiahuier',
  '民邦' => 'minbangsudi',
  '上海快通' => 'shanghaikuaitong',
  '北青小红帽' => 'xiaohongmao',
  'GSM' => 'gsm',
  '安能' => 'annengwuliu',
  'KCS' => 'kcs',
  'City-Link' => 'citylink',
  '店通' => 'diantongkuaidi',
  '凡宇' => 'fanyukuaidi',
  '平安达腾飞' => 'pingandatengfei',
  '广东通路' => 'guangdongtonglu',
  '中睿' => 'zhongruisudi',
  '快达' => 'kuaidawuliu',
  'ADP国际' => 'adp',
  '颿达国际' => 'fardarww',
  '颿达国际-英文' => 'fandaguoji',
  '林道国际' => 'shlindao',
  '中外运-中文' => 'sinoex',
  '中外运' => 'zhongwaiyun',
  '深圳德创' => 'dechuangwuliu',
  '林道国际-英文' => 'ldxpres',
  '瑞典（Sweden Post）' => 'ruidianyouzheng',
  'PostNord(Posten AB)' => 'postenab',
  '偌亚奥国际' => 'nuoyaao',
  '祥龙运通' => 'xianglongyuntong',
  '品速心达' => 'pinsuxinda',
  '宇鑫' => 'yuxinwuliu',
  '陪行' => 'peixingwuliu',
  '户通' => 'hutongwuliu',
  '西安城联' => 'xianchengliansudi',
  '煜嘉' => 'yujiawuliu',
  '一柒国际' => 'yiqiguojiwuliu',
  'Fedex-国际件-中文' => 'fedexcn',
  '联邦-英文' => 'lianbangkuaidien',
  '赛澳递for买卖宝' => 'saiaodimmb',
  '上海无疆for买卖宝' => 'shanghaiwujiangmmb',
  '新加坡小包(Singapore Post)' => 'singpost',
  '音素' => 'yinsu',
  '南方传媒' => 'ndwl',
  '速呈宅配' => 'sucheng',
  '创一' => 'chuangyi',
  '云南滇驿' => 'dianyi',
  '重庆星程' => 'cqxingcheng',
  '四川星程' => 'scxingcheng',
  '贵州星程' => 'gzxingcheng',
  '运通中港(作废)' => 'ytkd',
  'Gati-英文' => 'gatien',
  'Gati-中文' => 'gaticn',
  'jcex' => 'jcex',
  '派尔' => 'peex',
  '凯信达' => 'kxda',
  '安达信' => 'advancing',
  '汇文' => 'huiwen',
  '亿翔' => 'yxexpress',
  '东红' => 'donghong',
  '飞远配送' => 'feiyuanvipshop',
  '好运来' => 'hlyex',
  '四川快优达' => 'kuaiyouda',
);


$expresses1=array (
  'aae' => 'AAE快递',
  'anjie' => '安捷快递',
  'anxinda' => '安信达快递',
  'aramex' => 'Aramex国际快递',
  'balunzhi' => '巴伦支',
  'baotongda' => '宝通达',
  'benteng' => '成都奔腾国际快递',
  'cces' => 'CCES快递',
  'changtong' => '长通物流',
  'chengguang' => '程光快递',
  'chengji' => '城际快递',
  'chengshi100' => '城市100',
  'chuanxi' => '传喜快递',
  'chuanzhi' => '传志快递',
  'chukouyi' => '出口易物流',
  'citylink' => 'CityLinkExpress',
  'coe' => '东方快递',
  'cszx' => '城市之星',
  'datian' => '大田物流',
  'dayang' => '大洋物流快递',
  'debang' => '德邦物流',
  'dechuang' => '德创物流',
  'dhl' => 'DHL快递',
  'diantong' => '店通快递',
  'dida' => '递达快递',
  'dingdong' => '叮咚快递',
  'disifang' => '递四方速递',
  'dpex' => 'DPEX快递',
  'dsu' => 'D速快递',
  'ees' => '百福东方物流',
  'ems' => 'EMS快递',
  'fanyu' => '凡宇快递',
  'fardar' => 'Fardar',
  'fedex' => '国际Fedex',
  'fedexcn' => 'Fedex国内',
  'feibang' => '飞邦物流',
  'feibao' => '飞豹快递',
  'feihang' => '原飞航物流',
  'feihu' => '飞狐快递',
  'feite' => '飞特物流',
  'feiyuan' => '飞远物流',
  'fengda' => '丰达快递',
  'fkd' => '飞康达快递',
  'gdyz' => '广东邮政物流',
  'gnxb' => '邮政国内小包',
  'gongsuda' => '共速达物流|快递',
  'guotong' => '国通快递',
  'haihong' => '山东海红快递',
  'haimeng' => '海盟速递',
  'haosheng' => '昊盛物流',
  'hebeijianhua' => '河北建华快递',
  'henglu' => '恒路物流',
  'huacheng' => '华诚物流',
  'huahan' => '华翰物流',
  'huaqi' => '华企快递',
  'huaxialong' => '华夏龙物流',
  'huayu' => '天地华宇物流',
  'huiqiang' => '汇强快递',
  'huitong' => '汇通快递',
  'hwhq' => '海外环球快递',
  'jiaji' => '佳吉快运',
  'jiayi' => '佳怡物流',
  'jiayunmei' => '加运美快递',
  'jinda' => '金大物流',
  'jingguang' => '京广快递',
  'jinyue' => '晋越快递',
  'jixianda' => '急先达物流',
  'jldt' => '嘉里大通物流',
  'kangli' => '康力物流',
  'kcs' => '顺鑫(KCS)快递',
  'kuaijie' => '快捷快递',
  'kuanrong' => '宽容物流',
  'kuayue' => '跨越快递',
  'lejiedi' => '乐捷递快递',
  'lianhaotong' => '联昊通快递',
  'lijisong' => '成都立即送快递',
  'longbang' => '龙邦快递',
  'minbang' => '民邦快递',
  'mingliang' => '明亮物流',
  'minsheng' => '闽盛快递',
  'nell' => '尼尔快递',
  'nengda' => '港中能达快递',
  'ocs' => 'OCS快递',
  'pinganda' => '平安达',
  'pingyou' => '中国邮政平邮',
  'pinsu' => '品速心达快递',
  'quanchen' => '全晨快递',
  'quanfeng' => '全峰快递',
  'quanjitong' => '全际通快递',
  'quanritong' => '全日通快递',
  'quanyi' => '全一快递',
  'rpx' => 'RPX保时达',
  'rufeng' => '如风达快递',
  'saiaodi' => '赛澳递',
  'santai' => '三态速递',
  'scs' => '伟邦(SCS)快递',
  'shengan' => '圣安物流',
  'shengfeng' => '盛丰物流',
  'shenghui' => '盛辉物流',
  'shentong' => '申通快递（可能存在延迟）',
  'shunfeng' => '顺丰快递',
  'suijia' => '穗佳物流',
  'sure' => '速尔快递',
  'tiantian' => '天天快递',
  'tnt' => 'TNT快递',
  'tongcheng' => '通成物流',
  'tonghe' => '通和天下物流',
  'ups' => 'UPS快递',
  'usps' => 'USPS快递',
  'wanbo' => '万博快递',
  'wanjia' => '万家物流',
  'weitepai' => '微特派',
  'xianglong' => '祥龙运通快递',
  'xinbang' => '新邦物流',
  'xinfeng' => '信丰快递',
  'xiyoute' => '希优特快递',
  'yad' => '源安达快递',
  'yafeng' => '亚风快递',
  'yibang' => '一邦快递',
  'yinjie' => '银捷快递',
  'yinsu' => '音素快运',
  'yishunhang' => '亿顺航快递',
  'yousu' => '优速快递',
  'ytfh' => '北京一统飞鸿快递',
  'yuancheng' => '远成物流',
  'yuantong' => '圆通快递',
  'yuanzhi' => '元智捷诚',
  'yuefeng' => '越丰快递',
  'yumeijie' => '誉美捷快递',
  'yunda' => '韵达快递',
  'yuntong' => '运通中港快递',
  'yuxin' => '宇鑫物流',
  'ywfex' => '源伟丰',
  'zhaijisong' => '宅急送快递',
  'zhengzhoujianhua' => '郑州建华快递',
  'zhima' => '芝麻开门快递',
  'zhongtian' => '济南中天万运',
  'zhongtong' => '中通快递',
  'zhongxinda' => '忠信达快递',
  'zhongyou' => '中邮物流',
);

$com = 'other';
$comCN = unescape($_GET['keywords']);

$comCN = mb_substr($comCN,0,2,'utf-8');
$nu = $_GET['order'];
//echo $comCN;

foreach ( $expresses as $key => $val )
{
	if(strpos($key,$comCN)===false){
	}
	else
	{
		$com = $val;
	}
}

//echo $com;
//exit;
/*
  $gateway=sprintf('http://api.ickd.cn/?id=%s&secret=%s&com=%s&nu=%s&encode=%s&type=%s&ord=%s','102459','8a4dd0e999551f9d62e127af9508c3f8',$com,$nu,'utf8','json','DESC');
  $ch=curl_init($gateway);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_HEADER,false);
  $resp=curl_exec($ch);
  $errmsg=curl_error($ch);
  if($errmsg){
      exit($errmsg);
  }
  curl_close($ch);
*/

function json_array($json){
        if($json){
            foreach ((array)$json as $k=>$v){
                $data[$k] = !is_string($v)?json_array($v):$v;
            }
            return $data;
        }
}  
  
//$resp = json_decode($resp);
//$resp = json_array($resp);


  //echo $resp['data'][0]['time'];
  //return $resp;

$post_data = array();
$post_data["customer"] = '92543D0E466BB743A2AACE7E17225663';
$key= 'RSEKRkoY3143' ;
$post_data["param"] = '{"com":"'.$com.'","num":"'.$nu.'"}';

//echo $post_data["param"];
//exit;

$url='http://poll.kuaidi100.com/poll/query.do';
$post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
$post_data["sign"] = strtoupper($post_data["sign"]);
$o=""; 
foreach ($post_data as $k=>$v)
{
    $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
}
$post_data=substr($o,0,-1);
$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
 	 curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  	curl_setopt($ch,CURLOPT_HEADER,false);
	//curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$result = curl_exec($ch);
	//$data = str_replace("\&quot;",'"',$result );
	//$resp = json_decode($data,true);
  	curl_close($ch);

$resp = json_decode($result);
$resp = json_array($resp);




$message='';
$ischeck=0;
$sign_time='';
$sign_name='';
$dataAll='';

if($resp['status']>0)
{
foreach ($resp['data'] as $k=>$v)
{
$dataOne=''.$resp['data'][$k]['time'].'<br />'.$resp['data'][$k]['context'].'<br /><br />';
$dataAll = $dataAll . $dataOne ;
}

$ischeck=$resp['state'];


	if($ischeck==3)
	{
	$sign_time=$resp['data'][0]['time'];
	$sign_name=$resp['data'][0]['context'];
	$message='<font color="green">订单已签收</font>';
	}


}
else
{
$message='<font color="red">单号不存在或者已经过期</font>';

}

echo PHP2JSON( array(
		'status' => $resp['status'],
		'sign_time' => $sign_time,
		'sign_name' =>$sign_name,
		//'ischeck' => $ischeck,
		'dataAll' => $dataAll,
		'message' =>$message,
	) );

 
 ?>