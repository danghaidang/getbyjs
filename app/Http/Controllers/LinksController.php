<?php

namespace App\Http\Controllers;


require_once app_path().'/libsimple/simple_html_dom.php';
//require_once app_path().'/curl/get.php';
class LinksController extends Controller
{
    //
    public function getHome() {
        $vars = [
            'data' => ''
        ];
       return view('getbylink', $vars);
    }

    public function getList($url = '') {
        $url = isset($_GET['url'])?urldecode($_GET['url']):'';
        if(!$url) return '';
        $url = urldecode($url);
	$html = @file_get_contents($url);
	if(!$html||strpos($html, '404 Not Found')!==false) {echo '0';exit;}
        $data = str_get_html($html);//file_get_html($url);
        if(empty($data)) {echo '0';exit;}
        $firstData = $data->find('.p-top',0);
	if(!$firstData ) {echo '0';exit;}
        $results = [];
	$title = $firstData->find('.c-t-center', 0);
		if(!$title) {echo '0';exit;}

		$results['link_origin'] = $url;
        $results['title'] = $title->find('h4', 0)->innertext;
        $img = $firstData->find('.img-wrap', 0);
        $img = $img?$img->find('img',0):$data->find('.c-r-img',0);
        if(!$img) {echo '0';exit;}
        $results['logo'] = $img->src;
        $href = $firstData->find('.c-t-logo',0)->find('a',0)->href;
        $results['linkvisit'] = 'https://www.couponsatcheckout.net'.$href;
        $results['linkhome'] = $this->checkLink($href);
        //header('Content-Type: application/json; charset=utf-8');
        if(!$data) echo '0';
        else echo implode('||', $results);
        exit;

    }
    public function checkLink($url) {
        if(strpos($url, '?target='))
            $url = explode('?target=', $url)[1];
        return $url;
    }


    public function getListView() {
        return view('getbylink');
    }



}
