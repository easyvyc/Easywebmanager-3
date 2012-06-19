// not animated collapse/expand
function togglePannelStatus(content)
{
    var expand = (content.style.display=="none");
    content.style.display = (expand ? "block" : "none");
    toggleChevronIcon(content);
}

// current animated collapsible panel content
var currentContent_collapse = null;

function togglePannelAnimatedStatus(content_id, interval, step)
{
	content = document.getElementById(content_id);
	content.style.overflow = 'hidden';
    // wait for another animated expand/collapse action to end
    if (currentContent_collapse==null)
    {
        currentContent_collapse = content;
        var expand = (currentContent_collapse.style.display=="none");
        if (expand)
            currentContent_collapse.style.display = "block";
        var max_height = currentContent_collapse.offsetHeight;

        var step_height = step + (expand ? 0 : -max_height);
        //toggleChevronIcon(content);

        //if(func!='') eval(func+'(\''+content_id+'\', \''+btn+'\')');
                
        // schedule first animated collapse/expand event
        currentContent_collapse.style.height = Math.abs(step_height) + "px";
        
        setTimeout("togglePannelAnimatingStatus(" + interval + "," + step + "," + max_height + "," + step_height + ")", interval);
    }
}

function togglePannelAnimatingStatus(interval, step, max_height, step_height){
    var step_height_abs = Math.abs(step_height);

    // schedule next animated collapse/expand event
    if (step_height_abs>=step && step_height_abs<=(max_height-step)){
        step_height += step;
        
        // Sicia kazkoks gliukas ivyksta ant IE7 
        currentContent_collapse.style.height = Math.abs(step_height) + "px";
        
        setTimeout("togglePannelAnimatingStatus(" + interval + "," + step + "," + max_height + "," + step_height + ")", interval);
    }
    // animated expand/collapse done
    else
    {
        if (step_height_abs<step)
            currentContent_collapse.style.display = "none";
        currentContent_collapse.style.height = "";
        currentContent_collapse = null;
    }
}

// change chevron icon into either collapse or expand
function toggleChevronIcon(content)
{
    var chevron = content.parentNode
        .firstChild.childNodes[1].childNodes[0];
    var expand = (chevron.src.indexOf("expand.gif")>0);
    chevron.src = chevron.src
        .split(expand ? "expand.gif" : "collapse.gif")
        .join(expand ? "collapse.gif" : "expand.gif");
}