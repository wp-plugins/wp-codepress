<?php
/*
Plugin Name: WP-CodePress
Plugin URI: http://rulesplayer.890m.com/blog/?page_id=4
Description: Adds syntax highlighting to the plugin/theme editor in the admin panel through CodePress
Version: 1.0
Author: bobef
Author URI: http://rulesplayer.890m.com
*/

/*  Copyright 2008 bobef (email : look it up)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('admin_footer','wpcp_footer');

function wpcp_footer()
{
	global $file;
	$base=basename($_SERVER['SCRIPT_NAME']);
	$type=strstr(basename($file),'.');
	if($type=='.php') $type='php';
	else if($type=='.css') $type='css';
	else if($type=='.js') $type='javascript';
	else if($type=='.html' || $type=='.htm') $type='html';
	else $type=null;
	if($type && ($base=='plugin-editor.php' || $base=='theme-editor.php'))
	{
	?>
	<script type="text/javascript">
	var wpcp_ta=document.getElementById("newcontent");
	if(wpcp_ta)
	{
		wpcp_ta.form.onsubmit=function()
		{
			//do some hacky stuff because codepress screws up our form
			var inp=document.createElement("input");
			inp.setAttribute("type","hidden");
			inp.setAttribute("name","newcontent");
			inp.setAttribute("value",newcontent.getCode());
			wpcp_ta.form.appendChild(inp);
			return true;
		}
		wpcp_ta.className="codepress <?php echo($type);?>";
		var wpcp_href="<?php echo(trailingslashit(get_option('siteurl')).'/wp-content/plugins/wp-codepress/codepress/codepress.js'); ?>";
		var wpcp_ie=window.ActiveXObject;
		var wpcp_safari=(document.childNodes && !document.all && !navigator.taintEnabled);
		if(document.body || (!wpcp_safari && !wpcp_ie))
		{
			var wpcp_parent=document.getElementsByTagName("head")[0];
			var wpcp_node=document.createElement('script');
			wpcp_node.type='text/javascript';
			wpcp_node.src=wpcp_href;
			wpcp_parent.appendChild(wpcp_node);
		}
		else document.write('<script type="text/javascript" src="'+wpcp_href+'"><\/script>');
	}
	</script>
	<?php
	}
}

?>