<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            background-color: #cbc6c6;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin: 150px auto;
            background: linear-gradient(45deg, cyan 50%, #3381f7 50%);
            background-size: cover;
            height: 100%;
            width: 100%;


        }

        .container {
            height: 470px;
            width: 450px;
            background-color: #f9fdff;
            border: 1px solid rgb(142, 135, 135);
            border-radius: 20px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header_signup {
            height: 100px;
            color: rgb(0, 0, 0);
            font-size: 18px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

        }

        .signup_form {
            margin-bottom: 5px;
            padding: 5px;
            width: 300px;
            height: 26px;
            padding-left: 20px;

            border: 1px solid rgb(180, 174, 174);
            background-color: #ffffff;
            border-radius: 10px;
            color: #1f1d1d;
        }

        #signup_submit {
            width: 225px;
            height: 35px;
            color: white;
            background-color: rgb(30, 91, 213);
            border: 1px solid rgb(177, 171, 171);
            border-radius: 10px;

        }

        #signup_submit:hover {
            background-color: #5782ad;
        }

        #check_password {
            font-size: 10px;
            color: black;

        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        #jump_auth:hover {
            color: rgb(0, 0, 0);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="header_signup">
                <h3>Welcome To Expense Controller </h3>

            </div>
            <br>
            <form method="post" action="./signupreq.php" onsubmit="return validate_password();">
                <input type="text" class="signup_form" name="name" id="username" placeholder="User Name*" required>
                <br>
                <input type="email" class="signup_form" name="email" id="Email" placeholder="Email*" required>
                <br>
                <input type="password" class="signup_form" name="pass" id="password" placeholder="PassWord*" required>
                <br>
                <input type="password" class="signup_form" name="confirm_password" id="conf_password" placeholder="Confirm Password*" required>
                <br>
                <button id="signup_submit" type="submit">Sign Up</button>
            </form>

            <h3 id="check_password" type="button"></h3>
            <a href="./login.php" id="jump_auth">already register?</a>

        </div>

    </div>
    <script>
        var username = document.getElementById("username")
        var email = document.getElementById("Email")
        var password = document.getElementById("password")
        var confirm_password = document.getElementById("conf_password")
        var error_msg = document.getElementById("check_password")


        function validate_password() {
            let val1 = password.value;
            let val2 = confirm_password.value;

            if (val1 !== val2) {
                alert("Password and Confirm Password must be same!")
                return false;
            } else if (password.value != "" && confirm_password.value != "") {
                return true;
            }
        }

        
    </script>
</body>

</html>