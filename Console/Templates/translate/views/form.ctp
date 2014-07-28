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
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div id="content-header">
    <h1><?php echo "<?php echo __('add {$singularHumanName}');?>";?></h1>
    <?php if ($action != 'add'){
        echo "<?php echo \$this->Form->postLink(\$this->Html->Tag('i', array('class'=>'icon-trash icon-white')). __('Delete {$singularHumanName}', array('action' => 'delete', \$this->request->data['{$modelClass}']['id']), array('class'=>'btn btn-danger', 'escape'=>false), __('Are you sure you want to delete # %s?', \$this->request->data['{$modelClass}']['id'])));?>\n";
    } ?>
</div>
<div id="breadcrumb">   
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="/<?php echo $pluralVar;?>"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></a>
    <a href="#" class="current"><?php echo "<?php echo __('add {$singularHumanName}');?>";?></a>
</div>
<div class="container-fluid">
    <?php echo "<?php echo \$this->Form->create('{$modelClass}',array('class'=>'form-horizontal'));?>\n";?>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-plus"></i>                                  
                    </span>
                    <h5><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h5>                    
                </div>
                <div class="widget-content nopadding">                    
<?php
        echo "\t\t\t\t<?php\n";
        foreach ($fields as $field) {
            if (strpos($action, 'add') !== false && $field == $primaryKey) {
                continue;
            } elseif (!in_array($field, array('created', 'modified', 'updated'))) {
                echo "\t\t\t\t\techo \$this->Uniform->input('{$field}');\n";
            }
        }
        if (!empty($associations['hasAndBelongsToMany'])) {
            foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {                
                echo "\t\t\t\t\techo \$this->Uniform->input('{$assocName}');\n";
            }
        }
        echo "\t\t\t\t?>\n";
?>                   
<?php echo "\t\t\t\t<?php echo \$this->Form->end(array('label' => __('save'),'div'=>'form-actions','class'=>'btn btn-primary'));?>\n"; ?>                    
                </div>
            </div> 
        </div>
    </div> 
</div>