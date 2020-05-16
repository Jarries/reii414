<?php
    session_start();
    require_once "config.php";
    
    if(isset($_POST["Patient_Submit"]))
    {
        
        $ID_Num=$_POST["patient_username"];
        $sqli="select Name,Extract(Year from BirthDate) AS BirthYear from Biographical Where ID_Number=$ID_Num";
        if($result = $conn->query($sqli))
        {
            $row = $result->fetch_array();
            $year=$row['BirthYear'];
            //echo $year;
            $current = date("Y");
            //echo $current;
            $diff=$current-$year;
            //echo $diff;
        }   
        else
        {
            echo $conn->error;
        }
        $Login_Password=trim($_POST["patient_password"]);
        $sql = "SELECT Name,Surname,Password,Fathers_ID,Mothers_ID FROM Biographical WHERE ID_Number=$ID_Num"; 

            if($result = $conn->query($sql))
            {
                $row = $result->fetch_array();
                $database_Password=$row['Password'];
                $database_Surname=$row['Surname'];
                $database_Initials=$row['Name'];
                $database_Fathers_ID=$row['Fathers_ID'];
                $database_Mothers_ID=$row['Mothers_ID'];
                if($database_Password == $Login_Password)
                {
                    if($diff>=21)
                    {
                        $_SESSION["ID_Num"]=$ID_Num;
                        $_SESSION["Surname"]=$database_Surname;
                        $_SESSION["Initials"]=$database_Initials;
                        $_SESSION["Database_Password"]=$database_Password;
                        $_SESSION["Database_Father"]=$database_Fathers_ID;
                        $_SESSION["Database_Mother"]=$database_Mothers_ID;
                        header("Location: /Medical_Database/patient.php");
                        die();
                    }
                    else
                    {
                        echo '<script> alert("You can only access your own site if you are 21 years of age or older. Please ask your mother or father to see your information.")</script>';
                    }
                    
                }
                else
                {
                    echo '<script> alert("Username or password does not match our database or you do not have an account.")</script>';
                }
            }
            else
            {
                //echo $conn->error;
            }
    }
    if(isset($_POST["Pathology_login"]))
    {
        $ID_Num=$_POST["pathologist_username"];
        $Pathologist_Num=$_POST["pathologist_num"];
        $Login_Password=trim($_POST["pathologist_password"]);
        $sql = "SELECT Pat_Number,Password FROM Pathology WHERE ID_Number=$ID_Num"; 

            if($result = $conn->query($sql))
            {
                $row = $result->fetch_array();
                $database_Password=$row['Password'];
                $database_Pathologist_Num=$row['Pat_Number'];
                if($database_Pathologist_Num==$Pathologist_Num)
                {
                    if($database_Password == $Login_Password)
                    {
                        $_SESSION["ID_Num"]=$ID_Num;
                        $_SESSION["Database_Password"]=$database_Password;
                        $_SESSION["Medical_Num"]=$database_Pathologist_Num;
                        header("Location: /Medical_Database/pat.php");
                        die();
                    }
                    else
                    {
                        echo '<script> alert("Username or password does not match our database.")</script>';
                    }
                }
                else
                {
                    echo '<script> alert("This pathology number is not a registered number.")</script>';
                }
                
            }
            else
            {
                echo $conn->error;
            }
    }
    if(isset($_POST["Medical_login"]))
    {
        $ID_Num=$_POST["practitioner_username"];
        $Medical_Num=$_POST["practitioner_num"];
        $Login_Password=trim($_POST["practitioner_password"]);
        $sql = "SELECT Med_Num,Medical_Password FROM MedicalPractitioner WHERE ID=$ID_Num"; 

            if($result = $conn->query($sql))
            {
                $row = $result->fetch_array();
                $database_Password=$row['Medical_Password'];
                $database_Medical_Num=$row['Med_Num'];
                if($database_Medical_Num==$Medical_Num)
                {
                    if($database_Password == $Login_Password)
                    {
                        $_SESSION["ID_Num"]=$ID_Num;
                        $_SESSION["Database_Password"]=$database_Password;
                        $_SESSION["Medical_Num"]=$database_Medical_Num;
                        header("Location: /Medical_Database/Medical.php");
                        die();
                    }
                    else
                    {
                        echo '<script> alert("Username or password does not match our database.")</script>';
                    }
                }
                else
                {
                    echo '<script> alert("This medical number is not a registered number.")</script>';
                }
                
            }
            else
            {
                echo $conn->error;
            }
    }
    if(isset($_POST["Pharm_login"]))
    {
        //echo "mooi";
        $ID_Num=$_POST["pharm_username"];
        $Pharm_Num=$_POST["pharm_num"];
        $Login_Password=trim($_POST["pharm_password"]);
        $sql = "SELECT Pharm_Number,Password FROM Pharmacist WHERE ID_Number=$ID_Num"; 

            if($result = $conn->query($sql))
            {
                $row = $result->fetch_array();
                $database_Password=$row['Password'];
                $database_Pharm_Num=$row['Pharm_Number'];
                if($database_Pharm_Num==$Pharm_Num)
                {
                    if($database_Password == $Login_Password)
                    {
                        $_SESSION["ID_Num"]=$ID_Num;
                        $_SESSION["Database_Password"]=$database_Password;
                        $_SESSION["Medical_Num"]=$database_Pharm_Num;
                        header("Location: /Medical_Database/pharm.php");
                        die();
                    }
                    else
                    {
                        echo '<script> alert("Username or password does not match our database.")</script>';
                    }
                }
                else
                {
                    echo '<script> alert("This medical number is not a registered number.")</script>';
                }
                
            }
            else
            {
                echo $conn->error;
            }
    }
    if(isset($_POST['gov_login']))
    {
        if(($_POST["gov_username"]=="Goverment123")and($_POST["gov_password"]=="Password")) 
        {
            header("Location: /Medical_Database/gov.php");
            die();
        }
        else
        {
            echo '<script> alert("This is not a goverment username or password")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login page for the Medical database</title>
    <style>
        /* Set height of body and the document to 100% to enable "full page tabs" */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            background-color: #af7ac5;
            
        }
        
        /* Style tab links */
        .tablink {
            background-color: #af7ac5;
            color: white;
            float: left;
            border: none;
            border-right: 1px solid black;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            width: 20%;
        }
        
        .tablink:hover {
            background-color: #777;
        }
        
        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: white;
            display: none;
            padding: 100px 20px;
            height: 100%;
        }
        /* Style the login page */
        .login
        {
            width: auto;
            background-color: #eee;
            padding: 20px 30px 30px 30px;
            box-shadow: 2px 2px 5px #333;
            background-image: url("/home/ubuntu/Documents/REII414/Prakties/13971.jpg");
        }
        /* Style the inputs */
        .inp
        {
            width: 30%;
            padding: 12px;
            margin-bottom: 15px;
            display: block;
            margin: 0 auto;
            font-size: 20px;
            border: 1px solid #888;
            border-bottom: 5px solid #888;
            border-radius: 12px;
            align-content: center;
            background-color: #fff;
            color: #666;
        }
        .inp:focus
        {
            outline: none;
            border: 2px #555;
            border-bottom: 5px solid #555;
        }
        #main
        {
            width: 100%;
            margin: 50px auto;
        }
        #sub-btn
        {
            width: 34%;
            padding: 12px;
            display: block;
            margin: 0 auto;
            font-size: 20px;
            font-weight: normal;
            margin-bottom: 15px;
            background-color: #286090;
            color: #fff;
            cursor: pointer;
            border-bottom: 5px solid;
            border-radius: 12px;
            border-color: #122b40;
        }
        #sub-btn:focus,#res-btn:focus
        {
            outline: none;   
        }
        #sub-btn:active,#res-btn:active
        {
            border: none;
            margin-top: 5px;
        }
        #res-btn
        {
            width: 34%;
            padding: 12px;
            display: block;
            margin: 0 auto;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: normal;
            cursor: pointer;
            border-bottom: 5px solid;
            border-radius: 12px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }
        #forgot
        {
            font-size: 20px;
            color: #444;
            display: block;
            text-align: center;
        }
        h3
        {
            text-align: center;
            padding-bottom: 15px;
            color: #333;
            font-size: 30px;
            font-variant: small-caps;
        }
        h2
        {
            text-align: center;
            padding-bottom: 15px;
            color: #333;
            font-size: 30px;
            font-variant: small-caps;
        }
        h1
        {
            text-align: center;
            padding-bottom: 15px;
            color: #333;
            font-size: 30px;
            font-variant: small-caps;
        }
        #Patient {background-color: red;}
        #Medical {background-color: blue;}
        #Pathology {background-color: purple;}
        #Pharmacist {background-color: orange;}
        #Gov {background-color: #00FF77;}
    </style>
