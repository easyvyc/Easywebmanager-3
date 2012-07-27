<block name="loged_user.id" no>
<h2>{phrases.register_title}</h2>

<call code="name=form::set=var::module=users::method=loadRegisterForm::params=">
{form}

</block name="loged_user.id" no>


<block name="loged_user.id">
<h2>{phrases.register_edit_title}</h2>

<call code="name=form::set=var::module=users::method=loadEditUser::params=">
{form}

</block name="loged_user.id">