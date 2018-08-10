# page

use Pagelist;


$data = [
	'params'=>[
		'name'=>'zhouys',
		'job' => 'phper'
	],
	'listSize' => 5
];

$string = (new Pagelist($data))->getPageString(88,10);