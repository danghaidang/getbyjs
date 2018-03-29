<?php

namespace App\Http\Controllers;



require_once app_path().'/libsimple/simple_html_dom.php';
class GetlogoController extends Controller
{
    //
    public function getLogoView() {
       return view('getlogo');
    }

    public function getLogo() {
        $domain = isset($_GET['domain'])?$_GET['domain']:'';
        $img = '';
        if($domain) {
            $url = strpos($domain, 'http')===false?"http://$domain":$domain;
            $getData = $this->getData($url);
            $followUrl = $getData['url'];
            $html = $getData['html'];
            //echo $html;exit;
            $getpage = str_get_html($html);
            $img = $getpage->find('img', 0);
        }
        if($img) {
            $src = $img->src;
            if(strpos($src,'http')===false) {
                require_once app_path().'/curl/getloc.php';
                $domainUrl = explode('/', $followUrl);

                if(strpos($src,'/')===0) {
                    unset($domainUrl[count($domainUrl)-1]);
                    $domainUrl = implode('/', $domainUrl);
                    $src = "$domainUrl$src";
                }else {
                    $domainUrl = implode('/', array_slice($domainUrl,0,3));
                    $src = "$domainUrl/$src";
                }
            }
            echo $src;
        }else echo '0';
        exit;
    }

    public function getData($url,$nobody=1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_COOKIESESSION,false);
        curl_setopt($ch, CURLOPT_HEADER,1);
        //curl_setopt($ch, CURLOPT_NOBODY,$nobody);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        //curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0");

        $htm = curl_exec($ch);
        $info = curl_getinfo( $ch );
        if(!isset($info['url'])) $redirect = $url; else $redirect =$info['url'];
        return ['html' => $htm, 'url' => $redirect];
    }




}
