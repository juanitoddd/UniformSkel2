<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset('utf-8'); ?>
	<title>
		<?php echo __('Admin login'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap/bootstrap');
        echo $this->Html->css('bootstrap/bootstrap-responsive');
        echo $this->Html->css('app/app.login');


        echo $this->Html->script('jquery/jquery.1.8.2.min.js');
        echo $this->Html->script('app/app.login.js');

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
