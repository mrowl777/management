<div class="content_box">
<table border="1" class="database_table">
<tr>
<th>имя</th>
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
    <td>{*staffs:work_time_type*}</td>
    <td title=" Уволить сотрудника" class='delete_panel_user'><i class="icon-remove-user icon-large"></i></td>
    </tr>    
{%}
</table>

<script src="/staff_management/base_page/js/database.js"></script>
</div>