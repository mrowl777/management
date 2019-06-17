<div class="content_box">
{?!*is_admin*}
<div class="toggler">
<p>Показывать только мое</p>
<i class="icon-large set_my sm_off"></i>
</div>
{?}
<table border="1" class="settings_table">
<tr>
<th>ДАТА</th>
{%*times*}
  <th class= "{?*times:^KEY*=1}  {*settings:hide_left*} {?}" >{*times:*}</th>
{%}
</tr>
{%*settings*} 
<tr class="settings_tr {?!*settings:is_req_date*} not_required{?}">
<td>{*settings:l_date*}</td>
<td class="{*settings:left_side_color*} {*settings:hide_left*}">{*settings:left_side*}</td>
<td class="{*settings:right_side_color*} {*settings:hide_right*}">{*settings:right_side*}</td>
</tr>
{%}
</table>


<script src="/staff_management/base_page/js/settings.js"></script>
</div>