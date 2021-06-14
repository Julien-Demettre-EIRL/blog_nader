<?php
  error_reporting(0);
  require __DIR__ . '/vendor/autoload.php';
  use \Firebase\JWT\JWT;

function getRequestHeaders() {
    $headers = array();
    foreach($_SERVER as $key => $value) {
        if (substr($key, 0, 5) <> 'HTTP_') {
            continue;
        }
        $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
        $headers[$header] = $value;
    }
    return $headers;
}

$headers = getRequestHeaders();


$bok = false;
foreach ($headers as $header => $value) {
    if($header=='Range') $bok=true;
}
//$bok=true;
$bok2 = false;
$date = new DateTime();
$key = "Nader_The_Best";
$jwt = urldecode($_GET['id']);
$decoded = JWT::decode($jwt, $key, array('HS256'));
$mtn = intval($date->getTimestamp());
$decoded = (array) $decoded;
$tok = intval($decoded["expire"]);
$id = intval($decoded["id"]);

if($mtn<$tok)
{
  $bok2=true;
}


if($id!=0 && $bok && $bok2)
{
 // $path = "./video/".$_GET['video'];
 include_once "./includes/bdd.php";
 require_once dirname(__FILE__) . '/models/video.models.php';
 //var_dump($id);
        $videoModel = new VideoModel();
      
        $videoFileName = $videoModel->getNameVid((int) $id);
        $path = "./video/".$videoFileName;
//var_dump($path);
//var_dump($id);
  $size=filesize($path);

  $fm=@fopen($path,'rb');
  if(!$fm) {
    // You can also redirect here
    header ("HTTP/1.0 404 Not Found");
    die();
  }

  $begin=0;
  $end=$size;
  list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
  if ($size_unit == 'bytes')
  {
      //multiple ranges could be specified at the same time, but for simplicity only serve the first range
      //http://tools.ietf.org/id/draft-ietf-http-range-retrieval-00.txt
      list($range, $extra_ranges) = explode(',', $range_orig, 2);
  }
  else
  {
      $range = '';
  }
  list($seek_start, $seek_end) = explode('-', $range, 2);

  //set start and end based on range (if set), else set defaults
  //also check for invalid ranges.
  $end = (empty($seek_end)) ? ($size - 1) : min(abs(intval($seek_end)),($size - 1));
  $begin = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)),0);

  if($begin>0||$end<$size)
    header('HTTP/1.0 206 Partial Content');
  else
    header('HTTP/1.0 200 OK');

  header("Content-Type: video/mp4");
  header('Accept-Ranges: bytes');
  header('Content-Length:'.($end-$begin));
  header("Content-Range: bytes $begin-".($end+1)+"/$size");

  $cur=$begin;
  fseek($fm,$begin,0);

  print fread($fm,$end-$begin);
  die();
}
else {
  if($bok2) {
    http_response_code(401);
    echo "Vous n'êts pas autoriser à voir cette video";
  }
  else {
    http_response_code(401);
    echo "Cette vidéo est périmée";
  }
}
?>