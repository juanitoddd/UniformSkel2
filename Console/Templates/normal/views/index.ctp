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
    <h1><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h1>
    <div class="btn-group">
        <?php
        echo "\t\t<?php echo \$this->Html->link('<i class=\"icon-plus\"></i> '.__('New " . $singularHumanName . "'), array('action' => 'add'), array('class'=>'btn', 'escape'=>false)); ?>\n";
        ?>
    </div>
</div>
<div id="breadcrumb">
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="#" class="current"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></a>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <?php echo "<?php echo \$this->Session->flash(); ?>"; ?>
            <div class="widget-box">
                <div class="widget-title">
                    <h5><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo "<?php echo \$this->Form->create('{$modelClass}', array('url' => array_merge(array('action' => 'index'), \$this->params['pass']) )) ?>\n";?>
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <?php  foreach ($fields as $field):?>
                                <th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
                            <?php endforeach;?>
                            <th class="actions"><?php echo "<?php echo __('Actions');?>";?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="filterX" class="filterX">
                            <?php
                            foreach ($fields as $field){
                                switch($field){
                                    case 'id':
                                        echo "\t\t\t\t\t\t\t<th class='id'><?php echo \$this->Uniform->inputNaked('{$field}', array('type' => 'text', 'class' => 'input-block-level'));?></th>\n";
                                        break;
                                    case 'created':
                                        echo "\t\t\t\t\t\t\t<th><?php echo \$this->Uniform->dateInputNaked('{$field}', array('id' => '{$modelClass}Created', 'class' => 'input-small'));?></th>\n";
                                        break;
                                    case 'modified':
                                        echo "\t\t\t\t\t\t\t<th><?php echo \$this->Uniform->dateInputNaked('{$field}', array('id' => '{$modelClass}Modified', 'class' => 'input-small'));?></th>\n";
                                        break;
                                    default:
                                        echo "\t\t\t\t\t\t\t\t<th><?php echo \$this->Uniform->inputNaked('{$field}', array('class' => 'input-block-level'));?></th>\n";
                                        break;
                                }
                            }
                            ?>
                            <th>
                                <input type="submit" value="Filter" class="btn btn-primary" name="data[filter]">
                                <input type="submit" value="Reset" class="btn btn-primary" name="data[reset]">
                            </th>
                        </tr>
                        <?php
                        echo "<?php
                            foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
                        echo "\t\t\t\t\t\t\t<tr class='gradeX'>\n";
                        foreach ($fields as $field) {
                            $isKey = false;
                            if (!empty($associations['belongsTo'])) {
                                foreach ($associations['belongsTo'] as $alias => $details) {
                                    if ($field === $details['foreignKey']) {
                                        $isKey = true;
                                        echo "<td>\n\t\t\t\t\t\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
                                        break;
                                    }
                                }
                            }
                            if ($isKey !== true) {
                                echo "\t\t\t\t\t\t\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
                            }
                        }
                        echo "\t\t\t\t\t\t\t\t<td class=\"actions\">\n";
                        if(in_array('online',$fields))echo "\t\t\t\t\t\t\t\t\t<?php echo \$this->Uniform->switchToggle('online', array('data-model' => '{$pluralVar}', 'data-id' => \${$singularVar}['{$modelClass}']['{$primaryKey}']), \${$singularVar}['{$modelClass}']['online']); ?>\n";
                        echo "\t\t\t\t\t\t\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t\t\t\t<?php //echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t\t\t</td>\n";
                        echo "\t\t\t\t\t\t\t</tr>\n";

                        echo "\t\t\t\t\t\t\t<?php endforeach; ?>\n";
                        ?>
                        </tbody>
                    </table>
                    <?php echo "\t\t<?php echo \$this->Form->end(); ?>\n";?>
                    <div class="pagination alternate row-fluid">
                        <div class="span6">
                            <div class="muted counter">
                                <?php echo "<?php echo \$this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>\n" ;?>
                            </div>
                        </div>
                        <div class="span6">
                            <ul class="pull-right">
                                <?php echo "<?php echo \$this->Paginator->first( __('First'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>\n" ;?>
                                <?php echo "<?php echo \$this->Paginator->prev( __('Previous'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>\n" ;?>
                                <?php echo "<?php echo \$this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1)); ?>\n" ;?>
                                <?php echo "<?php echo \$this->Paginator->next(__('Next'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>\n" ;?>
                                <?php echo "<?php echo \$this->Paginator->last( __('Last'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')) ;?>\n" ;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>