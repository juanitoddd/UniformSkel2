<div id="content-header">
    <h1><?php echo __('Import');?></h1>
</div>
<div id="breadcrumb">
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="/<?php echo strtolower($this->name);?>"><?php echo $this->name;?></a>
    <a href="#" class="current"><?php echo __('Import CVS');?></a>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <?php echo $this->Session->flash(); ?>
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-plus"></i>
                    </span>
                    <h5><?php echo __('Import csv'); ?></h5>
                </div>
                <div class="widget-content">
                    <?php
                    echo $this->Form->create($modelClass, array('action' => 'import', 'type' => 'file') );
                    echo $this->Form->input('CsvFile', array('label'=>'','type'=>'file') );
                    echo $this->Form->end('Submit', array('class' => 'btn btn-primary'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>