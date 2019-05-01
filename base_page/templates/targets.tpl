<div class="content_box">
<table border="1" class="settings_table">
<tr>
<th>ID</th>
<th>Имя</th>
<th>Фамилия</th>
<th>Статус</th>
<th colspan="2"><i name='add_btn' class="icon-plus icon-large add"></i></th>
</tr>
{%*targets*} 
<tr class="database_tr" id = "{*targets:vk_id*}">
<td>{*targets:vk_id*}</td>
<td>{*targets:name_first*}</td>
<td>{*targets:name_last*}</td>
<td>{?*targets:active*}Активен{?}</td>
<td><i name='save_btn' class="icon-ok icon-large {?*targets:active*}active{?}"></i> </td>
<td><i name='remove_btn' class="icon-remove icon-large rm"></i> </td>
</tr>
{%}
</table>


<script src="/staff_management/base_page/js/targets.js"></script>
</div>