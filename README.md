# youtube
Youtube.com video sayfasından api kullanmadan video verilerinin alınması.



<?php

require_once 'youtube.com';

//youtube video url ile
$data = 'https://www.youtube.com/watch?v=Hu97Hk8MT8U';

$youtube = new youtube($data);
$response = array(
  'title'=>$youtube->title(),
  'desc'=>$youtube->description(),
  'img'=>$youtube->image(),
);

print_r($response);


//youtube video embed kodu ile
$data = '<iframe width="560" height="315" src="https://www.youtube.com/embed/Hu97Hk8MT8U" frameborder="0" allowfullscreen></iframe>';

$youtube = new youtube($data);
$response = array(
  'title'=>$youtube->title(),
  'desc'=>$youtube->description(),
  'img'=>$youtube->image(),
);

print_r($response);
?>
