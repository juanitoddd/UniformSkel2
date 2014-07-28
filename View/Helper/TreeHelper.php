<?php

class TreeHelper extends Helper {

    public $helpers = array('Html','Uniform.Uniform');

    private $modelClass;
    private $actions;

    public function render($tree, $modelClass, $actions = array()) {
        $this->modelClass = $modelClass;
        $this->actions = $actions;
        $this->nodes($tree);
    }

    private function nodes($tree) {
        foreach($tree as $node) {
            $this->line($node);
            if(!empty($node['children'])){
                $this->nodes($node['children']);
            }
        }
    }

    private function line($node){
        $tab = '';
        echo "<tr class='gradeX'>";
            $img = empty($node['children']) ? $this->Html->image('control-empty.png') : $this->Html->image('control-down.png');
            $tab = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $node[$this->modelClass]['depth']);
            echo "<td>".$node[$this->modelClass]['id']."</td>";
            echo "<td>".$tab.$img.$node[$this->modelClass]['name']."</td>";
            echo "<td>";
            foreach($this->actions as $action){
                echo $this->Html->link($action['label'], array('action'=>$action['action'], $node[$this->modelClass][$action['params']]), $action['options']);
                echo '&nbsp;';
            }
            //Custom function to toggle online/offline
            $this->toggleTree($node);
            echo "</td>";
        echo "</tr>";
    }

    private function toggleTree($node){
        $pluralVar = Inflector::underscore(Inflector::pluralize($this->modelClass));
        echo $this->Uniform->simpleToggle('online', array('div' => array('id' => 'switch-'.$node[$this->modelClass]['id'], 'class' => 'switch-tree'),'data-model' => $pluralVar, 'data-id' => $node[$this->modelClass]['id']), $node[$this->modelClass]['online']);
    }
}