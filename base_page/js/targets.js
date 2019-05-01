init_events();

function init_events() {
    $('[name=save_btn]').on('click', save_param);
    $('[name=save_new_btn]').on('click', add_target);
    $('[name=add_btn]').on('click', form_render);
    $('[name=remove_btn]').on('click', rm_target);
    $('input').on('keydown', btn_activator );
}

function save_param(){
    var _id = $( this ).parent().parent().attr('id');
    $.post(
        "index.php",
        {
            action: "toggle_target",
            id: _id
        },
        on_settings_answer
    );
}

function add_target(){
    var _id = $( document ).find('.key').val();
    $.post(
        "index.php",
        {
            action: "add_target",
            id: _id
        },
        on_settings_answer
    );
}

function rm_target(){
    var _key = $( this ).parent().parent().attr('id');
    if(confirm("Вы уверены?")){
        $.post(
            "index.php",
            {
                action: "rm_target",
                key: _key
            },
            on_settings_answer
        );
    }    
}

function btn_activator(){
    var ico = $( this ).parent().parent().find('i').first();
    ico.css('color', 'greenyellow');
}

function form_render(){
    if(!document.getElementsByClassName('new')[0]){
        var place = $(document).find('tr').first();
        var part_1 = '<tr class="database_tr new">';
        var part_2 = '<td colspan="5"><input name="key" class="key" placeholder="Введите ID"> </input></td>';
        var part_4 = '<td><i name="save_new_btn" class="icon-ok icon-large"></i> </td>';
        var part_6 = '</tr>';
        var form = part_1 + part_2  + part_4  + part_6;
        place.after(form);
        init_events();
    }
}

function on_settings_answer(data) {
    $('.content_box').replaceWith(data);
}