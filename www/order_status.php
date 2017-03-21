<!Doctype html>
<html lang="en">
<head>
    <?php include("head.html"); ?>
    
    <title>Order Status</title>
    
</head>
    
    <body style="background-color:">
                    
                <nav class="navbar navbar-toggleable-md navbar-dark bg-primary" data-spy="affix" data-offset-top="30" style="z-index:2">
                    <div class="container">
                      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav1">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <a class="navbar-brand" href="#">
                        <strong>EasyBuild</strong>
                      </a>
                      <div class="collapse navbar-collapse" id="navbarNav1">
                        <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                            <a class="nav-link" href="main_menu.html"><i class="fa fa-home fa-fw"></i> Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Dashboard</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link">Account</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="index.php">Login/Register</a>
                          </li>
                        </ul>
                        <form class="form-inline waves-effect waves-light">
                          <input class="form-control" type="text" placeholder="Search">
                        </form>
                      </div>
                    </div>
                  </nav>
        
                <div class="container body">
            <div class="row">
                <div class="header col-lg-12 col-md-12 col-sm-12 col-xs-12" data-spy="affix" data-offset-top="80" style="z-index:1">
                      
                    <!--<a href="main_menu.html"><span class="glyphicon glyphicon-arrow-left header_button col-lg-1 col-md-1 col-sm-1 col-xs-1" style="font-size:3em;" aria-hidden="true"></span></a>
                    
                    <a href="main_menu.html"><div class="menu_label col-lg-2 col-md-2 col-sm-2 col-xs-2">Main Menu</div></a>
                    -->
                    
                    <label class="header_label col-lg-7 col-md-6 col-sm-6 col-xs-8 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-1">Order Status</label>
                    
                    <a href=""><span class="glyphicon glyphicon-plus header_button col-lg-1 col-md-1 col-sm-1 col-xs-1" style="font-size:3em;" aria-hidden="true"></span></a>
                </div>
                
                <div class="search_background col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-xs-4 col-xs-offset-5">
                    <form action="" class="search-form">
                        <div class="form-group has-feedback">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" class="form-control" name="search" id="search" placeholder="">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </form>
                </div>
                </div>
                
                <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
                      
                   </thead>
                    <tbody>

                        <tr>
                            <th>Order Date</th>
                            <th>Order Number</th>   
                            <th>Status</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>April 2, 2012</td>
                            <td>5343265</td>
                            <td><a href="http://www.google.com">Complete</a></td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>April 2, 2012</td>
                            <td>5343265</td>
                            <td><a href="http://www.google.com">Pending</a></td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>April 2, 2012</td>
                            <td>5343265</td>
                            <td><a href="http://www.google.com">Cancelled</a></td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>April 2, 2012</td>
                            <td>5343265</td>
                            <td><a href="http://www.google.com">Complete</a></td>
                            <td>View Details</td>
                        </tr>
                    </tbody>
                    </table>
                     </div>
                    
                        
                        
        <?php include("scripts.html"); ?>
    <script type="text/javascript">
    $(function () {
      $('#login-form-link').click(function (e) {
        $("#login-form").fadeIn(300);
        $("#register-form").fadeOut(300);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        $('#login-form').addClass('active');
        $('#register-form').removeClass('active');
        e.preventDefault();
      });
      $('#register-form-link').click(function (e) {
        $("#register-form").fadeIn(300);
        $("#login-form").fadeOut(300);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        $('#register-form').addClass('active');
        $('#login-form').removeClass('active');
        e.preventDefault();
      });
    });
    </script>
                        
    </body>
    
</html>