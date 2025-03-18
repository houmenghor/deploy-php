<?php
include("conection.php");
    $id   = $_POST['txt-id'];
    $name = trim($_POST['txt-name']);
    $name = $con->real_escape_string($name);
    $des  = trim($_POST['txt-des']);
    $des  = str_replace('\n','<br>', $des);
    $des  = $con->real_escape_string($des);
    $img = $_POST['txt-img-name'];
    $status = $_POST['txt-status'];
    $editId = $_POST['txt-edit-id'];
    $msg['edit']=false;
    //check dublicate name
    $sql = "select * from citys where name_city='$name' && id != $id";
    $rs  = $con->query($sql);
    if ($rs->num_rows>0){
        $msg['dpl']=true;
    } else {
        $msg['dpl']=false;
        if($editId == 0){
            $sql = "INSERT INTO citys VALUES(NULL,'$name','$des','$img',$status)";
            $con->query($sql);
            $msg['id'] = $con->insert_id;
        }else{
            $sql = "UPDATE `citys` SET 
            name_city='$name',
            des_city='$des',
            img='$img',
            status='$status' 
            WHERE id = $editId";
            $con->query($sql);
            $msg['edit']=true;
        }
        
    }
    echo json_encode($msg);