var amline_src = amline_path+'amline.swf?amline_settingsFile='+amline_settingsFile+'&amline_dataFile='+amline_dataFile+'&amline_path='+amline_path+'&amline_flashWidth='+escape(amline_flashWidth)+'&amline_flashHeight='+escape(amline_flashHeight)+'&amline_preloaderColor='+amline_preloaderColor;
document.write ('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+amline_flashWidth+'" height="'+amline_flashHeight+'" id="amline" align="middle">');
document.write ('<param name="allowScriptAccess" value="sameDomain" />');
document.write ('<param name="movie" value="'+amline_src+'" />');
document.write ('<param name="quality" value="high" />');
document.write ('<param name="scale" value="noscale" />');
document.write ('<param name="salign" value="lt" />');
document.write ('<param name="wmode" value="transparent" />');
document.write ('<param name="bgcolor" value="'+amline_backgroundColor+'" />');
document.write ('<embed src="'+amline_src+'" quality="high" scale="noscale" salign="lt" bgcolor="'+amline_backgroundColor+'" width="'+amline_flashWidth+'" height="'+amline_flashHeight+'" name="amline" align="middle" wmode="transparent" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
document.write ('</object>');
