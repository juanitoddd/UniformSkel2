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
 * @lic ense       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div id="content-header">
    <h1><?php echo "<?php echo __('{$singularHumanName}'. '# {$primaryKey}');?>";?></h1>
    <div class="btn-group">
<?php
    echo "\t\t<?php echo \$this->Html->link(__('Edit " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn')); ?>\n";
    echo "\t\t<?php echo \$this->Form->postLink(__('Delete " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
    echo "\t\t<?php echo \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index'), array('class'=>'btn')); ?>\n";
    echo "\t\t<?php echo \$this->Html->link('<i class=\"icon-plus\"></i> ' . __('New " . $singularHumanName . "'), array('action' => 'add'), array('class'=>'btn', 'escape'=>false)); ?>\n";
?>                            
    </div>
</div>
<div id="breadcrumb">   
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="/<?php echo $pluralVar;?>"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></a>
    <a href="#" class="current"><?php echo "<?php  echo __('{$singularHumanName}');?>";?></a>
</div>
<div class="container-fluid">    
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-plus"></i>                                  
                    </span>
                    <h5><?php echo $singularHumanName; ?></h5>                    
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <tbody>                                             
<?php
foreach ($fields as $field) {
    echo "\t\t\t\t\t\t\t<tr>\n";
    $isKey = false;
    if (!empty($associations['belongsTo'])) {
        foreach ($associations['belongsTo'] as $alias => $details) {
            if ($field === $details['foreignKey']) {
                $isKey = true;
                echo "\t\t\t\t\t\t\t\t<td><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></td>\n";
                echo "\t\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t\t\t\t\t</td>\n";
                break;
            }
        }
    }
    if ($isKey !== true) {
        echo "\t\t\t\t\t\t\t\t<td><?php echo __('" . Inflector::humanize($field) . "'); ?></td>\n";
        echo "\t\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t\t\t\t\t\t</td>\n";
    }
    echo "\t\t\t\t\t\t\t</tr>\n";
}
?>        
                        </tbody> 
                    </table>          
                </div>
            </div> 
        </div>
    </div> 
</div>
