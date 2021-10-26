<?php
function curls($urls,$postdata=null){
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$urls);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
/*  curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER["HTTP_USER_AGENT"]);*/
  if(!empty($postdata)){
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
  }
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  $curl["cexe"] = curl_exec($ch);
  $curl["response"] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
  curl_close($ch);
  return (object) $curl;
}
function grabfromprovider(){
  $prov = '#<a class="in-block overfl" href="/provider/(.*?).html"#';
  $z = curls("http://moonsearch.com/provider/?page=1")->cexe;
  preg_match_all($prov,$z,$rs);
  foreach($rs[1] as $provider){
    for($page=1;$page<10000000;$page++){
      $regexdom = '#<a class="in-block" href="/report/(.*?).html"#';
      preg_match_all($regexdom,curls("http://moonsearch.com/provider/$provider.html?page=$page")->cexe,$domz);
      if(empty($domz[1])){
        break;
      }
      foreach($domz[1] as $domains){
        if(!empty($domains)){
          print $domains."\n";
          file_put_contents('result.txt',$domains."\n",FILE_APPEND);
        }else{
          break;
        }
      }
    }
  }
}
system("clear");
grabfromprovider();