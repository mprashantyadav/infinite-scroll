<?php
function dateAgo($ipTime){
    $curTime = time();
    $diffS = $curTime - $ipTime;
    $strTime = '';
    if($diffS < 20) {
            $strTime = 'few seconds ago';
    } else if($diffS < 60) {
            $strTime = $diffS.' seconds ago';
    } else if($diffS < (60*3)) {
            $strTime = 'few minutes ago';
    } else if($diffS < (60*60)) {
            $strTime = floor($diffS/60).' minutes ago';
    } else if($diffS < (60*60*12)) {
            $hrs = floor(($diffS/3600));
            if($hrs == 1) {
                    $strTime = $hrs.' hour ago';
            } else {
                    $strTime = $hrs.' hours ago';
            }
    } else {
            $day 	= date("j", $ipTime);
            $month 	= date("n", $ipTime);
            $year 	= date("Y", $ipTime);
            if($day ==  date("j") && $month ==  date("n") && $year ==  date("Y")) {
                    $strTime = 'Today '.date(", g:i a", $ipTime);
            } else if($year ==  date("Y")) {
                    $strTime = date("j M Y, g:i a", $ipTime);
            } else {
                    $strTime = date("j M Y, g:i a", $ipTime);
            }
    }
    return $strTime;
}
$nodeId = (int)trim($_GET['node_id']);
$nodeId = $nodeId+1;
$dataJson = file_get_contents("https://englishapi.xynie.com/app-api/v1/photo-gallery-feed-page/page/".$nodeId);
$jsonArr = json_decode($dataJson, 1);
if(!empty($jsonArr) && !empty($jsonArr['nodes'])){
?>
<?php foreach ($jsonArr['nodes'] as $key => $value) { ?>
	<div class="image-txt-container node" id="<?php echo $nodeId; ?>" style="margin:10px;
	">
	<div>
	  <img src="<?php echo $value['node']['ImageStyle_thumbnail']; ?>" width="250" height="250" loading="lazy">
	</div>
	<div style="padding-left:10px;">
	  <h3><?php echo $value['node']['title']; ?></h3>
	  	<p style="color:#808080"><?php echo dateAgo($value['node']['last_update']); ?></p>
	</div>
	</div>
<?php } }else{
	echo 'no_record';
} ?>