<?php
header("Content-type: text/css");
global $background_url_home, $background_url_single, $background_url_category, $background_url_page;
?>
#advertisetop {
    background-color: transparent;
    width:100%;
    margin: 0 auto;
    padding: 0;
    text-align: center;
}

#advertiseleft {
    background-color: transparent;
    height:100%;
    position:absolute;
    top:0px;
    left:0px;
    margin: 0 auto;
    padding: 0;
}

#advertiseright {
    background-color: transparent;
    height:100%;
    position:absolute;
    top:0px;
    right:0px;
    margin: 0 auto;
    padding: 0;
}
.background-partner-home {
	background: url('<?php echo $background_url_home; ?>') no-repeat !important;
}
.background-partner-single {
	background: url('<?php echo $background_url_single; ?>') no-repeat !important;
}
.background-partner-category {
	background: url('<?php echo $background_url_category; ?>') no-repeat !important;
}
.background-partner-page {
	background: url('<?php echo $background_url_page; ?>') no-repeat !important;
}