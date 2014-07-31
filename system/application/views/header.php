<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>/css/style.css" />
		<title><?php echo $title;?></title>
		<?php
		if(isset($script))
		  echo $script."\n";

		if(isset($js))
		{
		  echo '<script type="text/javascript">'."\n";
		  echo "<!--\n";
		  echo $js."\n";
		  echo "//-->\n";
		  echo '</script>'."\n";
		}
		?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div class="webfax">
					<a href="<?php echo base_url();?>">
					<img src="<?php echo base_url();?>/images/WebFax.png" alt="WebFax" class="webfax" />
					</a>
				</div>
			</div><!--/header-->
			<div id="content">
