init_events();

function init_events() {
    $('.delete_panel_user').on('click', delete_panel_usr);
    $('.grand_access').on('click', grand_access_usr);
    $('.change_pass').on('click', show_form);
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

function on_base_answer(data) {
    $('.content_box').replaceWith(data);
}

function grand_access_usr(e) {
    var username = $(this).parent().attr('id');
    $.post(
        "index.php",
        {
            action: "toggle_rights_usr",
            username: username
        },
        on_base_answer
    );
}

function show_form(){
    var input = "<input type='text' class='new_pass_form' placeholder='введите новый пароль'></input>";

    $( this ).parent().find('.pass').text('');
    $( this ).parent().find('.pass').append( input );
    $( this ).find('i').removeClass('icon-change');
    $( this ).find('i').addClass('icon-ok');
    $( this ).find('i').on('click', change_usr_pass );
}

function change_usr_pass(){
    var username = $( this ).parent().parent().attr('id');
    var _password = $( this ).parent().parent().find('input').val();
    $.post(
        "index.php",
        {
            action: "change_usr_pass",
            username: username,
            password: _password
        },
        on_base_answer
    );
}