<?php
include "baglan.php";
if(isset($_FILES['image'])){ //Resmi kontrol et
    $errors= array();
    $file_name = $_FILES['image']['name']; //Resmi değişkene kaydedin
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    @$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    $yol = "images/".str_replace('', '%20' ,$file_name);

    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152){

        $errors[]='File size must be excately 2 MB';
    }
    $link = mysqli_connect("localhost", "root", "", "album");
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"images/".$file_name);
        echo "<script type='text/javascipt'>alert('Başarılı');</script>";
        $aciklama =$_POST["aciklama"];
        $tarih = $_POST["tarih"];
        $grup = $_POST["grup"];
       // $qry='SELECT * FROM grup WHERE grup_id="'.$grup.'"';
        //echo "tarih == ".$tarih;
        //echo "grup == ". $grup;
        $ekle = $conn->prepare("insert into dosyalar set dosya_id, dosya_yolu=?, dosya_aciklama=?, dosya_tarih=?, dosya_grup=? ");
        $ekle  ->execute(array($yol, $aciklama, $tarih, $grup));
        $x = $ekle -> fetchAll(PDO::FETCH_ASSOC);
        if($x ->rowCount()>0){
            echo "veriler eklendi"."<br>";
            echo "yönlendiriliyor....";
            header("refresh: 2" ,"url=kullanici.php");
        }else{
            echo "veri eklenemedi";
        }

    }else{
        print_r($errors);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
    <table class="table">
        <tr><td><input type="file" name="image"/></td></tr>
        <tr><td><input type="text" name="aciklama"/></td> </tr>
        <tr><td><input type="date" name="tarih"/></td></tr>
        <tr>
            <td>Grup Seç :</td>
            <td><select name="grup" id="cb">
                    <?php
                    $sql= "select * from grup ";
                    $query = $conn-> prepare($sql);
                    $query -> execute(array());
                    $kayitlar = $query -> fetchAll(PDO::FETCH_ASSOC);
                    foreach($kayitlar as $kayit)
                    {
                        echo "<option value=".$kayit["grup_id"].">".$kayit["grup_adi"]."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
              <td><br><input type="submit" value="Gönder" /> </td></tr>
    </table>


</form>
</body>
</html>