<?php 

$settings = get_option('settings', $params['id']);

$defaults = array(
    'name' => '',
    'url' => '',
    'file' => ''
);

$json = json_decode($settings, true);

if (isset($json) == false or count($json) == 0) {
    $json = array(0 => $defaults);
}


?>


<?php
$count = 0;
foreach($json as $slide){
$count++;
?>
<div class="circle">
      <div class="inner"> <span class="text"><?php print $slide['name'] ?></span> <span class="media_icon"><i class="glyph-icon flaticon-play-button4"></i></span> </div>
</div>
<?php } ?>
    