<?php
include "baglan.php";
$ekle =$conn-> prepare("insert into grup set grup_adi=?");
if(isset($_POST["submit"])){
    $kategoriName = $_POST["kategoriName"];
    if(empty($kategoriName)){
        echo "Lütfen Boş Bırakmayınız!";
    }else{
        $ekle->execute(array($kategoriName));
       // $x =$ekle->fetchAll(PDO::FETCH_ASSOC);
        if($ekle->rowCount()>0){
            echo "veriler eklendi"."<br>";
            echo "Yönlendiriyor...";
            header("refresh: 2; url=form.php");
        }else{
            echo "veri eklenemedi";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
    <h1>Yönetici Kategori Ekleme</h1>
    <table class="table">
        <tr>
            <td>
                <label>KATEGORİ ADI GİRİNİZ :</label>
            </td>
            <td>
                <input type="text" name="kategoriName" />
            </td>
        </tr>
        <tr>
            <td>
                <br><input style="font-weight: bolder; margin-left: 100px" type="submit" name="submit" value="KAYIT ET" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>

