<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Admin'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
        echo $this->Html->css('jquery/uniform');
        echo $this->Html->css('jquery/jquery-ui-1.10.3.custom');
        echo $this->Html->css('jquery/chosen');
        echo $this->Html->css('jquery/jquery.gritter');

        echo $this->Html->css('bootstrap/bootstrap');
        echo $this->Html->css('bootstrap/bootstrap-responsive');
        echo $this->Html->css('bootstrap/bootstrap-switch');
        echo $this->Html->css('bootstrap/bootstrap-editable');
        echo $this->Html->css('bootstrap/colorpicker');
        echo $this->Html->css('bootstrap/bootstrap-formhelpers');
        echo $this->Html->css('bootstrap/bootstrap-countries.flags');
        echo $this->Html->css('bootstrap/bootstrap.lightbox');
        echo $this->Html->css('bootstrap/bootstrap-timepicker');

        echo $this->Html->css('date/datepicker');
        echo $this->Html->css('date/fullcalendar');

        echo $this->Html->css('fonts/aller');
        echo $this->Html->css('fonts/codepro');
        echo $this->Html->css('fonts/museosans');
        echo $this->Html->css('fonts/font-awesome');

        echo    '<!--[if IE 7]>
                <link rel="stylesheet" href="/css/fonts/font-awesome-ie7.min.css">
                <![endif]-->';

        echo $this->Html->css('utils/animate');
        echo $this->Html->css('utils/backgrid');

        echo $this->Html->css('app/app.main');
        echo $this->Html->css('app/app.grey');

        echo $this->Html->script('jquery/jquery.1.8.2.min.js');
        echo $this->Html->script('jquery/jquery-ui-1.10.0.custom.js');
        echo $this->Html->script('jquery/jquery.chosen.js');
        echo $this->Html->script('jquery/jquery.uniform.js');
        echo $this->Html->script('jquery/jquery.validate.js');
        echo $this->Html->script('jquery/jquery.gritter.js');
        echo $this->Html->script('jquery/jquery.cycle.all.js');
        echo $this->Html->script('jquery/jquery.formatCurrency.js');
        echo $this->Html->script('jquery/jquery.wizard.js');
        echo $this->Html->script('jquery/jquery.cookie.js');
        echo $this->Html->script('jquery/jquery.stickem.js');
        echo $this->Html->script('jquery/jquery.placeholder.js');

        echo $this->Html->script('bootstrap/bootstrap.js');
        echo $this->Html->script('bootstrap/bootstrap-switch.js');
        echo $this->Html->script('bootstrap/bootstrap-colorpicker.js');
        echo $this->Html->script('bootstrap/bootstrap-datepicker.js');
        echo $this->Html->script('bootstrap/bootstrap-editable.js');
        echo $this->Html->script('bootstrap/bootstrap.lightbox.js');
        echo $this->Html->script('bootstrap/bootstrap-timepicker.js');

        echo $this->Html->script('backbone/underscore.min.js');
        echo $this->Html->script('backbone/backbone.min.js');
        echo $this->Html->script('backbone/backbone.query.min.js');
        echo $this->Html->script('backbone/backbone.paginator.js');
        echo $this->Html->script('backbone/backbone.relational.js');
        echo $this->Html->script('backbone/backbone.autocomplete.js');
        echo $this->Html->script('backbone/handlebars.js');
        echo $this->Html->script('backbone/backgrid.js');

        echo $this->Html->script('date/date.js');
        echo $this->Html->script('date/datepicker.js');
        echo $this->Html->script('date/fullcalendar.js');

        echo $this->Html->script('wysiwyg/wysihtml/wysihtml5-0.3.0.js');

        echo $this->Html->script('plupload/plupload.js');
        echo $this->Html->script('plupload/plupload.gears.js');
        echo $this->Html->script('plupload/plupload.silverlight.js');
        echo $this->Html->script('plupload/plupload.flash.js');
        echo $this->Html->script('plupload/plupload.browserplus.js');
        echo $this->Html->script('plupload/plupload.html4.js');
        echo $this->Html->script('plupload/plupload.html5.js');

        echo $this->Html->script('charts/highcharts.js');
        echo $this->Html->script('charts/jquery.flot.js');

        echo $this->Html->script('html5/excanvas.js');
        echo $this->Html->script('html5/modernizr.min.js');
        echo $this->Html->script('html5/placeholders.min.js');

        echo $this->Html->script('app/app.js');
        echo $this->Html->script('app/app.calendar.js');
        echo $this->Html->script('app/app.chat.js');
        echo $this->Html->script('app/app.wizard.js');
        echo $this->Html->script('app/app.interface.js');
        echo $this->Html->script('app/app.tables.js');
        echo $this->Html->script('app/app.resize.js');

        echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=false&amp;region=AT&amp;language=de&amp;libraries=places');

        $c = $this->params['controller'];
	?>
</head>
<body>
    <div id="container" class="<?php echo 'compact';?>">
        <div id="header">
            <h1><a href="/">Admin</a></h1>       
        </div>
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav btn-group">
                <li class="btn btn-inverse" ><a title="" href="#"><i class="fa fa-user"></i> <span class="text"><?php //echo $auth;?>User</span></a></li>
                <li class="btn btn-inverse dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="fa fa-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a class="sAdd" title="" href="#">new message</a></li>
                        <li><a class="sInbox" title="" href="#">inbox</a></li>
                        <li><a class="sOutbox" title="" href="#">outbox</a></li>
                        <li><a class="sTrash" title="" href="#">trash</a></li>
                    </ul>
                </li>
                <li class="btn btn-inverse"><a title="" href="#"><i class="fa fa-cog"></i> <span class="text">Settings</span></a></li>
                <li class="btn btn-inverse"><a title="" href="/admins/logout"><i class="fa fa-share-alt"></i> <span class="text">Logout</span></a></li>
            </ul>
        </div>           
        <div id="sidebar">
            <a href="/" class="visible-phone"><i class="fa fa-home"></i> Dashboard</a>
            <ul>
                <li class="compact hidden-phone"><a id="toggleNav" href="javascript:void(0);"><i class="fa <?php //echo $this->Session->read('admin.menu') == 'true' ? ' fa-arrow-right' : ' fa-arrow-left';?>"></i><span><?php echo __('Contract');?></span></a></li>
                <li <?php if($c == 'pages'){echo 'class="active"'; } ?>><a href="/" class="tip-right" title="<?php echo __('Dashboard');?>"><i class="fa fa-home"></i><span><?php echo __('Dashboard');?></span></a></li>
                <li <?php //if($c == 'pages'){echo 'class="active"'; } ?>><a href="/" class="tip-right" title="<?php echo __('Link');?>"><i class="fa fa-user"></i> <span><?php echo __('Links');?></span></a></li>
            </ul>
        </div>
        <div id="content">            
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
    <script>
        /*
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-40973279-1', 'garage2rent.com');
        ga('send', 'pageview');
        */
    </script>
</body>
</html>
