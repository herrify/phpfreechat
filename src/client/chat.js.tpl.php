var pfc_version               = '<?php echo $version; ?>';
var pfc_nickname              = '<?php echo ($GLOBALS["output_encoding"]=="UTF-8" ? addslashes($u->nick) : iconv("UTF-8", $GLOBALS["output_encoding"],addslashes($u->nick))); ?>';
var pfc_clientid              = '<?php echo md5(uniqid(rand(), true)); ?>';
var pfc_title                 = '<?php echo addslashes($title); ?>';
var pfc_refresh_delay         = <?php echo $refresh_delay; ?>;
var pfc_start_minimized       = <?php echo $start_minimized ? "true" : "false"; ?>;
var pfc_nickmarker            = <?php echo $nickmarker ? "true" : "false"; ?>;
var pfc_clock                 = <?php echo $clock ? "true" : "false"; ?>;
var pfc_showsmileys           = <?php echo $showsmileys ? "true" : "false"; ?>;
var pfc_showwhosonline        = <?php echo $showwhosonline ? "true" : "false"; ?>;
var pfc_focus_on_connect      = <?php echo $focus_on_connect ? "true" : "false"; ?>;
var pfc_max_text_len          = <?php echo $max_text_len; ?>;
var pfc_quit_on_closedwindow  = <?php echo $quit_on_closedwindow ? "true" : "false"; ?>;
var pfc_debug                 = <?php echo $debug ? "true" : "false"; ?>;
var pfc_max_text_len          = <?php echo $max_text_len; ?>;
var pfc_btn_sh_smileys        = <?php echo $btn_sh_smileys ? "true" : "false"; ?>;
var pfc_btn_sh_whosonline     = <?php echo $btn_sh_whosonline ? "true" : "false"; ?>;
var pfc_connect_at_startup    = <?php echo $connect_at_startup ? "true" : "false"; ?>;
var pfc_defaultchan = Array(<?php
                         function quoteandescape($v) { return "'".addslashes($v)."'"; }
                         $list = array(); foreach($c->channels as $ch) {$list[] = $ch; }
                         $list = array_map("quoteandescape",$list);
                         echo implode(",", $list);
                         ?>);
var pfc_userchan = Array(<?php
                         $list = array(); foreach($u->channels as $ch) {$list[] = $ch["name"];}
                         $list = array_map("quoteandescape",$list);
                         echo implode(",", $list);
                         ?>);
var pfc_privmsg = Array(<?php
                        $list = array(); foreach($u->privmsg as $pv) {$list[] = $pv["name"];}
                        $list = array_map("quoteandescape",$list);
                        echo implode(",", $list);
                        ?>);
var pfc_openlinknewwindow = <?php echo $openlinknewwindow ? "true" : "false"; ?>;
<?php
$bbcode_clist = array("FFFFFF","000000","000055","008000","FF0000","800000","800080","FF5500","FFFF00","00FF00","008080","00FFFF","0000FF","FF00FF","7F7F7F","D2D2D2");
?>
var pfc_bbcode_color_list = Array(<?php
                        $list = array(); foreach($bbcode_clist as $v) {$list[] = $v;}
                        $list = array_map("quoteandescape",$list);
                        echo implode(",", $list);
                        ?>);
<?php
$nickname_clist = array('#CCCCCC','#000000','#3636B2','#2A8C2A','#C33B3B','#C73232','#80267F','#66361F','#D9A641','#3DCC3D','#1A5555','#2F8C74','#4545E6','#B037B0','#4C4C4C','#959595');
?>
var pfc_nickname_color_list = Array(<?php
                                    $list = array(); foreach($nickname_clist as $v) {$list[] = $v;}
                                    $list = array_map("quoteandescape",$list);
                                    echo implode(",", $list);
                                    ?>);
var pfc_proxy_url = '<?php echo $data_public_url."/".$serverid."/proxy.php"; ?>';


/* create our client which will do all the work on the client side ! */
var pfc = new pfcClient();
<?php

$labels_to_load =
array( "Do you really want to leave this room ?",
       "Hide nickname marker",
       "Show nickname marker",
       "Hide dates and hours",
       "Show dates and hours",
       "Disconnect",
       "Connect",
       "Magnify",
       "Cut down",
       "Hide smiley box",
       "Show smiley box",
       "Hide online users box",
       "Show online users box",
       "Please enter your nickname",
       "Private message",
       "Close this tab",
       "Enter your message here",
       "Enter your nickname here",
       "Bold",
       "Italics",
       "Underline",
       "Delete",
       "Mail",
       "Color",
       "PHP FREE CHAT [powered by phpFreeChat-%s]",
       );
foreach($labels_to_load as $l)
{
  echo "pfc.res.setLabel('".$l."','".addslashes(_pfc2($l))."');\n";
}

$fileurl_to_load =
array( 'images/ch.gif',
       'images/pv.gif',
       'images/tab_remove.gif',
       'images/ch-active.gif',
       'images/pv-active.gif',
       'images/user.gif',
       'images/user-me.gif',
       'images/color-on.gif',
       'images/color-off.gif',
       'images/clock-on.gif',
       'images/clock-off.gif',
       'images/logout.gif',
       'images/login.gif',
       'images/maximize.gif',
       'images/minimize.gif',
       'images/smiley-on.gif',
       'images/smiley-off.gif',
       'images/online-on.gif',
       'images/online-off.gif',
       'images/bt_strong.gif',
       'images/bt_em.gif',
       'images/bt_ins.gif',
       'images/bt_del.gif',
       'images/bt_mail.gif',
       'images/bt_color.gif',
       );

// convert bbcode color value list to a bbcode color url list
function get_bbcode_color_url($v) { return 'images/color_'.$v.'.gif'; }
$bbcode_clist = array_map("get_bbcode_color_url",$bbcode_clist);

$fileurl_to_load = array_merge($fileurl_to_load, $bbcode_clist);
foreach($fileurl_to_load as $f)
{
  echo "pfc.res.setFileUrl('".$f."',pfc_proxy_url+'".$c->getFileUrlByProxy($f,false)."');\n";
}

foreach($smileys as $s_file => $s_str) { 
  for($j = 0; $j<count($s_str) ; $j++) {
    echo "pfc.res.setSmiley('".$s_str[$j]."',pfc_proxy_url+'".$c->getFileUrlByProxy($s_file,false)."');\n";
  }
}

?>    

pfc.gui.buildChat();
pfc.connectListener();
pfc.refreshGUI();
if (pfc_connect_at_startup) pfc.connect_disconnect();

<?php if ($debugxajax) { ?>
xajax.DebugMessage = function(text)
{
  var s = new String(text);
  text = s.escapeHTML();
  rx  = new RegExp('&lt;','g');
  text = text.replace(rx, '\n&lt;');
  $('debugxajax').innerHTML += '\n---------------\n' + text;
}
<?php } ?>