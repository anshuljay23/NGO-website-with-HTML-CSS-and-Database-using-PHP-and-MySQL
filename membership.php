<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>
    * {
    box-sizing: border-box;
    }

    body {
    background-color: #e9e466;
    }

    #adoptForm {
    background-color: #ffffff;
    margin: 100px auto;
    font-family: Raleway;
    padding: 40px;
    width: 70%;
    min-width: 300px;
    opacity: 0.9;
    }

    h1 {
    text-align: center;  
    }

    input {
    padding: 10px;
    width: 100%;
    font-size: 17px;
    font-family: Raleway;
    border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
    background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
    display: none;
    }

    button {
    background-color: #04AA6D;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    font-size: 17px;
    font-family: Raleway;
    cursor: pointer;
    }

    button:hover {
    opacity: 0.8;
    }

    #prevBtn {
    background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbbbbb;
    border: none;  
    border-radius: 50%;
    display: inline-block;
    opacity: 0.5;
    }

    .step.active {
    opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
    background-color: #04AA6D;
    }
    </style>
<body>
    <div class="container">
        <?php 
        if (isset($_POST["submit"])) 
        {


            $fname = $_POST['fname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $age = $_POST['age'];
            $address = $_POST['address'];
            $period = $_POST['period'];
            $uname = $_POST['uname'];
            $pword = $_POST['pword'];
            $passwordRepeat = $_POST["repeat_password"];

            $errors = array();  

            if (strlen($pword) <8) 
            { 
                array_push($errors, "Password must be at least 8 charactes long"); 
            }

            if ($pword!==$passwordRepeat) 
            { 
                array_push($errors, "Password does not match");    
            }
           
            if (empty($fname) OR empty($email)) 
            { 
                array_push($errors, "All fields are required"); 
            }      

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            { 
                array_push($errors, "Email is not valid");         
            }


            require_once "database.php";
            $sql = "SELECT * FROM member_info WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0)
            {
                array_push($errors, "Email already Exists!");
            }

            if (count($errors)>0) 
            {
                foreach ($errors as $error) 
                {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            else
            {
                require_once "database.php";
                $sql = "INSERT INTO member_info (fname, email, phone, age, address, period, uname, pword) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt) 
                {
                    mysqli_stmt_bind_param($stmt,"ssiissss",$fname, $email, $phone, $age, $address, $period, $uname, $pword);
                    mysqli_stmt_execute($stmt); 
                    echo "<div class='alert alert-success'>You are registered successfully.</div>"; 
                }
                else
                { 
                    die ("Something went wrong");
            
                }
            }
        }

        ?>
               
                    <form id="adoptForm" action="membership.php" method="post">
                    <h1>Membership Form</h1>
                <!-- One "tab" for each step in the form: -->
                    <p>
                        <img src="logo.png" height="200px" width="200px">
                        <br>
                        Fill up the required details.
                        <br>
                        <br>
                        Membership Fees: 3000/- per month.
                        <br>
                        Do keep logging in using your username and password for frequent updates.
                        <br>
                        For any queries you can write to us on <strong> littlevoices@gmail.com</strong>

                    </p>
                    <br>
                    <p><input placeholder="Full Name"  name="fname"></p>
                    Contact Info:
                    <p><input placeholder="E-mail"  name="email"></p>
                    <p><input placeholder="Phone Number"  name="phone"></p>
                    Age (in years):
                    <p><input placeholder="Age"  name="age"></p>
                    Address:
                    <p><input placeholder="Address"  name="address"></p>
                    Period:
                    <select name="period">
                    <option value="One Year">One Year</option>
                    <option value="Six Months">Six Months</option>
                    <option value="Nine Months">Nine Months</option>
                    </select> 
                    <br>
                    <br>
                    Create Username and Password:
                    <p><input placeholder="Username"  name="uname"></p>
                    <p><input placeholder="Password"  name="pword" type="password"></p>
                    <p><input placeholder=" Re-enterPassword"  name="repeat_password" type="password"></p>
                    <p><input type="submit" class="btn btn-primary" value="Join Us" name="submit"><p>
                </form>
    </div>
</body> 
</html>