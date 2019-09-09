<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class ImageComponent extends Component
{
    public function CutExt_Lower($data){
     return strtolower(substr($data,-4));
    }

    public function images($data,$dir,$pass){
      move_uploaded_file($data,WWW_ROOT.IMAGES_DIR.$dir.$pass);
      list($width, $hight,$info) = getimagesize(WWW_ROOT.IMAGES_DIR.$dir.$pass); // 元の画像名を指定してサイズを取得
      switch($info){
      case 2:
      $base = imagecreatefromjpeg(WWW_ROOT.IMAGES_DIR.$dir.$pass);
      break;
      case 3:
      $base = imagecreatefrompng(WWW_ROOT.IMAGES_DIR.$dir.$pass);
      break;
      }
      return array($base,$width,$hight);
    }

    public function CreatTtumb($img,$base,$dir,$w,$h,$adress){
      if($dir ==='Compre_img/' || $dir === 'Reply_Compre_img/'){
        imagecopyresampled($img,$base, 0, 0, 0, 0,THUMB_WIDTH,THUMB_HEIGHT, $w, $h);
        return imagejpeg($img,WWW_ROOT.IMAGES_DIR.$dir.$adress);
      }elseif($dir === 'Profile_Compre_img/'){
        imagecopyresampled($img,$base, 0, 0, 0, 0,ICON_SIZE,ICON_SIZE, $w, $h);
        return imagejpeg($img,WWW_ROOT.IMAGES_DIR.$dir.$adress);
      }
    }

    public function CreateImagePath($sessionname,$sessionid,$extension){
      $rec = $sessionid;
      $day = time();
      return  $img =  $sessionname.$day.$sessionid.$extension;
    }

    public function CreateImagePath_replys($uniq,$sessionname,$sessionid,$extension){
      $uniq = $uniq;
      $day = time();
      return  $img =  $sessionname.$uniq.$day.$sessionid.$extension;
    }

    public function DeleteFile_2($dir1,$dir2,$data){
      $file1 = WWW_ROOT.IMAGES_DIR.$dir1.$data;
      $file2 = WWW_ROOT.IMAGES_DIR.$dir2.$data;
      unlink($file1);
      unlink($file2);
    }

    public function deletefileforeach($filepass){
      foreach(glob($filepass.'*') as $filepass){
        unlink($filepass);
      }
    }
}
