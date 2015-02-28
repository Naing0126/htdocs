<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Naing</title>

    <!-- Bootstrap Core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/assets/css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Chewy' rel='stylesheet' type='text/css'>



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body id="page-top" class="index">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top">JNThings</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#about">About</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <!-- Header -->
        <header>
            <div class="container">
                <div class="intro-text">
                    <div class="intro-lead-in">Welcome To Our Service!</div>

                    <div class="row">
                        <div class="col-lg-8 col-md-offset-2 col-md-8 col-sm-4 col-sm-offset-4">

                            <div class="row">
                              <?php echo form_open('main/user_login_process'); ?>
                              <?
                              echo "<div class='error_msg'>";
                              if (isset($error_message)) {
                                echo $error_message;
                            }
                            echo validation_errors();
                            echo "</div>";
                            ?>

                            <?php
                            if (isset($message_display)) {
                                echo "<div class='message'>";
                                echo $message_display;
                                echo "</div>";
                            }
                            ?>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="userid" id="userid" placeholder="User id ">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password ">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <input type="submit" class="btn btn-xl" value=" Login " name="submit"/>
                                <button class="btn btn-xl" data-toggle="modal" data-target="#JoinModal">Join</button>
                            </div>

                            <?php echo form_close(); ?>
                            <!-- Join Modal -->
                            <span class="JoinModal">
                                <div class="modal fade" id="JoinModal" tabindex="-1" role="dialog" aria-labelledby="JoinModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                         <?php
                                         echo form_open('main/new_user_registration');
                                         ?>
                                         <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
                                      </div>
                                      <div class="modal-body">
                                        <div class="form-group">
                                           <input type="text" class="form-control" placeholder="User id" name="userid" id="userid">
                                       </div>
                                       <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="User name" name="username" id="username">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                                  <input type="submit" class="btn btn-primary" value=" Sign Up " name="submit"/>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                      </div>
                  </div><!-- /modal -->
              </span>


          </div>
      </div>
      <?php echo form_close(); ?>

  </div>
</div>

</div>
</div>
</header>
