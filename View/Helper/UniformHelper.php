<?php
class UniformHelper extends AppHelper {

    public $helpers = array('Form');

    public function info($label, $value) {
        if($value){
            $out = '';
            $out .= '<div class="control-group">';
            $out .= '<label class="control-label">'.$label.'</label>';
            $out .= '<div class="controls"><div class="input-value">'.$value.'</div></div>';
            $out .= '</div>';
            return $out;
        }else
            return null;
    }

    public function input($fieldName, $options = array(), $help = null) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls">',
            'after'  => '<div class="input-help">'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputPrepend($fieldName, $options = array(), $add, $help = null) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-prepend"><span class="add-on">'.$add.'</span>',
            'after'  => '<div class="input-help">'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputAppend($fieldName, $options = array(), $add, $help = null) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-append">',
            'after'  => '<span class="add-on">'.$add.'</span><div class="input-help">'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputCheck($fieldName, $options = array(), $add = null, $help = null) {
        $appendClass = $add ? ' input-append' : '';
        $appendField = $add ? '<span class="add-on">'.$add.'</span>' : '';
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-prepend'.$appendClass.'"><span class="add-on"><input style="vertical-align:top;" class="activate" type="checkbox" id="check-'.$fieldName.'"> '.$options['checkboxLabel'].'</span>',
            'after'  => $appendField.'<div class="input-help">'.$help.'</div></div>',
            'disabled' => 'disabled'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    //Multiple checkboxes
    public function inputMultiple($fieldName, $options = array(), $help = null) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'multiple' =>'checkbox',
            'between'  => '<div class="controls" style="margin-left:220px;">',
            'after'  => '<div class="input-help"><button type="button" class="btn btn-inverse select-all">Select all</button>'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function dateInput($fieldName, $options = array(), $dateFormat = '%d %M %Y', $help = null, $callback = null) {
        $script = '<script>
                    var opts = {
                            formElements:{"' . $options['id'] . '":"' . $dateFormat . '"},
                            statusFormat:"%D, %M %Y",
                            fillGrid: false,
                            showWeeks:true,
                            noFadeEffect:true,
                            callbackFunctions:{"datereturned":[function(data) {
                                    var date = data.yyyy+"-"+data.mm+"-"+data.dd;
                                    '.($callback ? $callback : '').';
                                }]
                            }
                    };
                    datePickerController.createDatePicker(opts);
                    </script>';

        $settings = array(
            'type' => 'text',
            //'class' => 'input-medium',
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls">',
            'after'  => '<div class="input-help">'.$help.'</div></div>' . $script
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function dateInputBootstrap($fieldName, $options = array(), $help = null) {
        $script = '<script>
                    $(document).ready(function(){
                        var nowTemp = new Date();
                        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
                        var '.$options['id'].'_datepicker = $("#' . $options['id'] . '").datepicker({
                            format: "yyyy-mm-dd",
                            onRender: function(date) {
                                return date.valueOf() < now.valueOf() ? "disabled" : "";
                            }
                        }).on("changeDate", function(ev) {
                            '.$options['id'].'_datepicker.hide();
                            }).data("datepicker");
                        });
                    </script>';

        $settings = array(
            'type' => 'text',
            //'class' => 'input-medium',
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-prepend"><span class="add-on"><i class="icon-calendar"></i></span>',
            'after'  => '<div class="input-help">'.$help.'</div></div>' . $script
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function dateInputNaked($fieldName, $options = array(), $help = null) {

        $script = '<script>
                    $(document).ready(function(){
                        var '.$options['id'].'_datepicker = $("#' . $options['id'] . '").datepicker({
                            format: "yyyy-mm-dd",
                        }).on("changeDate", function(ev) {
                            '.$options['id'].'_datepicker.hide();
                            }).data("datepicker");
                        });
                    </script>';

        $settings = array(
            'type' => 'text',
            //'class' => 'input-medium',
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => false,
            'label'  => false,
            'between'  => '<div class="controls input-prepend"><span class="add-on"><i class="icon-calendar"></i></span>',
            'after'  => '<div class="input-help">'.$help.'</div></div>' . $script
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function dateInputNakedOperator($fieldName, $options = array()) {

        $field_id = $fieldName.'Date';

        $script = '<script>
                    var '.$fieldName.'_opt = "=";
                    $(document).ready(function(){
                        var '.$fieldName.'_datepicker = $("#' . $field_id . '").datepicker({
                            format: "yyyy-mm-dd",
                            //format: "dd-mm-yyyy"
                        }).on("changeDate", function(ev) {
                            '.$fieldName.'_datepicker.hide();
                            $("#'.$options['id'].'").val('.$fieldName.'_opt + " " + $(this).val());
                            }).data("datepicker");
                        });
                        $(".'.$fieldName.'-dd-options").click(function(e){
                            e.preventDefault();
                            '.$fieldName.'_opt = $(this).attr("data-opt");
                            $(this).parent().parent().prev().find(".dd-label").html($(this).text());
                            $(this).parent().parent().parent().removeClass("open");
                            $("#'.$options['id'].'").val('.$fieldName.'_opt + " " + $("#'.$field_id.'").val());
                        });
                    </script>';

        $labels[] = array('text' => __('On'), 'opt' => '=');
        $labels[] = array('text' => __('Before'), 'opt' => '<');
        $labels[] = array('text' => __('After'), 'opt' => '>');

        $between = '<div class="controls input-prepend">';
        $between .=  '<div class="btn-group">';
        $between .=     '<button class="btn dropdown-toggle" data-toggle="dropdown">';
        $between .=     '<span class="dd-label">' . __('On') . '</span>' . ' <span class="caret"></span>';
        $between .=     '</button>';
        $between .=     '<ul class="dropdown-menu">';
        foreach($labels as $label)
            $between .=         '<li><a class="'.$fieldName.'-dd-options" href="/" data-opt="'.$label['opt'].'">'.$label['text'].'</a></li>';
        $between .=     '</ul>';
        $between .=  '</div>';
        $value = empty($options['value']) ? null : explode(' ', $options['value']);
        $between .= '<input type="text" id="'.$field_id.'" class="input-small" value="'.(isset($value[1])? $value[1]:'').'">';

        $settings = array(
            'type' => 'text',
            'class' => 'hidden adimensional',
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => false,
            'label'  => false,
            //'between'  => '<div class="controls input-prepend"><span class="add-on"><i class="icon-calendar"></i></span>',
            'between'  => $between,
            'after'  =>  '</div>' . $script
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputRange($fieldName, $options_min = array(), $options_max = array(), $label = null){
        $settings_min = array(
            'div' => false,
            'label'  => false,
            'style' => 'margin-bottom:0px;'
        );
        $settings_max = array(
            'div' => false,
            'label'  => false,
            'style' => 'margin-bottom:0px;'
        );
        $min = $this->Form->input($fieldName . '.min', array_merge_recursive($settings_min, $options_min));
        $max = $this->Form->input($fieldName . '.max', array_merge_recursive($settings_max, $options_max));

        $out  = '<div class="control-group">
                    <label class="control-label">'. ($label ? $label : $fieldName ).'</label>
                    <div class="controls">
                    '.$min . '&nbsp;&nbsp;' . $max.'
                    </div>
                </div>';

        return $out;
    }

    //This function has filter purposes, the output will generate conditions syntax to use on the Cake find method
    public function inputRangeSlider($fieldName, $options = array(), $slider = array(), $units = array()) {
        $unit['suffix'] = isset($units['suffix']) ? $units['suffix'] : '';
        $unit['prefix'] = isset($units['prefix']) ? $units['prefix'] : '';
        $script = '<script>
                    var '.$options['id'].'opts = {
                            range: true,
                            animate: true,
                            max:'.$slider['max'].',
                            min:'.$slider['min'].',
                            values: [ '.$slider['min_selected'].', '.$slider['max_selected'].' ],
                            slide: function( event, ui ){
                                $("#'.$options['id'].'-data-first").val(ui.values[0]);
                                $("#'.$options['id'].'-data-last").val(ui.values[1]);
                                $("#'.$options['id'].'-legend-first").html(ui.values[0]);
                                $("#'.$options['id'].'-legend-last").html(ui.values[1]);
                            }
                    };
                    $(document).ready(function(){
                        $("#'.$options['id'].'").slider('.$options['id'].'opts);
                    });
                    </script>';
        $legend = '<div class="slider-legend">
                    <div class="first label label-inverse">'.$unit['prefix'].' <span id="'.$options['id'].'-legend-first">'.$slider['min'].'</span> '.$unit['suffix'].'</div>
                    <div class="last label label-inverse">'.$unit['prefix'].' <span id="'.$options['id'].'-legend-last">'.$slider['max'].'</span> '.$unit['suffix'].'</div>
                 </div>';
        $data = '<div class="slider-data">
                    <input id="'.$options['id'].'-data-first" type="hidden" name="data['. $options['name'] .']['.$fieldName.'][0]" value="'.$slider['min'].'">
                    <input id="'.$options['id'].'-data-last" type="hidden" name="data['. $options['name'] .']['.$fieldName.'][1]" value="'.$slider['max'].'">
                 </div>';
        $label = '<label class="control-label slider-label">' . $options['label'] . '</label>';

        $controls = '<div id="' . $options['id'] .'Slider" class="controls slider">
                        <div id="'. $options['id'] .'"></div>'. $legend . $data. '
                    </div>';

        $group = '<div class="control-group">' . $label . $controls . $script . '</div>';

        return $group;
    }

    public function inputSlider($fieldName, $options = array(), $slider = array(), $units = array()) {
        $unit['suffix'] = isset($units['suffix']) ? $units['suffix'] : '';
        $unit['prefix'] = isset($units['prefix']) ? $units['prefix'] : '';
        $script = '<script>
                    var '.$options['id'].'opts = {
                            range: "min",
                            animate: true,
                            max:'.$slider['max'].',
                            min:'.$slider['min'].',
                            value : '.$slider['selected'].',
                            slide: function( event, ui ){
                                $("#'.$options['id'].'-data-last").val(ui.value);
                                $("#'.$options['id'].'-legend-last").html(ui.value);
                            }
                    };
                    $(document).ready(function(){
                        $("#'.$options['id'].'").slider('.$options['id'].'opts);
                    });
                    </script>';
        $data = '<div class="slider-data">
                    <input id="'.$options['id'].'-data-last" type="hidden" name="data['. $options['name'] .']['.$fieldName.']" value="'.$slider['selected'].'">
                 </div>';
        $label = '<label class="control-label slider-label">' . $options['label'] . ': <div class="inline label label-inverse">'.$unit['prefix'].' <span id="'.$options['id'].'-legend-last">'.$slider['selected'].'</span> '.$unit['suffix'].'</div></label>';

        $controls = '<div id="' . $options['id'] .'Slider" class="controls slider">
                        <div id="'. $options['id'] .'"></div>'. $data . '
                    </div>';

        $group = '<div class="control-group">' . $label . $controls . $script . '</div>';

        return $group;
    }

    //$pre and $add are not binded to <span class="add-on">, instead the whole element should be given
    public function inputCombined($fieldName, $options = array(), $pre, $add, $help = null) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-prepend input-append">'.$pre,
            'after'  => $add.'<div class="input-help">'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    //Requires script: $('.dropdown-toggle').dropdown();
    //Requires id in $options
    //$add = array( array( 'label' => 'Greater than', 'value' => '>')  );
    public function inputCombinedOperators($fieldName, $options = array(), $pre = array(), $add, $help = null) {
        $pres = '';
        foreach($pre as $item){
            $pres .= '<li><a id="'.$fieldName.'-'.$item['value'].'" class="filter-op" data-filter="'.$options['id'].'" href="javascript:void(0);" data="'.$item['value'].'">'.$item['label'].'</a></li>';
        }
        $group = '<div class="btn-group">
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <span class="text">'.$pre[0]['label'].'</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">'.$pres.'</ul>
                  </div>';
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'label'  => array('class'=>'control-label'),
            'between'  => '<div class="controls input-prepend input-append">'.$group,
            'after'  => '<span class="add-on">'.$add.'</span><div class="input-help">'.$help.'</div></div>'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputNaked($fieldName, $options = array()) {
        $settings = array(
            //'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => false,
            'label'  => false,
            'style' => 'margin-bottom:0px;',
            //'class' => 'input-block-level'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function inputNakedId($fieldName, $options = array()) {
        $settings = array(
            //'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => false,
            'label'  => false,
            'style' => 'margin-bottom:0px;'
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    //Produces a toggle and its bind to a javascript ajax call, /js/app/app.interface.js line ~ 99
    //Model should have an online boolean attribute, which is accessed through data-model and data-id tag attribues
    public function switchToggle($fieldName, $options, $online){

        $settings = array(
            'type' => 'checkbox',
            'div' => array('class' => 'switch switch-mini switch-online', 'data-on' => "success", 'data-off' => "danger"),
            'label'  => false,
            'checked' => $online ? "checked" : false
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function switchAttr($fieldName, $options, $online){

        $settings = array(
            'type' => 'checkbox',
            'div' => array('class' => 'switch switch-mini switch-attr', 'data-on' => "success", 'data-off' => "danger"),
            'label'  => false,
            'data-toggle' => $fieldName,
            'checked' => $online ? "checked" : false
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    //Open for custom functionality
    public function simpleToggle($fieldName, $options, $online){

        $settings = array(
            'type' => 'checkbox',
            'div' => array('class' => 'switch switch-mini', 'data-on' => "success", 'data-off' => "danger"),
            'label'  => false,
            'checked' => $online ? "checked" : false
        );
        return $this->Form->input($fieldName, array_merge_recursive($settings, $options));
    }

    public function submitFilter($fieldName, $options = array()) {
        $settings = array(
            'format' => array('before', 'label', 'between', 'input', 'after', 'error'),
            'div' => array('class' => 'control-group'),
            'value' => __('Submit'),
            'class' => 'btn btn-primary'
        );
        return $this->Form->submit($fieldName, array_merge_recursive($settings, $options));
    }

    public function title($title){
        $header = '<div class="control-group control-header"><h5>'.$title.'</h5></div>';
        return $header;
    }

    public function anchorTitle($title){
        $header = '<a name="'.Inflector::slug($title).'" ><div class="control-group control-header"><h5>'.$title.'</h5></div></a>';
        return $header;
    }

    public function field($before = null, $data, $after = null, $mode = 'varchar'){
        if(!is_null($data)){
            if($mode == 'boolean')
                return $before . ' ' . $after;
            else
                return $before . ' ' . $data . ' ' . $after;
        }
        return null;
    }

    public function label($title, $data){
        $out = '';
        if($data){
            $out .= '<li><strong>'.$title.'</strong>: ' . $data . '</li>';
        }
        return $out;
    }
}
