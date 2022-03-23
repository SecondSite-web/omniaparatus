<?php
 
$msg = '';
$result = false;
 
if(isset($_POST['submit'])){
 
 require_once '../php/connect-pdo.php';
 global $conn;
 global $username;
 global $password;
 try {
 // create database connection
 // $conn = new PDO($conn, $username, $password);
 
 // create new department
 $result = create_dept();
 
 // display the insert form again
 display_form();
 
 } catch (PDOException $e) {
 echo $e->getMessage();
 }
}
else{
 // display insert form
 display_form();
}

//If the form is not submitted, we display it. If it is submitted, we perform the logic as described above. The following are the functions for the each step:

//Validate department function:

	
/**
 * validate department
 * @return department name on success or false on failure
 */
function validate_dept(){
 global $msg;
 
 $dept_name = $_POST['department'];
 
 if($dept_name != ''){
 $dept_name = filter_var($dept_name,FILTER_SANITIZE_STRING);
 return $dept_name;
 }else{
 $msg =  'Please enter the department name';
 return false;
 }
}

// Check department exists function:

/**
 * Check if a department exists
 * @param string $dept_name department name
 * @return NULL|boolean return true if department exists, false
 *         if it does not exist, and NULL on failure
 */
function dept_exist($dept_name){
 global $msg, $conn;
 
 $sql_select = "SELECT department_no
        FROM departments
        WHERE name = " . $conn->quote($dept_name) . "
        LIMIT 1";
 
 $stmt = $conn->query($sql_select);
 
 if($stmt === false){
 $msg = 'Error querying departments table';
 return NULL;
 }
 
 $r = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($r !== false){
 $msg = "Department with name $dept_name already exists.";
 return true;
 }else
 return false;
 
}

// Insert a new department function:
/**
 * insert a new department table
 * @param string $dept_name department name
 * @return boolean return true on success or false on failure
 */
function insert_dept($dept_name){
 global $conn, $msg;
 // construct SQL insert statement
 $sql_insert = "INSERT INTO departments(name)
    VALUES(" . $conn->quote($dept_name) .")";
 
 if($conn->exec($sql_insert) === false){
 $msg = 'Error inserting the department.';
 return false;
 }else{
 $msg = "The new department $dept_name is created";
 return true;
 }
}

// Create new department function that includes the logic of validating, checking for existence and inserting:
	
/**
 * insert new department
 * @param string $msg message 
 * @return boolean return true on success, false on failure
 */
function create_dept(){
 // validate department
 $dept_name = validate_dept();
 
 if($dept_name){
 // check if the department exists
 if(!dept_exist($dept_name)){
 // insert the department
 return insert_dept($dept_name);
 } 
 }
 return false;
}

// Display error or success message function:
/**
 * display message based on message type
 * @param string $msg message to display
 * @param boolean $type true: success message, 
 * 			false: failed message
  */
function display_msg($msg,$type){
 $type === true ? $cssClass = "alert-success" :
   $cssClass = "alert-error";
 if($msg != ''){
 ?>
 <div class="alert <?php echo $cssClass; ?>">
 <?php echo $msg; ?>
 </div>
 <?php 
 }
}

// Display form function:


/**
 * display the create new department form
 */
function display_form()
{
    global $msg, $result; ?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>Create Department</title>
	<link href="../css/sb-admin-2.min.css" rel="stylesheet">
	</head>
	<body>
	 <div class="container" style="margin-top:20px;">
	 <form action = "<?php $_SERVER['PHP_SELF']?>"
	 method = "POST"
	 class = "form-horizontal">
	 <?php display_msg($msg, $result); ?>
	 
	 <div class="control-group">
	 <label for="department" class="control-label">Department:</label>
	 <div class="controls">
	 <input type="text"
	        name="department"
	        id="department"
	        class="input-xlarge"
	        placeholder="Enter department name" />
	 </div>
	 </div>
	 <br />
	 <div class="control-group">
	 <div class="controls">
	 <input name="submit"
	        type="submit"
	        value="Create Department"
	        class="btn btn-primary" />
	 </div>
	 </div>
	 
	 </form>
	 </div>
	</body>
	</html>
 <?php
 
}