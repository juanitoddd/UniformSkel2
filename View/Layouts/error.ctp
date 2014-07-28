<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset('utf-8'); ?>
	<title>
		<?php echo __('Error 404'); ?>
		<?php //echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');
        echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->css('unicorn.login');                


		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">             
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>
