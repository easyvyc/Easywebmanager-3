<block name="loged_user.id">
<p>{phrases.user_loged}: {loged_user.firstname} {loged_user.lastname} ({loged_user.email})</p>
<a href="javascript:void($.ajax({ type:'GET', url:'ajax.php?content=login&lng={lng}&target=order_user&prefix=o', success:function(html){ $('#order_user').html(html);} }))">{phrases.login_other_account}</a>
</block name="loged_user.id">

<p>
<a href="javascript: void(get('ajax.php?content=register&lng={get.lng}&ajax=1', 'WINDOW'));">{phrases.change_user_info}</a>
</p>


<p>
<a href="{get.lng}/logout/">{phrases.logout}</a>
</p>