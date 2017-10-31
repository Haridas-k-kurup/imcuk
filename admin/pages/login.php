<!DOCTYPE html>
<html class="bg-white">
    <head>
        <meta charset="UTF-8">
        <title>I M C | International Medical Connection</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-white">

        <div class="form-box" id="login-box">
            <div class="header bg-light-blue">Sign In</div>
            <form action="<?php echo SITE_ROOT; ?>admin/action.php?act=login" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="admin_username" class="form-control" required placeholder="User Name"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="admin_password" class="form-control" required placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer bg-gray">                                                               
                    <button type="submit" class="btn bg-light-blue btn-block">Sign me in</button>  
                </div>
            </form>

            <div class="margin text-center">
                <span>Welcome to I M C  Administrator </span>
            </div>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>