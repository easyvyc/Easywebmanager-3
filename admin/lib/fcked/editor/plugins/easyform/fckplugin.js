<<<<<<< HEAD
/*
=======
>>>>>>> 2ad9858e80767c041fc8283a2072391720111870
FCKCommands.RegisterCommand( '_Form', new FCKDialogCommand( "_Form", FCKLang.DlgFormTitle, FCKConfig.PluginsPath + 'easyform/fck_form.html', 450, 350));
var oFormItem		= new FCKToolbarButton( '_Form', FCKLang.DlgFormTitle) ;
oFormItem.IconPath	= FCKConfig.PluginsPath + 'easyform/img/form.gif' ;
FCKToolbarItems.RegisterItem( '_Form', oFormItem ) ;

// Context menu
FCK.ContextMenu.RegisterListener( {
	AddItems : function( menu, tag, tagName )
	{
		if ( tagName == 'FORM' )
		{
			//menu.RemoveAllItems() ;
			menu.AddSeparator();
			menu.AddItem( '_Form', FCKLang.DlgFormTitle, oFormItem.IconPath ) ;
		}
	}}
);
<<<<<<< HEAD
*/

// Double click
//FCK.RegisterDoubleClickHandler( editForm, 'FORM' ) ;
=======


// Double click
FCK.RegisterDoubleClickHandler( editForm, 'FORM' ) ;
>>>>>>> 2ad9858e80767c041fc8283a2072391720111870

function editForm( oNode )
{
	if (oNode)
<<<<<<< HEAD
		FCK.Commands.GetCommand( 'Form' ).Execute() ;
=======
		FCK.Commands.GetCommand( '_Form' ).Execute() ;
>>>>>>> 2ad9858e80767c041fc8283a2072391720111870
	else	
		return ;
}
