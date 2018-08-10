<?php

namespace zhouys;

class Pagelist
{
	private $listSize = 5;//页码条中显示的页码数
	private $params;//地址栏中携带其他的参数

	public function __construct(array $data)
	{
	    $this->params = isset($data['params']) ? $data['params'] : '';
	    if(isset($data['listSize'])){
                if($data['listSize']%2==0){
                    $this->listSize = $data['listSize'] +1;
                }else{
                    $this->listSize = $data['listSize'];
                }
            }
	}

	public function getParams($params)
	{
		$res = '';
		if(!empty($params)){
			$res='&'.http_build_query($params);
		}
		return $res;
	}

	/**
	 * @param $total 、一共多少条数据
	 * @param int $pageSize 、每页显示多少条
	 * @return string
	 */
	public function getPageString($total,$pageSize=10)
	{
		$page=isset($_GET['page'])?$_GET['page']:1;//当前页
		$sumPage=ceil($total/$pageSize);//总共有多少页
		$showPage=$this->listSize;
		$offsetPage=($showPage-1)/2;//页码条中偏移量
		$start=1;
		$end=$sumPage;
		$prev=$page-1;
		$next=$page+1;
		$url = $_SERVER ['PHP_SELF'];
		$params = $this->getParams($this->params);;
		$page_banner="";
		if($page>1){
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' href='{$url}?page=1{$params}'>首页</a>";
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' href='{$url}?page=$prev{$params}'><<上一页</a>";
		}else{
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' disabled style='color:#ccc;border:1px solid #ccc'>首页</a>";
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' disabled style='color:#ccc;border:1px solid #ccc'><<上一页</a>";
		}
		if($sumPage>$showPage){
			if($page>$offsetPage+1){
				$page_banner.="...";
			}
			if($page>$offsetPage){
				$start=$page-$offsetPage;
				$end=$sumPage>$page+$offsetPage?$page+$offsetPage:$sumPage;
			}else{
				$start=1;
				$end=$sumPage>$showPage?$showPage:$sumPage;
			}
			if($page+$offsetPage>$sumPage){
				$start=$start-($page+$offsetPage-$end);
				$end=$sumPage;
			}
		}
		for($i=$start;$i<=$end;$i++){
			if($page==$i){
				$page_banner.="<span style='margin:0 5px' class='btn btn-default active'>$i</span>";
			}else{
				$page_banner.="<a style='margin:0 5px' class='btn btn-default' href='{$url}?page=$i{$params}'>$i</a>";
			}
		}
		if($page+$offsetPage<$sumPage&&$sumPage>$showPage){
			$page_banner.="...";
		}
		if($page<$sumPage){
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' href='{$url}?page=$next{$params}'>下一页>></a>";
			$page_banner.="<a style='margin:0 5px' class='btn btn-default' href='{$url}?page=$sumPage{$params}'>尾页</a>";
		}else{
			$page_banner.="<a class='btn btn-default' disabled style='color:#ccc;border:1px solid #ccc;margin:0 5px'>下一页>></a>";
			$page_banner.="<a class='btn btn-default' disabled style='color:#ccc;border:1px solid #ccc;margin:0 5px'>尾页</a>";
		}

		$page_banner.=" 共".$sumPage."页".$total."条数据";
		return $page_banner;
	}
}

