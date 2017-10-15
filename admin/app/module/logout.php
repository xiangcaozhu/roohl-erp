<?php

/*
@@acc_freet
@@acc_title="注销登陆"

*/

$ClientAuth = Core::ImportBaseClass( 'ClientAuth' );
$ClientAuth->CleanAuth();

Redirect( '?mod=login' );

exit();


?>