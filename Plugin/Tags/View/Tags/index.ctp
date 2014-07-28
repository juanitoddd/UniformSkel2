<div id="content-header">
    <h1><?php echo __('Tags');?></h1>
</div>
<div id="breadcrumb">
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="#" class="current"><?php echo __('Tags');?></a>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12 tab-span">
            <div class="widget-box">
                <div class="widget-title">
                    <h5><?php echo __('Tags');?></h5>
                </div>
                <div class="widget-content nopadding dataTables_wrapper">
                    <?php echo $this->Form->create('Tag', array('url' => array_merge(array('action' => 'index'), $this->params['pass']) )) ?>
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('name');?></th>
                            <th class="actions"><?php echo __('Actions');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="filterX" class="filterX">
                            <th><?php echo $this->Uniform->inputNaked('name');?></th>
                            <th>
                                <input type="submit" value="Filter" class="btn btn-primary" name="data[filter]">
                                <input type="submit" value="Reset" class="btn btn-primary" name="data[reset]">
                            </th>
                        </tr>
                        <?php
                        foreach ($tags as $tag): ?>
                            <tr class='gradeX'>
                                <td><?php echo $tag['Tag']['name']; ?>&nbsp;</td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tag['Tag']['id'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->Form->end(); ?>
                    <div class="pagination alternate row-fluid">
                        <div class="span6">
                            <div class="muted counter">
                                <?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
                            </div>
                        </div>
                        <div class="span6">
                            <ul class="pull-right">
                                <?php echo $this->Paginator->first( __('First'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
                                <?php echo $this->Paginator->prev( __('Previous'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
                                <?php echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1)); ?>
                                <?php echo $this->Paginator->next(__('Next'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
                                <?php echo $this->Paginator->last( __('Last'), array('tag'=>'li', 'disabledTag'=>'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')) ;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>