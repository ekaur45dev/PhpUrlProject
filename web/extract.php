<?php
//file_put_contents("./files/log.png","https://www.mtbc.com/assets/img/rcm-logo.png");

    $url=$_POST["url"];
    if(!empty($url))
    {
        $data="";
        $data=file_get_contents($url);
        $strData=$data;
        $strDataRegexMatch="";
       $newStr= preg_replace("/class=\"(.*)\"/","",$strData);
       $newStr= preg_replace("/class=\"(.*)\"/","",$newStr);
        // preg_match_all("/style=\"(.*)\"/",$strData,$strDataRegexMatch);
        // $newStr="";
        // for ($i=0; $i < count($strDataRegexMatch); $i++) { 
        //     for ($j=0; $j < count($strDataRegexMatch[$i]); $j++) { 
        //      $newStr=$newStr.preg_replace("/style=\"(.*)\"/","",$strDataRegexMatch[$i][$j]);   
        //     }
        // }
        // $strWithoutStyle="";
        // preg_match_all("/class=\"(.*)\"/",$newStr,$strWithoutStyle);
        // $finalStr="";
        // for ($i=0; $i < count($strWithoutStyle); $i++) { 
        //     for ($j=0; $j < count($strWithoutStyle[$i]); $j++) { 
        //      $finalStr=$finalStr.preg_replace("/class=\"(.*)\"/","",$strWithoutStyle[$i][$j]);   
        //     }
        // }
        // printf($finalStr."sdafjklasdhfkjlhsadk hfkjdsahfkjlhsdakjlfhlksdha fhkdj");
        file_put_contents("./files/content.html",$newStr);



        $parsedUrl=parse_url($url);
        $host=$parsedUrl["host"];
        $out="";
        preg_match_all("<img (.*)\/>",$data,$out,PREG_SET_ORDER);
        $pageUrls=[];
        for ($i=0; $i < count($out); $i++) {
            for ($j=0; $j < count($out[$i]); $j++) { 
                $u=$out[$i][$j];
            if( strpos($u, "src=") !== FALSE ){
                
                 $u = preg_replace("/.*\s+src=\"/sm","",$u);
                 
                 $u = preg_replace("/\".*\".*/","",$u);
                if(strpos($u,"http")!==FALSE){
                    array_push($pageUrls,$u);
                }else{
                    array_push($pageUrls,"https://".$host.$u); 
                }
            }
            } 
        }
        file_put_contents("./files/test.txt",json_encode($pageUrls));
        for ($i=0; $i < count($pageUrls); $i++) {
            $file = file_get_contents($pageUrls[$i]);
            $myfile = fopen("./files/".pathinfo($pageUrls[$i], PATHINFO_FILENAME).".".pathinfo($pageUrls[$i], PATHINFO_EXTENSION), "w");// or die("Unable to open file!");
            fwrite($myfile, $file);
            fclose($myfile); 
     //   file_put_contents("./files/".pathinfo($pageUrls[$i], PATHINFO_FILENAME).".".pathinfo($pageUrls[$i], PATHINFO_EXTENSION),file_get_contents($pageUrls[$i]));
        }
        
    }
?>
