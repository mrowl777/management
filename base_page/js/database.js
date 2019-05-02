init_events();

function init_events() {
    $('.delete_panel_user').on('click', delete_panel_usr);
    $('.add_staff').on('click', show_form);
    $('.icon-ok').on('click', add_staff);
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

function add_staff(e) {
    console.log('clicked');
    var name = $('.name').val();
    var surname = $('.surname').val();
    var last_name = $('.last_name').val();
    var time = $('.time').val();
        $.post(
            "index.php",
            {
                action: "add_staff",
                first_name: name,
                last_name: last_name,
                surname: surname,
                time: time,
            },
            on_base_answer
        );
    
}

function on_base_answer(data) {
    $('.content_box').replaceWith(data);
}

function show_form(){
    var r_part_0 = '<table border="1" class="database_table">';
    var r_part_1 = '<tr class="database_tr" id="new">';
    var r_part_2 = "<td><input type='text' class='new_pass_form name' placeholder='введите имя '></input></td>";
    var r_part_3 = "<td><input type='text' class='new_pass_form surname' placeholder='введите отчество '></input></td>";
    var r_part_4 = "<td><input type='text' class='new_pass_form last_name' placeholder='введите фамилию '></input></td>";
    var r_part_6 = '<td title="Добавить" class="delete_panel_user"><i class="icon-ok icon-large"></i></td>';
    var r_part_5 = "<td><input type='text' class='new_pass_form  time' placeholder='время работы'></input><td>";
    var r_part_7 = '</tr> ';
    var r_part_8 = '</table>';
    var render = r_part_0+r_part_1 +r_part_2+r_part_3+r_part_4+r_part_5+r_part_6+r_part_7+r_part_8;
    $(this).replaceWith(render);
}
