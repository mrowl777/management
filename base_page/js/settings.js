init_events();

function init_events() {
    $('[name=save_btn]').on('click', save_param);
    $('[name=save_new_btn]').on('click', add_param);
    $('[name=add_btn]').on('click', form_render);
    $('[name=remove_btn]').on('click', rm_param);
    $('input').on('keydown', btn_activator );
    $('.set_my').on('click', set_my);
}

function set_my(){
    var cur = $(this).css('content');
}

function save_param(){
    var param = $( this ).parent().parent().find('.token').val();
    var _key = $( this ).parent().parent().attr('id');
    $.post(
        "index.php",
        {
            action: "setup_param",
            key: _key,
            value: param
        },
        on_settings_answer
    );
}

function add_param(){
    var param = $( this ).parent().parent().find('.token').val();
    var _key = $( this ).parent().parent().find('[name=key]').val();
    $.post(
        "index.php",
        {
            action: "add_param",
            key: _key,
            value: param
        },
        on_settings_answer
    );
}

function rm_param(){
    var _key = $( this ).parent().parent().attr('id');
    if(confirm("Вы уверены?")){
        $.post(
            "index.php",
            {
                action: "rm_param",
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
    var place = $(document).find('tr').first();
    var part_1 = '<tr class="database_tr">';
    var part_2 = '<td><input name="key" class="key" placeholder="Введите ключ"> </input></td>';
    var part_3 = '<td><input class="token" placeholder="Введите значение" > </input></td>';
    var part_4 = '<td><i name="save_new_btn" class="icon-ok icon-large"></i> </td>';
    var part_5 = '<td></td>';
    var part_6 = '</tr>';
    var form = part_1 + part_2 + part_3 + part_4 + part_5 + part_6;
    place.after(form);
    init_events();
}

function on_settings_answer(data) {
    $('.content_box').replaceWith(data);
}