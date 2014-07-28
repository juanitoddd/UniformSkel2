<script id="img-hb" type="text/x-handlebars-template">
    <tr class='gradeX sortable'>
        <td style="width:210px;" data-seq="{{count}}">
            <input class="sequence" type="hidden" name="data[Photo][{{count}}][sequence]" value="{{count}}">
            <a href="javascript:void(0);" class="upload-remove"></a>
            <input type="hidden" value="{{file}}" name="data[Photo][{{count}}][file]">
            <img src="{{scr}}">
        </td>
        <td>
            <label><?php echo __('Short description')?></label>
            <input type="text" class="input-xlarge" name="data[Photo][{{count}}][info]">
        </td>
    </tr>
</script>
<script>
    var img_hb = Handlebars.compile($("#img-hb").html());

    var step = 0; //
    var maxSteps = 2;
    var type = ''; // Type of garage
    var txtRemove = new String('<?php echo __('Remove'); ?>');
    var txtFirst = new String('<?php echo __('As first image'); ?>');

    var imgs = <?php echo sizeof($garage['Photo']); ?>;
    var catLevel = 0;

    var browser = $.browser;
    var runtime = '';
    if(browser.safari && browser.version == '534.50') runtime = 'flash,silverlight,browserplus,html4';
    else runtime = 'flash,html5,browserplus,html4,silverlight';
    //runtime = 'flash';

    // settings:
    var uploader = new plupload.Uploader({
        runtimes : runtime,
        runtime : 'gears,flash,html5,browserplus,html4,silverlight',
        browse_button : 'pickfiles',
        //container : 'upload_container',
        max_file_size : '5mb',
        unique_names: true,
        multipart: false,
        url : '/<?php echo "<?php echo __('{$pluralHumanName}');?>";?>/upload_images',
        flash_swf_url : '/js/plupload/plupload.flash.swf',
        silverlight_xap_url : '/js/plupload/plupload.silverlight.xap',
        filters : [
            {title : "Images", extensions : "jpg,gif,png"}
        ]
    });

    $(document).ready(function(){

        $( 'tbody', "#images" ).sortable({
            axis: "y",
            opacity: 0.8,
            placeholder: "sortable-placeholder",
            update: function( event, ui ) {
                var index = ui.item.index();
                if(index == 0){
                    var next = ui.item.next().attr('data-seq');
                    var seq = next - 1;
                }else if (index == imgs){
                    var before = ui.item.prev().attr('data-seq');
                    var seq = next + 1;
                }else{
                    var next = ui.item.next().attr('data-seq');
                    var before = ui.item.prev().attr('data-seq');
                    var seq = ( parseFloat(next) + parseFloat(before) ) / 2;
                }
                ui.item.attr('data-seq',seq);
                ui.item.find('.sequence').val(seq);
            }
        });
        $('tbody', "#images" ).disableSelection();
        $('a.upload-remove').live('click',function(){
            var that = this;
            var obj = $(this).parent().find('.photo-id');
            if(obj.length){
                var id = obj.val();
                $(that).parent().next().append('<img src="/img/loading.gif">');
                $.ajax({
                    url : '/photos/remove.json',
                    type: 'POST',
                    data: {id : id},
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR){
                        if(data){
                            $(that).parent().parent().remove();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                        console.log(textStatus);
                    }
                });
            }else{
                $(this).parent().parent().remove();
            }
        });
        // show mode, hide file_inputs
        uploader.bind('Init', function(up, params) {
            up.refresh();
        });
        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            $('#progress .bar').css('width', '20px');
            $('#loading').show();
            $('#progress').show();
            $.each(files, function(i, file) {
                $('#info').html(plupload.formatSize(file.size));
            });
            $('#info').show();
            up.refresh(); // Reposition Flash/Silverlight
            uploader.start();
            //e.preventDefault();
            up.refresh();
        });
        uploader.bind('UploadProgress', function(up, file) {
            $('#progress .bar').css('width', file.percent*2+'px');
        });
        uploader.bind('Error', function(up, args) {
            up.refresh();
        });
        uploader.bind('FileUploaded', function(up, file, info) {
            $('#loading').fadeOut(600);
            $('#progress').fadeOut(600);
            $('#info').fadeOut(600);
            var obj = $.parseJSON(info.response);
            if(obj.result){
                obj.scr = '/img/dyn/200/200/0/0' + obj.file;
                obj.count = imgs;
                $('table#images').append(img_hb(obj));
                $( 'tbody',"#images" ).sortable( "refresh" );
                imgs++;
            }
        });
    });
