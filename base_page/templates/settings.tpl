<div class="content_box">
<table border="1" class="settings_table">
<tr>
<th>ДАТА</th>
{%*times*}
  <th>{*times:*}</th>
{%}
<th><i name='add_btn' class="icon-plus icon-large add"></i></th>
<th></th>
</tr>
{%*settings*} 
<tr class="settings_tr" id = "{*settings:key*}">
<td >{*settings:uid*}</td>
<td><input class="token" value = "{*settings:normal_date*}" > </input></td>
<td><i name='save_btn' class="icon-ok icon-large"></i> </td>
<td><i name='remove_btn' class="icon-remove icon-large rm"></i> </td>
</tr>
{%}
</table>


<script src="/staff_management/base_page/js/settings.js"></script>
</div>