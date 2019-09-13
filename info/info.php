
<?php
include_once '../connectDB/connectDB.php';
$userID = $_GET["id"];

$stmt = $conn->prepare('SELECT * FROM dataUsers where userID='.$userID);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();
$result = $result[0];
$conn = null
?>
<?php
function ibm($height,$weight){
    $IBM=round($weight/($height*$height)*10000,2);
    return $IBM;
}

$ibm=ibm($result['height'],$result['weight']);

function checkBMI($ibm,$gender){
    if($gender=="Male"){
        if ($ibm<18.5){
            echo "<h3><p style='color:red'' >Bạn đang quá gầy <img src='images/anhquagay.gif' height='100px' weight='80px'></p></h3>";
        }elseif ($ibm<22.9){
            echo "<h3><p style='color:greenyellow''>Hãy giữ thân hình này nhé! Tuyệt vời <img src='images/tuyetvoinu.gif' height='100px' weight='80px'></p></h3>";
        }elseif ($ibm==23){
            echo"<h3><p style='color:red''>Phải vận động rồi! <img src='images/phaivandongnu.gif' height='100px' weight='80px'></p></h3>";
        }elseif ($ibm<25){
            echo "<h3><p style='color:red''>Tiền béo phì! Ăn ít thôi! <img src='images/t.gif' height='100px' weight='80px'></p></h3>";
        }elseif ($ibm<30){
            echo "<h3><p style='color:red''>Giảm cân đê bạn ơi! <img src='images/g.gif' height='100px' weight='80px'></p></h3>";
        }elseif ($ibm<40){
            echo "<h3><p style='color:red''>Phải giảm cân ngay! <img src='images/ph.gif' height='100px' weight='80px'></p></h3>";
        }else{
            echo"<h3><p style='color:red''> Giảm cân khẩn cấp! <img src='images/giamcankhancap.gif' height='100px' weight='80px'></p></h3>";
        }

    }elseif ($gender=="Female") {
        if ($ibm < 18.5) {
            echo "<h3><p style='color:red''>Bạn đang quá gầy <img src='images/anhquagay.gif' height='100px' weight='80px'></p></h3>";
        } elseif ($ibm < 25) {
            echo "<h3><p style='color:greenyellow''>Hãy giữ thân hình này nhé! Tuyệt vời <img src='images/tuyetvoinam.gif' height='100px' weight='80px'></p></h3>";
        } elseif ($ibm == 25) {
            echo"<h3><p style='color:red''>Phải vận động rồi!<img src='images/t.gif'' height='100px' weight='80px'></p></h3>";
        } elseif ($ibm < 30) {
            echo "<h3><p style='color:red''>Tiền béo phì! Ăn ít thôi! <img src='images/quagay.jpg' height='100px' weight='80px'></p></h3>";
        } elseif ($ibm < 35) {
            echo "<h3><p style='color:red''>Giảm cân đê bạn ơi! <img src='images/g.gif' height='100px' weight='80px'></p></h3>";
        } elseif ($ibm < 40) {
            echo "<h3><p style='color:red''>Phải giảm cân ngay! <img src='images/ph.gif' height='100px' weight='80px'></p></h3>";
        } else {
            echo"<h3><p style='color:red''> Giảm cân khẩn cấp! <img src='images/giamcankhancap.gif' height='100px' weight='80px'></p></h3>";
        }
    }
}
function calo($height,$weight,$age,$gender){
    if ($gender=="Male"){
        $calo = round(13.397 * $weight+ (4.799 * $height)-(5.677 * $age) + 88.362,2);
        return $calo;
    }else if($gender=='Female'){
        $calo = round(9.247 * $weight+ (3.098 * $height)-(4.330 * $age) + 447.593,2);
        return $calo;
    }
}
?>
<!doctype html>
<html lang="en">
<?php include "../layout/header.php"?>
<body>

<div id="wrapper">
    <?php include '../layout/sidebar.php'?>
<div >
<h1>Thông tin cá nhân </h1>
<div class="table">
    <table>
        <tr>
            <td>Name</td>
            <td><?php echo $result["userName"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $result["email"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Height</td>
            <td><?php echo $result["height"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Weight</td>
            <td><?php echo $result["weight"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php echo $result["gender"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Age</td>
            <td><?php echo $result["age"] ?></td>
            <td></td>
        </tr>
        <tr>
            <td>IBM</td>
            <td ><?php echo ibm($result['height'],$result['weight'])?></td>
            <td></td>
        </tr>
        <tr>
            <td>Lượng calo cần cho mỗi ngày </td>
            <td ><?php echo calo($result['height'],$result['weight'],$result['age'],$result['gender']);?></td>
            <td ><span><a href="editUser.php?id=<?php echo $result['userID']?>&userName=<?php echo $result['userName'] ?>">Update</a></span></td>
        </tr>
    </table>
    <p> <?php checkBMI($ibm,$result['gender']);?></p>
    <br>
    <br>
    <br>
    <br>

</div>
<?php include '../layout/footer.php'?>
<?php  ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
        }

        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"image/".$file_name);
            echo "Success";
        }else{
            print_r($errors);
        }
    }
}
?>

</div>

</div>
</div>

</body>
</html>
