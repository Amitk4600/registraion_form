<?php

session_start();
include_once("config.php");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int)$_POST['age']; // Ensure age is treated as an integer
    $costume = mysqli_real_escape_string($conn, $_POST['costume']);
    $category = (int)$_POST['category'];
}

$createProcedure = "
CREATE PROCEDURE createCostume(

    IN name VARCHAR(255),
    IN email VARCHAR(255),
    IN age INT,
    IN costume VARCHAR(255),
    IN category INT,
    IN rental_date DATE,
    IN return_date DATE,
     IN renter_name VARCHAR(255),
    IN renter_email VARCHAR(255),
    IN rental_price DECIMAL(10,2)

    )
  
BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error creating costume';
END;

    START TRANSACTION;
-- Insert the costume into the costumes table
    INSERT INTO costumes (name, email, age, costume, category)
    VALUES (name, email, age, costume, category);

SET @costume_id := LAST_INSERT_ID();

--  INSERT costume into the rentals table
    INSERT INTO costume_rentals ( costume_id, rental_date, return_date, renter_name, renter_email, rental_price)
    VALUES ( @costume_id, rental_date, return_date, renter_name, renter_email, rental_price);

    COMMIT;     
END;
";
// $res = mysqli_query($conn, $createProcedure);


$callProcedure = "
CALL createCostume(
    '$name','$email','$age','$costume','$category',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 DAY),'amit','bRt0O@example.com',100)";
// $res = mysqli_query($conn, $callProcedure);
//************************************************************************************************************ */
// check rollback :- error in costume_rentals table query (typo error in rental_dat, should be rental_date)

$rollbackProcedure = "
CREATE PROCEDURE checkRollback(

    IN name VARCHAR(255),
    IN email VARCHAR(255),
    IN age INT,
    IN costume VARCHAR(255),
    IN category INT,
    IN rental_date DATE,
    IN return_date DATE,
     IN renter_name VARCHAR(255),
    IN renter_email VARCHAR(255),
    IN rental_price DECIMAL(10,2)

    )
  
BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'roll back ho gya bhai';
END;

    START TRANSACTION;
-- Insert the costume into the costumes table
    INSERT INTO costumes (name, email, age, costume, category)
    VALUES (name, email, age, costume, category);

SET @costume_id := LAST_INSERT_ID();

--  INSERT costume into the rentals table
    INSERT INTO costume_rentals ( costume_id, rental_date, return_date, renter_name, renter_email, rental_price)
    VALUES ( @costume_id, rental_dat, return_date, renter_name, renter_email, rental_price);

    COMMIT;     
END;
";
// $res = mysqli_query($conn, $rollbackProcedure);



$callRollbackProcedure = "
CALL checkRollback(
    '$name','$email','$age','$costume','$category',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 DAY),'amit','bRt0O@example.com',100)";
// $res = mysqli_query($conn, $callRollbackProcedure);

/******************************************************************************************* */
// check rollback :- error in callToProcedure

$rollbackCallProcedure = "
CREATE PROCEDURE callToProcedure(

    IN name VARCHAR(255),
    IN email VARCHAR(255),
    IN age INT,
    IN costume VARCHAR(255),
    IN category INT,
    IN rental_date DATE,
    IN return_date DATE,
     IN renter_name VARCHAR(255),
    IN renter_email VARCHAR(255),
    IN rental_price DECIMAL(10,2)

    )
  
BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'roll back ho gya bhai call procedure kiya tabhi';
END;

    START TRANSACTION;
-- Insert the costume into the costumes table
    INSERT INTO costumes (name, email, age, costume, category)
    VALUES (name, email, age, costume, category);

SET @costume_id := LAST_INSERT_ID();

--  INSERT costume into the rentals table
    INSERT INTO costume_rentals ( costume_id, rental_date, return_date, renter_name, renter_email, rental_price)
    VALUES ( @costume_id, rental_date, return_date, renter_name, renter_email, rental_price);

    COMMIT;     
END;
";
// $res = mysqli_query($conn, $rollbackCallProcedure );
$callToProcedure = "
CALL callToProcedure(
    '$name','$email','$age','$costume','$category',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 DAY),'amit','bRt0O@example.com',100)";


// $res = mysqli_query($conn, $callToProcedure);
// if($res){
//     echo "success";
// }else{
//     echo "error";
// }
/******************************************************************************************* */
// check rollback :- with 3 query

$rollbackCallProcedureQuery = "
CREATE PROCEDURE callToProcedureQuery(

    IN name VARCHAR(255),
    IN email VARCHAR(255),
    IN age INT,
    IN costume VARCHAR(255),
    IN category INT,
    IN rental_date DATE,
    IN return_date DATE,
     IN renter_name VARCHAR(255),
    IN renter_email VARCHAR(255),
    IN rental_price DECIMAL(10,2)

    )
  
BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'roll back ho gya bhai call procedure kiya tabhi';
END;

    START TRANSACTION;
-- Insert the costume into the costumes table
    INSERT INTO costumes (name, email, age, costume, category)
    VALUES (name, email, age, costume, category);

SET @costume_id := LAST_INSERT_ID();

--  INSERT costume into the rentals table
    INSERT INTO costume_rentals ( costume_id, rental_date, return_date, renter_name, renter_email, rental_price)
    VALUES ( @costume_id, rental_date, return_date, renter_name, renter_email, rental_price);

-- update costume_rentals table
  UPDATE costume_rentals SET renteremail = 'XYvHb@example.com' WHERE costume_id = 1;

    COMMIT;     
END;
";
// $res = mysqli_query($conn, $rollbackCallProcedureQuery);
$ThreeQuerycallToProcedure = "
CALL callToProcedureQuery(
    '$name','$email','$age','$costume','$category',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 DAY),'amit','bRt0O@example.com',100)";
// $res = mysqli_query($conn, $ThreeQuerycallToProcedure);


// check rollback :- with 3 query phale update ,insert ,delete query( typo error in table name delete query it is costume should be costumes) 

$modifyProcedure = "
CREATE PROCEDURE modifyProcedure(

    IN name VARCHAR(255),
    IN email VARCHAR(255),
    IN age INT,
    IN costume VARCHAR(255),
    IN category INT,
    IN rental_date DATE,
    IN return_date DATE,
     IN renter_name VARCHAR(255),
    IN renter_email VARCHAR(255),
    IN rental_price DECIMAL(10,2)

    )
  
BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'roll back ho gya bhai kisi query me error hua hai';

END;

    START TRANSACTION;

    --  Update the renter_email in the costume_rentals table
 UPDATE costume_rentals SET renter_email = 'updated@example.com' WHERE costume_id = 16;

    --  Insert into the costumes table
    INSERT INTO costumes (name, email, age, costume, category)
    VALUES (name, email, age, costume, category);

 
    SET @costume_id := LAST_INSERT_ID();

    --  Insert into the costume_rentals table
    INSERT INTO costume_rentals (costume_id, rental_date, return_date, renter_name, renter_email, rental_price)
    VALUES (@costume_id, rental_date, return_date, renter_name, renter_email, rental_price);

    --  Delete from a costume (deliberate error)
    DELETE FROM costume WHERE costume_id = @costume_id;

    COMMIT;     
END;
";
// $res = mysqli_query($conn, $modifyProcedure);
$callToModifyProcedure = "
CALL modifyProcedure(
    '$name','$email','$age','$costume','$category',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 DAY),'amit','bRt0O@example.com',100)";
// $res = mysqli_query($conn, $callToModifyProcedure);
if ($res) {
    echo "success";
} else {
    echo "error";
}
