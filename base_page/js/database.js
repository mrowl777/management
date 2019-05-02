init_events();

function init_events() {
    $('.delete_panel_user').on('click', delete_panel_usr);
    $('.set_worker').on('click', set_worker);
    $('.add_staff').on('click', show_form);
    $('.load').on('click', add_staff);
}

function delete_panel_usr(e) {
    var username = $(this).parent().attr('id');
    if(confirm("Вы уверены?")){
        $.post(
            "index.php",
            {
                action: "delete_panel_usr",
                username: username
            },
            on_base_answer
        );
    }
    
}

function set_worker(e) {
    var username = $(this).parent().attr('id');
    if(confirm("Вы уверены?")){
        $.post(
            "index.php",
            {
                action: "set_worker",
                username: username
            },
            on_base_answer
        );
    }
    
}

function add_staff(e) {
    var name = $('.name').val();
    var _surname = $('.surname').val();
    var _last_name = $('.last_name').val();
    var _time = $( "#usr_time option:selected" ).val();
        $.post(
            "index.php",
            {
                action: "add_staff",
                first_name: name,
                last_name: _last_name,
                surname: _surname,
                time: _time,
            },
            on_base_answer
        );
    
}

function on_base_answer(data) {
    $('.content_box').replaceWith(data);
}

function show_form(){
    $(this).hide();
    $('.new_staff').show();
}
