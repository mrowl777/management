<div class="content_box">
<table border="1" class="database_table">
<tr>
<th>ID</th>
<th>USERNAME</th>
<th>PASSWORD</th>
<th>HASH</th>
<th>IS_ADMIN</th>
<th>REG_DATE</th>
<th></th>
<th></th>
<th></th>
</tr>
{%*panel_users*} 
    <tr class="database_tr" id="{*panel_users:nickname*}">
    <td>{*panel_users:id*}</td>
    <td>{*panel_users:nickname*}</td>
    <td class='pass'>{*panel_users:password*}</td>
    <td>[ hidden ]</td>
    <td>{*panel_users:is_admin*}</td>
    <td>{*panel_users:reg_date*}</td>
    <td title="Удалить пользователя" class='delete_panel_user'><i class="icon-remove-user icon-large"></i></td>
    <td title="Сделать администратором" class="grand_access {?*panel_users:is_admin*}active{?}"><i class="icon-crown-user icon-large"></i></td>
    <td title="Изменить пароль" class="change_pass"><i class="icon-change icon-large"></i></td>
    </tr>    
{%}
</table>

<script src="/onl_tracker/base_page/js/database.js"></script>
</div>