</head>
<body>
    
    <div id="main">
        <h2>Please login per your occupation</h2>
        <button class="tablink" onclick="openPage('Patient', this, 'red')" id="defaultOpen">Patient</button>
        <button class="tablink" onclick="openPage('Medical', this, 'blue')" >Medical Practitioner</button>
        <button class="tablink" onclick="openPage('Pathology', this, 'purple')">Pathology lab worker</button>
        <button class="tablink" onclick="openPage('Pharmacist', this, 'orange')">Pharmacist</button>
        <button class="tablink" onclick="openPage('Gov', this, '#00FF77')">Goverment</button>
        
        <div id="Patient" class="tabcontent">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p id="pagename" style="display: none">Patient</p>
                <h3>You are logging in as a Patient</h3>
                <input type="text" name="patient_username" placeholder="ID number(13-Digits)" class="inp" pattern="[0-9]{13}" required autofocus><br>
                <input type="password" name="patient_password" placeholder="Password" class="inp" required><br>
                <input type="submit" name="Patient_Submit" value="SIGN IN" id="sub-btn">
                <input type="reset" name="submit" value="RESET" id="res-btn">
            </form>
        </div>
        
        <div id="Medical" class="tabcontent">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3>You are logging in as a Medical Practitioner</h3>
                <input type="text" name="practitioner_username" placeholder="ID number(13-Digits)" class="inp" pattern="[0-9]{13}" required autofocus><br>
                <input type="text" name="practitioner_num" placeholder="Practioner number(12-Digits)" class="inp" pattern="[0-9]{12}" required autofocus><br>
                <input type="password" name="practitioner_password" placeholder="Practitioner Password" class="inp" required autofocus><br>
                <input type="submit" name="Medical_login" value="SIGN IN" id="sub-btn">
                <input type="reset" name="submit" value="RESET" id="res-btn">
            </form>
        </div>
        
        <div id="Pathology" class="tabcontent">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3>You are logging in as a Pathology Lab Worker</h3>
                <input type="text" name="pathologist_username" placeholder="ID number(13-Digits)" class="inp" pattern="[0-9]{13}" required autofocus><br>
                <input type="text" name="pathologist_num" placeholder="Pathologist number(8-Digits)" class="inp" pattern="[0-9]{8}" required autofocus><br>
                <input type="password" name="pathologist_password" placeholder="Pathology Password" class="inp" required autofocus><br>
                <input type="submit" name="Pathology_login" value="SIGN IN" id="sub-btn">
                <input type="reset" name="submit" value="RESET" id="res-btn">
            </form>
        </div>
        
        <div id="Pharmacist" class="tabcontent">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3>You are logging in as a Pharmacist</h3>
                <input type="text" name="pharm_username" placeholder="ID number(13-Digits)" class="inp" pattern="[0-9]{13}" required autofocus><br>
                <input type="text" name="pharm_num" placeholder="Pharmacist number(10-Digits)" class="inp" pattern="[0-9]{10}" required autofocus><br>
                <input type="password" name="pharm_password" placeholder="Pharmacist Password" class="inp" required autofocus><br>
                <input type="submit" name="Pharm_login" value="SIGN IN" id="sub-btn">
                <input type="reset" name="submit" value="RESET" id="res-btn">
            </form>
        </div> 
        <div id="Gov" class="tabcontent">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3>You are logging in as the Goverment</h3>
                <input type="text" name="gov_username" placeholder="Goverment login username" class="inp" required autofocus><br>
                <input type="password" name="gov_password" placeholder="Password" class="inp" required autofocus><br>
                <input type="submit" name="gov_login" value="SIGN IN" id="sub-btn">
                <input type="reset" name="submit" value="RESET" id="res-btn">
            </form>
        </div> 
    </div>
</body>
</html>
<script>
    function openPage(pageName, elmnt, color) 
    {
        // Hide all elements with class="tabcontent" by default */
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
      
        // Remove the background color of all tablinks/buttons
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].style.backgroundColor = "";
        }
      
        // Show the specific tab content
        document.getElementById(pageName).style.display = "block";
      
        // Add the specific color to the button used to open the tab content
        elmnt.style.backgroundColor = color;
    }
      
      // Get the element with id="defaultOpen" and click on it
      document.getElementById("defaultOpen").click(); 
</script>
