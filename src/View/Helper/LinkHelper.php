<?php

namespace App\View\Helper;
use Cake\View\Helper;

class LinkHelper extends Helper
{

  public function initialize(array $config){
    parent::initialize($config);
  }


  public function CreateLink($text){
    if(preg_match("/https/",$text) && preg_match("/youtu.be/",$text)){
      if(preg_match("/feature/",$text) || preg_match("/\?t=/",$text)){
        goto label;
      }

      $content =  mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", '\1\2' , $text);
      $point = strstr($content,'be/');
      $uniqurl = substr($point,3,11);

      $RemoveUrlContent = str_replace('https://youtu.be/'.$uniqurl,'',$content);
      $YoutubeUrl = 'https://youtu.be/'.$uniqurl;
      $ImageUrl = 'https://i.ytimg.com/vi/'.$uniqurl.'/mqdefault.jpg';
      // -- YOUTUBE_APIの上限に達したらこれ使う --
      // $YoutubeTitle = NULL;
      // return [$RemoveUrlContent,$YoutubeUrl,$ImageUrl,$YoutubeTitle];
      // -- OUTUBE_APIの上限に達したらこれ使う --

      //YOUTUBE_API
      if(isset($uniqurl)){
        $url = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$uniqurl.'&key='.YOUTUBE_API.'&part=snippet');
        $json = json_decode($url,true);
        if(isset($json['items'][0])){
          $YoutubeTitle = $json['items'][0]['snippet']['title'];
          return [$RemoveUrlContent,$YoutubeUrl,$ImageUrl,$YoutubeTitle];
        }else {
          $content = 'この動画は存在しません';
          $YoutubeUrl = null;
          $ImageUrl = null;
          $YoutubeTitle = null;
          return [$content,$YoutubeUrl,$ImageUrl,$YoutubeTitle];
        }
      }
      //YOUTUBE_API
    }elseif(preg_match("/https/",$text) && !preg_match("/youtu.be/",$text)){
      label:
      $content = nl2br(mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", '<a target=”_blank” href="\1\2">\1\2</a>' , $text));
      $YoutubeUrl = null;
      $ImageUrl = null;
      $YoutubeTitle = null;
      return [$content,$YoutubeUrl,$ImageUrl,$YoutubeTitle];
    }else {
      $content = $text;
      $YoutubeUrl = null;
      $ImageUrl = null;
      $YoutubeTitle = null;
      return [$content,$YoutubeUrl,$ImageUrl,$YoutubeTitle];
    }
  }

  public function CreateYoutubeThumb($data){
    if(preg_match("/https/",$data) && preg_match("/youtu.be/",$data) && !preg_match("/feature/",$data)){
      $point = strstr($data,'be/');
      $uniqurl = substr($point,3,11);
      $YoutubeUrl = 'https://youtu.be/'.$uniqurl;
      $ImageUrl = 'https://i.ytimg.com/vi/'.$uniqurl.'/mqdefault.jpg';
      // -- 復旧までこれ使う --
      $CutTitle = null;
      return [$ImageUrl,$YoutubeUrl,$CutTitle];
      // -- 復旧までこれ使う --

      // if(isset($uniqurl)){
      //   $url = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$uniqurl.'&key='.YOUTUBE_API.'&part=snippet');
      //   $json = json_decode($url,true);
      //   $youtubetitle = $json['items'][0]['snippet']['title'];
      //   $CutTitle =  mb_substr($youtubetitle,0,25);
      //   return [$ImageUrl,$YoutubeUrl,$CutTitle];
      // }
    }
  }

  public function CutIntFromImagesize($data){
    if(strlen($data) === 7){
      return  substr($data,-7,-6);
    }elseif(strlen($data) === 8){
      return  substr($data,-8,-6);
    }
  }
}
