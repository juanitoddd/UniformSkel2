<ul id="tab" class="nav nav-tabs" style="margin-bottom:0px;">
    <?php
    foreach ($languages as $l): ?>
        <li<?php if($l['Language']['code'] == $lang)echo ' class="active"';?>><?php echo $this->Html->link($this->Html->image("i18n/" . $l['Language']['code'].".png", array('align' => 'middle')) . ' ' . $l['Language']['language'], array('controller'=>'P28n','action' => 'change',$l['Language']['code']), array('escape'=>false));?></li>
    <?php endforeach; ?>
    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class'=>'icon-globe')).' '.__('Translate'), array('controller'=>$controller,'action' => 'translate'), array('escape'=>false));?></li>
</ul>
<script>
$(document).ready(function(){

});
</script>