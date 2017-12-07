<?php
    include 'config.php';
    function  KETNOI($servername,$username,$password){
        $conn = mysqli_connect($servername, $username, $password);
        return  $conn;
    }
    function  KETNOI1($servername,$username,$password,$nameDB){
        $conn = mysqli_connect($servername, $username, $password,$nameDB);
        return  $conn;
    }
    function  QUERY($conn,$sql){
        return  mysqli_query($conn, $sql);
    }