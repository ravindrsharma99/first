

  <body class="">
<div class="loginbg">
    <div class="container">
<!--     <h1 class="text-center mT100 white">Welcome to KudosMove Dashboard</h1> -->


      <form class="form-signin" action="Login" method="POST">
      <div class="text-center "><img src="<?php echo base_url(); ?>/Public/img/logo.png" width="150px" height = "auto"/>  </div>
        
        <h2 class="form-signin-heading tsd">Sign In now</h2>
        <div class="login-wrap">
            <input name="email" type="email" class="form-control" placeholder="Email" autofocus required="">
            <input name="password" type="password" class="form-control" placeholder="Password" required="">
<!--             <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label> -->
            <button name="login" class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
 <!--            <p>or you can sign in via social network</p>
            <div class="login-social-link">
                <a href="index.html" class="facebook">
                    <i class="fa fa-facebook"></i>
                    Facebook
                </a>
                <a href="index.html" class="twitter">
                    <i class="fa fa-twitter"></i>
                    Twitter
                </a>
            </div>
            <div class="registration">
                Don't have an account yet?
                <a class="" href="registration.html">
                    Create an account
                </a>
            </div>

        </div> -->

          <!-- Modal -->
<!--           <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="button">Submit</button>
                      </div>
                  </div>
              </div>
          </div> -->
          <!-- modal -->

      </form>

    </div>
    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>/Public/js/jquery.js"></script>
    <script src="<?php echo base_url();?>/Public/js/bootstrap.min.js"></script>


  </body>
</html>
