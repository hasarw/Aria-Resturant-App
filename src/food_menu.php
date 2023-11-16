<?php require_once "core/header.php"; ?>
<?php require_once "core/db.php";

session_start();

if(!isset($_SESSION['user_type'])){
    header("Location: ../login.php");
}

if($_SESSION['user_type'] == 4){
        header("Location: ../login.php");
}

?>

<div class="container">

    <div class="col-md-12" id="add_food_row">

        <table class="table" id="table-right" >
            <tbody>
            <tr>
                <th>شماره</th>
                <th>نام غذا</th>
                <th>تصویر</th>
                <th>قیمت</th>
                <th>مربوط به</th>
                <th>حذف</th>
            </tr>


            <?php
            $query = "select * from food";
            $number = 1;
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                // output data of each row

                while ($row = $result->fetch_assoc()) {

                    echo "<tr>
                <td>$number</td>
                <td>$row[food_name]</td>

                <td><img class='img-box' src='images/$row[food_photo]'> </td>
                <td>$row[food_cost]</td>
                ";

                    if ($row[food_type] == 1) {
                        $food_type = "رستوران";
                    } else {
                        $food_type = "تالار";
                    }
                    echo "<td>$food_type</td>
                    <td><a href='food_menu.php?food_id=$row[food_id]' onclick='return confirm_delete()' class='btn btn-sm btn-info' name='deleteFood'>حذف غذا</a></td>
            </tr>";
                    $number++;
                }
            }
            ?>
            </tbody>
        </table>

    </div>
</div>



    <div class="container">
    <div class="row" >
        <div class="col-md-6" id="add_food_row_2">
        <div class="row" style="padding: 50px">
        <button class="btn btn-info" id="add_food" style="float: right">اضافه نمودن غذا</button>
        </div>
        <div id="form-elements" class="hidden">
        <form method="post" action="food_menu.php" class="form_right" enctype="multipart/form-data">
            <fieldset>
            <div class="form-group">
                <label>نام غذا</label>
            <input type="text" class="form-control" placeholder="" name="food_name">
            </div>

            <div class="form-group">
                <label>قیمت</label>
                <input type="number" class="form-control" placeholder="" name="food_cost">
            </div>


            <div class="form-group">
                <label>عکس مربوطه</label>
            <input type="file" name="food_image">
            </div>

            <div class="form-group">
                    <label for="food_type">نوع:</label>
                    <select class="form-control" id="sel1" name="food_type" style="height: 50px">
                        <option value="1">رستوران</option>
                        <option value="2">تالار</option>

                    </select>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="ذخیره">
            </div>
            </fieldset>
        </form>
        </div>

    </div>
    </div>
        </div>

<script src="../assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {
    $( "#add_food" ).click(function() {
        $("#form-elements").toggleClass("hidden");
    });
    });
</script>


<?php

if(isset($_POST['submit'])){

    $food_name = $_POST['food_name'];
    //$food_photo = $_POST['food_image'];
    $food_type = $_POST['food_type'];
    $food_cost = $_POST['food_cost'];

    if($food_name != ""){

        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["food_image"]["name"]);
        $food_photo = basename($_FILES["food_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["food_image"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["food_image"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["food_image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["food_image"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

$sql = "INSERT INTO food (food_id, food_name, food_photo, food_type, food_cost)
VALUES (null, '$food_name', '$food_photo', $food_type, '$food_cost')";

if ($conn->query($sql) === TRUE) {

    echo "<script>window.location = 'food_menu.php';</script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}else{
        echo "<script>alert('فورم خالی است');</script>";
    }
}
?>


<?php

if(isset($_GET['food_id'])){

    $food_id = $_GET['food_id'];
    $sql = "delete from food where food_id = '$food_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('حذف شد');</script>";
        echo "<script>window.location = 'food_menu.php';</script>";


    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>


<?php require_once "footer.php"; ?>

<script type="text/javascript">
    function confirm_delete() {
        return confirm('آیا مطمعن هستید؟');
    }
</script>

