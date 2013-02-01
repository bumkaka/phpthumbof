<?php
/**
* SEOphpthumb
*
* @category snippet
* @version 1.1
* @license GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
* @author Agel_Nash <Agel_Nash@xaker.ru>
* mod by bumkaka
*/
//[[phpthumb? &input=`[+tvimagename+]` &options=`w_255,h=200`]]

$base="images";
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

if($input == '' || !file_exists($_SERVER['DOCUMENT_ROOT']."/".$input))
{return 'assets/snippets/phpthumbof/noimage.png';}
else{
  $options = 'f=jpg&q=96&'.strtr($options, Array("," => "&", "_" => "="));
  $path_parts=pathinfo($input);
  require_once MODX_BASE_PATH."/assets/snippets/phpthumbof/phpthumb.class.php";
  $phpThumb = new phpthumb();
  $phpThumb->setSourceFilename($input);
  
  $options = explode("&", $options);
  foreach ($options as $value) {
    $thumb = explode("=", $value);
    $phpThumb->setParameter($thumb[0], $thumb[1]);
    $op[$thumb[0]]=$thumb[1];
  }

  $tmp=str_replace($_SERVER['DOCUMENT_ROOT']."assets/images","",$path_parts['dirname']);
  $tmp=str_replace("assets/images","",$tmp);
  $tmp=explode("/",$tmp);
  $folder=$base;  
  
  for($i=0;$i<count($tmp);$i++){
    if ($tmp[$i]=='') continue;
    $folder.="/".$tmp[$i];
    if(!is_dir(MODX_BASE_PATH.$folder)) mkdir(MODX_BASE_PATH.$folder);
  }
  
  $fname=$folder."/".$op['w']."x".$op['h'].'-'.$path_parts['filename'].".".$op['f'];
  $outputFilename =MODX_BASE_PATH.$fname;
  if (!file_exists($outputFilename)) if ($phpThumb->GenerateThumbnail()) $phpThumb->RenderToFile($outputFilename) ;
  return $fname;
}
?>