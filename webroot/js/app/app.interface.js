$(document).ready(function(){

    // === Chosen === //

    $('input[type=checkbox],input[type=radio],input[type=file]').uniform();

    $('select').chosen();

    $("span.icon input:checkbox, th input:checkbox").click(function() {
        var checkedStatus = this.checked;
        var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');
        checkbox.each(function() {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.checker > span').removeClass('checked');
            }
            if (this.checked) {
                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });

    // === Tooltips === //
    $('.tip').tooltip();
    $('.tip-left').tooltip({ placement: 'left' });
    $('.tip-right').tooltip({ placement: 'right' });
    $('.tip-top').tooltip({ placement: 'top' });
    $('.tip-bottom').tooltip({ placement: 'bottom' });

    // === Online Toogle === //
    $('.switch-online').on('switch-change', function (e, data) {
        var $el = $(data.el)
        var model = $el.attr('data-model');
        var id = $el.attr('data-id');
        var url = '/'+ model + '/toggleAjax/' + id + '.json'
        $.getJSON(url,function(json){
            if(!json){
                $el.parent().bootstrapSwitch('setState', false);
            }
        });
    });

    $('.switch-attr').on('switch-change', function (e, data) {
        var $el = $(data.el);
        var model = $el.attr('data-model');
        var id = $el.attr('data-id');
        var attr = $el.attr('data-toggle');
        var url = '/'+ model + '/toggleAttr.json';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                'id':   id,
                'attr': attr
            },
            success: function(data, textStatus, jqXHR){
                console.log(data);
                /*if(!json){
                 $el.parent().bootstrapSwitch('setState', false);*/
            }
        });
    });

    // === Search input typeahead === //
    $('#search input[type=text]').typeahead({
        source: ['Dashboard','Form elements','Common Elements','Validation','Wizard','Buttons','Icons','Interface elements','Support','Calendar','Gallery','Reports','Charts','Graphs','Widgets'],
        items: 4
    });

    // === Sticky footer === // Disabled
    /*
    var docHeight = $(window).height();
    var footerHeight = $('#footer').height();
    var footerTop = $('#footer').position().top + footerHeight;
    if (footerTop < docHeight) {
        $('#footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
    }
    */

    // === Collapsable Menu === //
    $('#toggleNav').live('click', function(){
        var mode = $('#container').hasClass('compact');
        $('#container').toggleClass('compact');
        if(mode){
            $(this).find('i').addClass('icon-arrow-left');
            $(this).find('i').removeClass('icon-arrow-right');
        }else{
            $(this).find('i').removeClass('icon-arrow-left');
            $(this).find('i').addClass('icon-arrow-right');
            window.setTimeout(function(){
                if($('#container').hasClass('compact'))
                    $('.open').removeClass('open');
            },500);
        }
        session({menu:!mode});
    })
});
