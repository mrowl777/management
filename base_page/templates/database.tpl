<div class="content_box">



{?!*have_access*}
  <div class="access_denied">Доступ запрещен. Управлять сотрудниками может только менеджер.</div>
  <div>Если вас только что зарегистрировали, рекомендуем  <button class="change_pass">изменить пароль</button></div>
{?}


{?*have_access*}
{?!*new_user*}<button class="add_staff">Добавить сотрудника </button>{?}

{%*new_user*}
 <div> Сотрудник создан! Передайте данные: </div>
 <div>Логин: {*new_user:login*}</div>
 <div>Пароль: {*new_user:password*}</div>
{%}
<table border="1" style="margin-bottom: 20px; display:none;" class="database_table new_staff">
<tr class="database_tr" id="new">
<td><input type='text' class='new_pass_form name' placeholder='введите имя '></input></td>
<td><input type='text' class='new_pass_form surname' placeholder='введите отчество '></input></td>
<td><input type='text' class='new_pass_form last_name' placeholder='введите фамилию '></input></td>
<td><select id="usr_time">
<option disabled>Выберите время работы</option>
{%*times*}
  <option value="{*times:^KEY*}">{*times:*}</option>
{%}
</select><td>
<td colspan="2"><i class="icon-ok icon-large load"></i></td>
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
    <td>{?* staffs:is_active = 0 *} УВОЛЕН <i title="Удалить сотрудника" class="icon-large icon-delete-user remove_worker"></i> {?} {?* staffs:is_active = 1 *} {*staffs:work_time_type*}  {?}</td>
    {?* staffs:is_active = 1 *}
    <td title="Уволить сотрудника" class='delete_panel_user'><i class="icon-remove-user icon-large"></i></td>
    {?}
    {?* staffs:is_active = 0 *}
    {* <td title="Восстановить сотрудника" class='set_worker'><i class="icon-large fa-user-plus"></i></td> *}
    <td>
      <i title="Восстановить сотрудника" class="icon-large fa-user-plus set_worker"></i>
    </td>
    {?}
    </tr>    
{%}
</table>
{?}
<script src="/staff_management/base_page/js/database.js"></script>
</div>