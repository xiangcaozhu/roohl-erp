<?php

$ActionLogModel = Core::ImportModel( 'ActionLog' );

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $_POST['comment'];
$data['action'] = $_POST['action'];
$data['type'] = $_POST['type'];
$data['add_time'] = time();
$data['target_id'] = $_POST['target_id'];

$ActionLogModel->Add( $data );

echo 200;

?>