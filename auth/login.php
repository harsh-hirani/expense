<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body{
    background-color: #cdc9c9;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    margin:150px auto;
   
        background:linear-gradient(45deg,cyan 50% ,#3381f7 50%);
        background-size: cover;
        height: 100%;
        width: 100%;
   
    
}


.container{
    height: 470px ;
    width: 450px;
    background-color: #f9fdff;
    border: 1px solid rgb(167, 162, 162);
    border-radius: 20px;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12)
     0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17)
      0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}

.content{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }

.header_signup{
    height: 200px;
    color: rgb(0, 0, 0);
    font-size:18px ;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    
}
#Email{
    margin-top: -30px;
}
.signup_form{
    margin-bottom: 5px;
    padding-left: 10px;
    width: 300px;
    height: 45px;
    padding-left: 20px;
    border: 1px solid rgb(182, 178, 178);
    background-color: #ffffff;
    border-radius: 10px;
    color: #1f1d1d;
}

#login_submit{
    width: 225px;
    height: 35px;
    color: white;
    background-color:rgb(30, 91, 213);
    border: 1px solid rgb(177, 171, 171);
    border-radius: 10px;
}
#login_submit:hover{
    background-color: #5782ad;
}

form{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#jump_auth:hover{
    color: rgb(0, 0, 0);
}

    </style>
</head>
<body>
    <div class="bg-img"></div>
    <div class="container">
        <div class="content">
            <div class="header_signup">
                <h2> Welcome Back!</h2>
                <h4>Enter your login details!</h4>
            </div>
         
            <br>
         
            <form method="post" action="./loginreq.php">
                    <input type="email" class="signup_form" name="email" id="Email" placeholder="Email*" required>
                    <br>
                    <input type="password" class="signup_form" name="pass" id="password" placeholder="PassWord*" required>
                    <br>
                    <button id="login_submit" type="submit">Login</button>
                </form>
    
            <br>
            <a href="./signup.php" id="jump_auth">Don't have an account?</a>
    
        </div>

    </div>
</body>
</html>