<?php
session_start();
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            
            $userName = "";
            if (isset($column[0])) {
                $userName = mysqli_real_escape_string($conn, $column[0]);
            }
            $password = "";
            if (isset($column[1])) {
                $password = mysqli_real_escape_string($conn, $column[1]);
            }
            
            $created_by = $_SESSION['name'];

            $is_admin = "";
            if (isset($column[2])) {
                $is_admin = mysqli_real_escape_string($conn, $column[2]);
            }
            
            $sqlInsert = "INSERT into my_users (full_name,password,created_by,is_admin)
                   values (?,?,?,?)";
            $paramType = "ssss";
            $paramArray = array(
                $userName,
                $password,
                $created_by,
                $is_admin
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="style.css">


		<script type="text/javascript">
		$(document).ready(function() {
		    $("#frmCSVImport").on("submit", function () {

			    $("#response").attr("class", "");
		        $("#response").html("");
		        var fileType = ".csv";
		        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
		        if (!regex.test($("#file").val().toLowerCase())) {
		        	    $("#response").addClass("error");
		        	    $("#response").addClass("display-block");
		            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
		            return false;
		        }
		        return true;
		    });
		});
		</script>
	</head>
<body class="  bg-light">
	<div class="container p-5 bg-white">
		<?php
			//session_start();
			if (isset($_SESSION['name'])) {
				
					echo "<h3 class='text-secondary'>Welcome <span class='text-warning font-weight-bold'>".$_SESSION['name']."</span></h3><a class='float-right font-weight-bold' href='logout.php'>Logout</a>";
		?>

		<div id="response"
		        class="text-success font-weight-bold <?php if(!empty($type)) { echo $type . " display-block"; } ?>">
		<?php if(!empty($message)) { echo $message; } ?>
		        </div>
		    <div class="outer-scontainer">
		        <div class="row mt-5">

		            <form class="form-horizontal" action="" method="post"
		                name="frmCSVImport" id="frmCSVImport"
		                enctype="multipart/form-data">
		                <div class="input-row">
		                    <label class="col-md-4 control-label">Choose CSV
		                        File</label> 
		                    <input type="file" name="file"
		                        id="file" accept=".csv">
		                    <button type="submit" id="submit" name="import"
		                        class="btn-submit mb-5 mt-2 mx-3">Import</button>
		                    <br />

		                </div>

		            </form>

		        </div>
		<?php
		            $sqlSelect = "SELECT * FROM my_users";
		            $result = $db->select($sqlSelect);
		            if (! empty($result)) {
		                ?>
		            <table id='userTable' border="1">
		            <thead>
		                <tr>
		                    <th>User Name</th>
		                    <th>Created by</th>
		                    <th>Is admin</th>

		                </tr>
		            </thead>
		<?php
		                
		                foreach ($result as $row) {
		                    ?>
		                    
		                <tbody>
		                <tr>
		                    <td><?php  echo $row['full_name']; ?></td>
		                    <td><?php  echo $row['created_by']; ?></td>
		                    <td><?php  echo $row['is_admin']; ?></td>
		                </tr>
		                    <?php
		                }
		                ?>
		                </tbody>
		        </table>
		<?php } ?>
		    </div>

		<?php		
			}
			else{
		?>
				<div class="row my-5 py-5">
					<div class="col-sm-6 py-5 text-center" style="box-sizing: border-box;">
						<h3>oops...</h3>
						<h1>4<span class="text-warning">0</span>4</h1>
						<span>Failed to authenticate.<br>Authentication session has expired</span><br>
						<a href="index.php">Click here to login!</a>	
					</div>
					<div class="col-sm-6">
						<img src="https://lh3.googleusercontent.com/proxy/fj030otWi04w80l0vgrm8TxMOwlGcmumQBtyUXT_48Ti9JD01f_rfa9E3hu-ftIctG4aRwsM578Sz0zNgbua94xM">
					</div>
				</div>
		<?php
			}
		?>
	</div>
</body>
</html>