<div class="content_box">
<button class="add_staff">Добавить сотрудника </button>
<table border="1" style="margin-bottom: 20px; display:none;" class="database_table new_staff">
<tr class="database_tr" id="new">
<td><input type='text' class='new_pass_form name' placeholder='введите имя '></input></td>
<td><input type='text' class='new_pass_form surname' placeholder='введите отчество '></input></td>
<td><input type='text' class='new_pass_form last_name' placeholder='введите фамилию '></input></td>
<td><i class="icon-ok icon-large load"></i></td>
<td><input type='text' class='new_pass_form  time' placeholder='время работы'></input><td>
</tr> 
</table>
<table border="1" class="database_table">
<tr>
<th>ИМЯ</th>
<th>ФАМИЛИЯ</th>
<th>ОТЧЕСТВО</th>
<th>РАБОЧЕЕ ВРЕМЯ</th>
<th></th>
</tr>
{%*staffs*} 
    <tr class="database_tr" id="{*staffs:id*}">
    <td>{*staffs:first_name*}</td>
    <td>{*staffs:last_name*}</td>
    <td class='pass'>{*staffs:surname*}</td>
    <td>{?* staffs:is_active = 0 *} УВОЛЕН {?} {?* staffs:is_active = 1 *} {*staffs:work_time_type*}  {?}</td>
    {?* staffs:is_active = 1 *}
    <td title="Уволить сотрудника" class='delete_panel_user'><i class="icon-remove-user icon-large"></i></td>
    {?}
    {?* staffs:is_active = 0 *}
    <td title="Восстановить сотрудника" class='set_worker'><i class="icon-large fa-user-plus"></i></td>
    {?}
    </tr>    
{%}
</table>

<script src="/staff_management/base_page/js/database.js"></script>
</div>