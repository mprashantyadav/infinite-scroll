<?php
$dataJson = file_get_contents("https://englishapi.xynie.com/app-api/v1/photo-gallery-feed-page/page/1");

$jsonArr = json_decode($dataJson, 1);
function dateAgo($ipTime) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>News Articles</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style type="text/css">
  	.main-container{ 
        margin: 0 auto;
        margin-top: 5%;
        width: 50%;
    }
  	.image-txt-container {
	  display: flex;
	  align-items: top;
	  flex-direction: row;
	}
	@media (max-width:767px){
		.main-container{width: 100%;}
		.image-txt-container{display: block;}
		.image-txt-container img{width: 100%;}
	}

  </style>  
</head>
<body>
<div class="main-container node-con">
<?php foreach ($jsonArr['nodes'] as $key => $value) { ?>
	<div class="image-txt-container node" id="1" style="margin:10px;
	">
	<div>
	  <img src="<?php echo $value['node']['ImageStyle_thumbnail']; ?>" width="250" height="250" loading="lazy">
	</div>
	<div style="padding-left:10px;">
	    <h3><?php echo $value['node']['title']; ?></h3>
	  	<p style="color:#808080"><?php echo dateAgo($value['node']['last_update']); ?></p>
	</div>
	</div>
<?php } ?>
</div>
<div class="ajax-loader" style="display:none;text-align:center;"><img src="https://c.tenor.com/8KWBGNcD-zAAAAAC/loader.gif" width="100px;" height="100px;"></div>
<div id="no-res" style="text-align:center;"></div>
<script type="text/javascript">
function getData(){
	var nodeId = $(".node:last").attr("id");
	if($.isNumeric(nodeId)){
	    $.ajax({
	        url: 'load_more.php?node_id=' + nodeId,
	        type: "get",
	        beforeSend: function (){
	            $('.ajax-loader').css('display','block');
	        },
	        success: function (data) {
	        	 $('.ajax-loader').css('display','none')
	        	if(data == 'no_record'){
	        		$("#no-res").text('No records found!');
	        		$(".node:last").attr("con-id",'no_more');
	        	}else{        		
	            	$(".node-con").append(data);
	        	}
	            // checkSize();
	        }
	    });
	}
}

$(document).on('touchmove', onScroll); // for mobile

function checkSize(){
   if($(window).height() >= $(document).height()){
      getData();
   }
}

function onScroll(){
   if($(window).scrollTop() > $(document).height() - $(window).height()-100) {
      getData(); 
   }
}

$(window).scroll(function(){
   var position = $(window).scrollTop();
   var bottom = $(document).height() - $(window).height();

   if( position == bottom ){
      getData(); 
   }

});

</script>
</body>
</html>