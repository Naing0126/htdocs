 <!DOCTYPE html>
 <html>
 <head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <!-- Bootstrap Core CSS -->
   <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

   <!-- Custom CSS -->
   <link href="/assets/css/dashboard.css" rel="stylesheet">
   <link href="/assets/css/horizontal.css" rel="stylesheet" >

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>

   <!-- Bootstrap Core JavaScript -->
   <script src="/assets/js/bootstrap.min.js"></script>

   <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
   <script src="http://darsa.in/sly/examples/js/vendor/plugins.js"></script>
   <script src="http://darsa.in/sly/js/sly.min.js"></script>
   <script src="/assets/js/horizontal.js"></script>
 </head>

 <header id="header" class="">

</header><!-- /header -->

<body>
  <div class="directory-list" align="center">
    <!-- sly slider -->
    <div class="pagespan container">
      <div class="wrap">

        <div class="frame" id="basic">
          <ul class="clearfix">
            <?php
            $cnt = 0;
            foreach($directories as $entry){
              $cnt++;
              ?>
              <li onclick="location.href='<?php echo base_url();?>index.php/dashboard/load_directory/<?=$entry->did?>'">
                <div class="directory-content">
                  <div class="directory-name">
                    <?=$entry->directory_name?>
                  </div>
                  <div class="sensor-min-list">
                    <table class="table table-bordered table-condensed">
                      <tr>
                        <td>test</td>
                        <td>test</td>
                      </tr>
                      <tr>
                        <td>test</td>
                        <td>test</td>
                      </tr>
                      <tr>
                        <td>test</td>
                        <td>test</td>
                      </tr>
                      <tr>
                        <td>test</td>
                        <td>test</td>
                      </tr>

                    </table>
                  </div>
                  <div class="directory-control">
                  <?php
             echo form_open('dashboard/delete_directory');
             ?>
                <input type="hidden" name="did" value="<?=$entry->did?>"/>
                 <input type="submit" class="btn btn-primary" value=" Delete " name="submit"/>
                   <?php echo form_close(); ?>
              </div><!-- directory-control-->
            </div><!-- directory-content-->
              </li>
          <?php
        }
        ?>
      </ul>
    </div>

    <ul class="pages"></ul>

    <div class="controls center">

      <div class="btn-group">
        <button class="btn btn-default btn-md" data-toggle="modal" data-target="#AddDirectoryModal"><i class="glyphicon glyphicon-plus"></i> Add Directory</button>
      </div>

      <span class="AddDirectoryModal">
        <!-- Add Directory Modal -->
        <div class="modal fade" id="AddDirectoryModal" tabindex="-1" role="dialog" aria-labelledby="AddDirectoryModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
             <?php
             echo form_open('dashboard/add_directory');
             ?>
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Create Directory</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
               <input type="text" class="form-control" placeholder="Directory name" name="directory_name" id="directory_name">
             </div>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
            <input type="submit" class="btn btn-primary" value=" Create " name="submit"/>
          </div>
          <?php echo form_close(); ?>
        </div><!--/Modal content-->
      </div>
    </div><!--/Modal-->
  </span>

</div>

</div><!-- /wrap -->
</div><!-- /sly -->
</div><!--directory-list-->



</body>

