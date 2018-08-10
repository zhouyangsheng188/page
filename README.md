# page

#请在html页面中引入bootstrap，否则样式很丑

use zhouys\Pagelist;

#分页中需要携带的参数
$data = [
	'params'=>[
		'name'=>'zhouys',
		'job' => 'phper'
	],
	'listSize' => 5
];

$string = (new Pagelist($data))->getPageString(88,10);