</script>
<div id="content-header">
    <h1><?php echo "<?php echo __('add {$singularHumanName}');?>";?></h1>
    <?php if (strpos($action, 'add') !== false){
        echo "\t\t\t\t\techo \$this->Form->postLink(\$this->Html->Tag('i', array('class'=>'icon-trash icon-white')). __('Delete {$singularHumanName}', array('action' => 'delete', \$this->request->data['Item']['id']), array('class'=>'btn btn-danger', 'escape'=>false), __('Are you sure you want to delete # %s?', \$this->request->data['Item']['id']));\n";
    } ?>
</div>
<div id="breadcrumb">
    <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="/<?php echo $pluralVar;?>"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></a>
    <a href="#" class="current"><?php echo "<?php echo __('add {$singularHumanName}');?>";?></a>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-pencil"></i>
                    </span>
                    <ul id="itemstate">
                        <li class="first"><?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span', '1 ' . __('{$singularHumanName}')), array('action' => 'edit', \$this->request->data['{$modelClass}']['{$primaryKey}']), array('escape' => false));?>"?></li>
                        <li class="current"><span><?php echo "<?php echo '2 ' . __('Images');?>";?></span></li>
                        <li><span><?php echo "<?php echo '3 ' . __('Review');?>";?></span></li>
                    </ul>
                </div>
                <div class="widget-content nopadding">
                    <?php echo "<?php echo \$this->Form->create('{$modelClass}',array('class'=>'form-horizontal'));?>\n";?>
                        <div class="control-group" style="padding-bottom:10px;">
                            <label class="control-label"><?php echo __('Images')?></label>
                            <div class="controls">
                                <a id="pickfiles" class="btn btn-warning" href="javascript:void(0);"><i class="icon-camera icon-white"></i> <?php echo __('Upload images');?></a>
                                <div id="info"></div>
                                <div id="progress">
                                    <div class="bar"></div>
                                </div>
                                <div id="loading">
                                    <img src="/img/loading.gif"/>
                                </div>
                            </div>
                        </div>
                        <table id="images" class="table table-bordered data-table">
                            <tbody>
                            <?php echo "<?php \$i = 0;\n";
echo "\t\t\t\t\t\t\tforeach (\$this->request->data['Photo'] as \$photo): ?>\n";?>
                            <tr class='gradeX sortable' data-seq="<?php echo "<?php echo \$photo['sequence'];?>";?>">
                                <td style="width:310px;">
                                    <input class="photo-id" type="hidden" name="data[Photo][<?php echo "<?php echo \$i;?>";?>][id]" value="<?php echo "<?php echo \$photo['id'];?>";?>">
                                    <input class="sequence" type="hidden" value="<?php echo "<?php echo \$i;?>";?>" name="data[Photo][<?php echo "<?php echo \$i;?>";?>][sequence]">
                                    <a href="javascript:void(0);" class="upload-remove"></a>
                                    <img src="/img/dyn/200/200/1/1<?php echo "<?php echo \$photo['file'];?>";?>">
                                </td>
                                <td>
                                    <label><?php echo __('Short description')?></label>
                                    <input type="text" class="input-xlarge" name="data[Photo][<?php echo "<?php echo \$i;?>";?>][info]" value="<?php echo "<?php echo \$photo['info'];?>";?>">
                                </td>
                            </tr>
<?php echo "\t\t\t\t\t\t\t<?php \$i++;\n";
 echo "\t\t\t\t\t\t\tendforeach;?>\n";?>
                            </tbody>
                        </table>
<?php echo "\t\t\t\t\t<?php echo \$this->Form->end(array('label' => __('save'),'div'=>'form-actions','class'=>'btn btn-primary'));?>\n"; ?>
                </div>
            </div>
        </div>
    </div>
</div>