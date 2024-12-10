<!--Các hàm xử lý liên quan đến CSDL-->
<?php
if(!defined('_CODE')){
    die('Access denied...');
}
function query($sql, $data=[], $check=false){
    global $connect;
    $ketqua = false;
    try{
        $statement = $connect->prepare($sql);

        if(!empty($data)){
            $ketqua = $statement->execute($data);
        }
        else{
            $ketqua = $statement->execute();
        }

    }catch(Exception $exp){
        echo $exp->getMessage().'</br>';
        echo 'File'.$exp ->getFile().'</br>';
        echo 'Line'.$exp ->getLine();
        die();
    }
    if($check == true){
        return $statement;
    }
    return $ketqua;
}
// Hàm thêm vào data
function insert($table, $data){
    $key = array_keys($data);
    $truong = implode(',', $key);
    $value = ':'. implode(',:', $key);

    $sql = 'INSERT INTO '. $table. '('. $truong .')'. 'VALUES('.$value.')';

    $kq = query($sql, $data);
    return $kq;
}
// Hàm sửa
function update($table, $data, $condition=''){
    $update = '';
    foreach($data as $key => $value) {
        $update .= $key .' = :'.$key.',';
    }
    $update = trim($update, ',');
    if(!empty($condition)){
        $sql = 'UPDATE '. $table .' SET '. $update .' WHERE ' . $condition;
    }else{
        $sql = 'UPDATE '. $table .' SET '. $update;
    }
    $kq = query($sql, $data);
    return $kq;
}
// Hàm xóa
function delete($table, $condition=''){
    if(empty($condition)){
       $sql = 'DELETE FROM '. $table;
    }else{
        $sql = 'DELETE FROM '. $table .' WHERE ' . $condition;
    }
    $kq = query($sql);
    return $kq;
}
function select($table, $condition=''){
    if(empty($condition)){
        $sql = 'DELETE FROM '. $table;
    }else{
        $sql = 'DELETE FROM '. $table .' WHERE ' . $condition;
    }
    $kq = query($sql);
    return $kq;
}
//Lấy nhiều dòng dữ liệu
function getRaw($sql){
$kq = query($sql,'',true);
if(is_object($kq)){
    $dataFetch = $kq->fetchAll(PDO::FETCH_ASSOC);
}
return $dataFetch;
}
//Lấy 1 dòng dữ liệu
function oneRaw($sql){
    $kq = query($sql,'',true);
    if(is_object($kq)){
        $dataFetch = $kq->fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}
//Đếm số dòng dữ liệu
function getRows($sql){
    $kq = query($sql,'',true);
    if(!empty($kq)){
        return $kq -> rowCount();
    }
}
