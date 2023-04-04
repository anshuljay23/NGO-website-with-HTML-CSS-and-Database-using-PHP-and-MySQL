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
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $amount = $_POST['amount'];
            $options = $_POST['options'];

            $errors = array();  
           
            if (empty($fname) OR empty($email)) 
            { 
                array_push($errors, "All fields are required"); 
            }      

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            { 
                array_push($errors, "Email is not valid");         
            }


            require_once "database.php";
            $sql = "SELECT * FROM donate_info WHERE email = '$email'";
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
                $sql = "INSERT INTO donate_info (fname, email, phone, dob, address, amount, options) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt) 
                {
                    mysqli_stmt_bind_param($stmt,"ssissis",$fname, $email, $phone, $dob, $address, $amount, $options);
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
               
                    <form id="adoptForm" action="donation.php" method="post">
                    <h1>Donation Information Form</h1>
                <!-- One "tab" for each step in the form: -->
                    <p>
                        <img src="logo.png" height="200px" width="200px">
                        <br>
                        Fill up the required details.
                        <br>
                        We will get back to you shortly via Email ID and Phone Number
                        <br>
                        [**Please make sure you have entered correct Email ID and Phone Number.]
                        <br> 
                        Do keep logging in using your username and password for frequent updates.
                        <br>
                        For any queries you can write to us on <strong> littlevoices@gmail.com</strong>

                    </p>
                    <p><input placeholder="Full Name"  name="fname"></p>
                    Contact Info:
                    <p><input placeholder="E-mail"  name="email"></p>
                    <p><input placeholder="Phone Number"  name="phone"></p>
                    Birthday:
                    <p><input placeholder="dd-mm-yyyy"  name="dob"></p>
                    Address:
                    <p><input placeholder="Address"  name="address"></p>

                    <p><input placeholder="Amount"  name="amount"></p>
                    Mode of payment:
                    <select name="options">
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    </select> 
                    <br>
                    <p><input type="submit" class="btn btn-primary" value="Donate" name="submit"><p>
                </form>
    </div>
</body> 
</html>
