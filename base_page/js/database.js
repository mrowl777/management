init_events();

function init_events() {
    $('.delete_panel_user').on('click', delete_panel_usr);
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

function show_form(){
    var input = "<input type='text' class='new_pass_form' placeholder='введите новый пароль'></input>";

    $( this ).parent().find('.pass').text('');
    $( this ).parent().find('.pass').append( input );
    $( this ).find('i').removeClass('icon-change');
    $( this ).find('i').addClass('icon-ok');
    $( this ).find('i').on('click', change_usr_pass );
}
