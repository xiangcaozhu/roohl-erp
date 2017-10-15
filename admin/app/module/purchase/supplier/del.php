<?php
/*
@@acc_title="删除"
*/
$id = (int)$_GET['id'];

$CenterSupplierModel = Core::ImportModel('CenterSupplier');
$CenterSupplierModel->Del($id);

Redirect( '?mod=purchase.supplier' );

?>