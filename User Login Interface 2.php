This is login form: USER PERSONAL HOME PAGE

        <!DOCTYPE HTML>
    <html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <header>
            <nav>
                <div class="main-wrapper">
                    <ul><li><a class="llink" href="home.php">Home</a></li></ul>
                    <div class="nav-login">
                        <form action="" method="POST">
                            <input type="text" name="u_uid" placeholder="Username" />
                            <input type="password" name="u_pwd" placeholder="Password" />
                            <button type="submit" name="submit">Login</button>
                        </form>
                        <a href="signup.php">Sign up</a>
                    </div>
                </div>
            </nav>
        </header>

    <?php
    ob_start();
    include 'phpcode/dbh.php';
    if(isset($_POST['submit'])){
        $db=mysqli_select_db($conn,'loginsystem');
        if(!$db){
            echo "DB  not found <br />".mysqli_error($conn); 
        }

        $id=mysqli_real_escape_string($conn,$_POST['u_uid']);
        $pwd=mysqli_real_escape_string($conn,$_POST['u_pwd']);
        if(!$id==0 || !$pwd==0){
            $sql = "SELECT * FROM users WHERE u_uid='$id'";
            $res = mysqli_query($conn,$sql);
            $rescheck = mysqli_num_rows($res);
            if($rescheck<1){
                echo "<span class='error'>User-name and Password doesn't match</span><br />";
            }else{
                while($row=mysqli_fetch_assoc($res)){
                    $dbid=$row['u_uid'];
                    $dbpwd=$row['u_pwd'];
                }
                if($id == $dbid && $pwd == $dbpwd){
                    session_start();
                        $_SESSION['user_id'] = $row['u_id'];
                        $_SESSION['user_fname'] = $row['u_fname'];
                        $_SESSION['user_lname'] = $row['u_lname'];
                        $_SESSION['user_email'] = $row['u_email'];
                        $_SESSION['user_uid'] = $row['u_uid'];
                        echo "<div class='err-nav'><script type='text/javascript'>window.location.href = 'action.php';</script></div>";
                        exit();
                }else{
                    echo "<div class='err-nav'><span class='error'>Password doesn't matched</span><br /></div>";

                    }
            }

        }else{
            echo "<div class='err-nav'><span class='error'>Cannot be empty</span><br /></div>";

        }
    }
    ?>