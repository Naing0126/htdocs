 <html>
 <head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <!-- Bootstrap Core CSS -->
   <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="/assets/css/trigger.css" rel="stylesheet">

   <!-- jQuery -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
   <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>

   <!-- Bootstrap Core JavaScript -->

 </head>

 <div id="sub-header" class="sub-header">
   <header id="header" class="">


    <script src="/assets/js/bootstrap.min.js" rel="stylesheet"></script>

    <span class="add-sensor-bundle">
     <!-- Button trigger modal -->
     <button class="btn add-sensor-btn btn-default btn-md" data-toggle="modal" data-target="#makeTriggerModel">
      <span class="glyphicon glyphicon-plus"> Trigger 추가</span>
    </button>

    <!-- Sensor Modal -->
    <div class="modal fade" id="makeTriggerModel" tabindex="-1" role="dialog" aria-labelledby="makeTriggerModelLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Make a Trigger</h4>
          </div>
          <div class="modal-body">
            Trigger 규칙을 설정해주세요.
            <br>
            <?php $included_sensors['#'] = 'Select Node first'; ?>
            <div id="condition">
             <label for="condition">Condition </label>
             <div><?php
               echo form_dropdown('node_id', $nodes, '#', 'id="node" ');
               echo form_dropdown('sensor_id', $included_sensors, '#', 'id="included_sensors" class=""');
               ?>
               <input type="text" id="condition_value" name="value" value="" placeholder="value">
               <?php
               $condition_op = array('#'=>'-', 'higher'=>'<', 'lower'=>'>');
               echo form_dropdown('condition_op', $condition_op, '#', 'id="condition_op" class=""');
               ?>
             </div>
           </div>
           <div id="action">
            <label for="sensor">Action </label>
            <div>
              <?php
              $type_arr = array('#'=>'Select type','push'=>'push','action'=>'action');
              echo form_dropdown('type', $type_arr, '#', 'id="type"');
              ?>
              <input type="text" id="message" name="message" value="">

              <?php
              $included_sensors['#'] = $action_types['#'] = 'Select Gateway first';
              echo form_dropdown('node_id', $nodes, '#', 'id="action_node"');
              echo form_dropdown('sensor_id', $included_sensors, '#', 'id="action_included_sensors" class=""');
              $action_op = array('off'=>'off','on'=>'on');
              echo form_dropdown('action_op', $action_op, '#', 'id="action_op" class=""');
              ?></div>
            </div>
            <input type="hidden" id="" name="did" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
            <input type="button" class="btn btn-primary" data-dismiss="modal" value=" 등록 " name="submit" onclick="addTrigger(<?=$uid?>)"/>
          </div>
        </div><!-- /modal-content -->
      </div><!-- /modal-dialog -->
    </div><!-- /modal -->

  </span>

</header><!-- /header -->
</div><!-- /header -->

<!-- Update Trigger Modal -->
<span class="UpdateTriggerModal">
  <div class="modal fade" id="UpdateTriggerModal" tabindex="-1" role="dialog" aria-labelledby="UpdateTriggerModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Trigger</h4>
      </div>

      <div class="modal-body">
        새로운 Trigger 규칙을 설정해주세요.
        <br>
        <div id="before">before : </div>
        <?php $included_sensors['#'] = 'Select Node first'; ?>
        <div id="condition">
         <label for="condition">Condition </label>
         <div><?php
           echo form_dropdown('node_id', $nodes, '#', 'id="new_node"');
           echo form_dropdown('sensor_id', $included_sensors, '#', 'id="new_included_sensors" class=""');
           ?>
           <input type="text" id="new_condition_value" name="value" value="" placeholder="value">
           <?php
           $condition_op = array('#'=>'-', 'higher'=>'<', 'lower'=>'>');
           echo form_dropdown('condition_op', $condition_op, '#', 'id="new_condition_op" class=""');
           ?>
         </div>
       </div>
       <div id="action">
        <label for="sensor">Action </label>
        <div>
          <?php
          $type_arr = array('#'=>'Select type','push'=>'push','action'=>'action');
          echo form_dropdown('type', $type_arr, '#', 'id="new_type"');
          ?>
          <input type="text" id="new_message" name="message" value="">

          <?php
          $included_sensors['#'] = $action_types['#'] = 'Select Node first';
          echo form_dropdown('node_id', $nodes, '#', 'id="new_action_node"');
          echo form_dropdown('sensor_id', $included_sensors, '#', 'id="new_action_included_sensors" class=""');
          $action_op = array('off'=>'off','on'=>'on');
          echo form_dropdown('action_op', $action_op, '#', 'id="new_action_op" class=""');
          ?></div>
        </div>
        <input type="hidden" id="tid" name="tid" value="">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeTrigger()"> Delete </button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateTrigger()"> Save </button>
      </div>
    </div><!--/Modal content-->
  </div>
</div><!--/Modal-->
</span>
<body>

  <div id="trigger_container" align="center">
    <?php
    foreach($triggers as $entry){
      if($entry->c_op==='0'){
        $c_op = '<';
      }else if($entry->c_op==='1'){
        $c_op = '>';
      }
      if($entry->action_type==='0'){
        $type = 'push';
      }else if($entry->action_type==='1'){
        $type = 'action';
      }

      $temp = '[before] sensor : '.$entry->c_sid . ', value : ' . $entry->c_value . ', op : ' . $c_op;
      if($entry->action_type==='0'){
        $contents = $temp . ' / message : ' . $entry->a_message;
      }else if($entry->action_type==='1'){
        $contents = $temp . 'sensor : ' . $entry->a_sid . ', op : ' . $entry->a_op;
      }

      ?>
      <button class="open-updateTriggerModal btn trigger btn-default btn-md"  data-tid="<?=$entry->tid?>" data-contents="<?=$contents?>"data-toggle="modal" data-target="#UpdateTriggerModal" id="trigger-<?=$entry->tid?>">
        <div class="" >
          <span class="condition">sensor : <?=$entry->c_sid?>, value : <?=$entry->c_value?>, op : <?=$c_op?></span>
          <span class="<?=$type?>-action">
            <?php
            if($entry->action_type=='0'){
              ?>
              message : ' <?=$entry->a_message?> '
              <?php
            }else if($entry->action_type=='1'){
              ?>
              sensor : <?=$entry->a_sid?>, op : <?=$entry->a_op?>
              <?php
            }
            ?>
          </span>
        </div><!-- trigger -->
      </button>
      <?php
    }
    ?>
  </div>

</body>

<script type="text/javascript">

  $(document).on("click",".open-updateTriggerModal",function(){
    var tid = $(this).data('tid');
    $("#tid").val(tid);
    var contents = $(this).data('contents');
    $("#before").text(contents);
  });


  $(document).ready(function(){

    $('#message, #action_node, #action_included_sensors, #action_op').hide();
   $('#type').change(function(){ //any select change on the dropdown with id country trigger this code
          var type = $('#type').val();  // here we are taking country id of the selected one.
          if(type==='action'){
            $('#action_node, #action_included_sensors, #action_op').show();
            $('#message').hide();
          }else if(type==='push'){
            $('#action_node, #action_included_sensors, #action_op').hide();
            $('#message').show();
          }else if(type==='#'){
            $('#action_node, #action_included_sensors, #action_op,#message').hide();
          }
        });

        $('#node').change(function(){ //any select change on the dropdown with id country trigger this code
        $("#included_sensors > option").remove(); //first of all clear select items
            var nid = $('#node').val();  // here we are taking country id of the selected one.

            $.ajax({
              type: "POST",
                url: "<?php echo site_url('dashboard/get_included_sensors');?>/"+nid, //here we are calling our user controller and get_cities method with the country_id

                success: function(included_sensors) //we're calling the response json array 'included_sensors'
                {
                    $.each(included_sensors,function(sensor_id,contents) //here we're doing a foeach loop round each sensor with id as the key and city as the value
                    {
                        var opt = $('<option />'); // here we're creating a new select option with for each city
                        opt.val(sensor_id);
                        opt.text(contents);
                        $('#included_sensors').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                      });
                  }

                });

          });



      $('#action_node').change(function(){ //any select change on the dropdown with id country trigger this code
        $("#action_included_sensors > option").remove(); //first of all clear select items
            var nid = $('#action_node').val();  // here we are taking country id of the selected one.

            $.ajax({
              type: "POST",
                url: "<?php echo site_url('dashboard/get_included_sensors');?>/"+nid, //here we are calling our user controller and get_cities method with the country_id

                success: function(included_sensors) //we're calling the response json array 'included_sensors'
                {
                    $.each(included_sensors,function(sensor_id,contents) //here we're doing a foeach loop round each sensor with id as the key and city as the value
                    {
                        var opt = $('<option />'); // here we're creating a new select option with for each city
                        opt.val(sensor_id);
                        opt.text(contents);
                        $('#action_included_sensors').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                      });
                  }

                });

          });

 $('#new_message, #new_action_node, #new_action_included_sensors, #new_action_op').hide();
 $('#new_type').change(function(){ //any select change on the dropdown with id country trigger this code
          var type = $('#new_type').val();  // here we are taking country id of the selected one.
          if(type==='action'){
            $('#new_action_node, #new_action_included_sensors, #new_action_op').show();
            $('#new_message').hide();
          }else if(type==='push'){
            $('#new_action_node, #new_action_included_sensors, #new_action_op').hide();
            $('#new_message').show();
          }else if(type==='#'){
            $('#new_action_node, #new_action_included_sensors, #new_action_op,#new_message').hide();
          }
        });

      $('#new_node').change(function(){ //any select change on the dropdown with id country trigger this code
        $("#new_included_sensors > option").remove(); //first of all clear select items
            var nid = $('#new_node').val();  // here we are taking country id of the selected one.

            $.ajax({
              type: "POST",
                url: "<?php echo site_url('dashboard/get_included_sensors');?>/"+nid, //here we are calling our user controller and get_cities method with the country_id

                success: function(included_sensors) //we're calling the response json array 'included_sensors'
                {
                    $.each(included_sensors,function(sensor_id,contents) //here we're doing a foeach loop round each sensor with id as the key and city as the value
                    {
                        var opt = $('<option />'); // here we're creating a new select option with for each city
                        opt.val(sensor_id);
                        opt.text(contents);
                        $('#new_included_sensors').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                      });
                  }

                });

          });



      $('#new_action_node').change(function(){ //any select change on the dropdown with id country trigger this code
        $("#new_action_included_sensors > option").remove(); //first of all clear select items
            var nid = $('#new_action_node').val();  // here we are taking country id of the selected one.

            $.ajax({
              type: "POST",
                url: "<?php echo site_url('dashboard/get_included_sensors');?>/"+nid, //here we are calling our user controller and get_cities method with the country_id

                success: function(included_sensors) //we're calling the response json array 'included_sensors'
                {
                    $.each(included_sensors,function(sensor_id,contents) //here we're doing a foeach loop round each sensor with id as the key and city as the value
                    {
                        var opt = $('<option />'); // here we're creating a new select option with for each city
                        opt.val(sensor_id);
                        opt.text(contents);
                        $('#new_action_included_sensors').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                      });
                  }

                });

          });
});

// add Trigger
function addTrigger(uid){
  var info = { 'uid' : uid,
  'c_nid' : $('#node').val(),
  'c_sid' : $('#included_sensors').val(),
  'c_value' : $('#condition_value').val(),
  'c_op' : $('#condition_op').val(),
  'action_type' : $('#type').val(),
  'a_message' : null ,
  'a_nid' : null,
  'a_sid' : null,
  'a_op' : null};

  if($('#condition_op').val() === 'higher'){
    info['c_op'] = 0;
  }else if($('#condition_op').val() === 'lower'){
   info['c_op'] = 1;
 }

 if($('#type').val() === 'push'){
  info['action_type'] = 0;
  info['a_message'] =  $('#message').val();
}else if($('#type').val() === 'action'){
 info['action_type'] = 1;
 info['a_nid'] = $('#action_node' ).val();
 info['a_sid'] = $('#action_included_sensors').val();
}

if($('#action_op').val() === 'on'){
  info['a_op'] = 1;
}else if($('#action_op').val() === 'off'){
 info['a_op'] = 0;
}

$.ajax({
  type: "POST",
                url: "<?php echo site_url('dashboard/add_trigger');?>/", //here we are calling our user controller and get_cities method with the country_id
                data: {"info" : JSON.stringify(info)},
                success: function(result) //we're calling the response json array 'included_sensors'
                {
                  $url = "<?php echo site_url('dashboard/trigger_list');?>";
                  window.location.href = $url;
                }
              });
}


function updateTrigger(){
  var tid = $('#tid').val();
  var info = {
    'c_nid' : $('#new_node').val(),
    'c_sid' : $('#new_included_sensors').val(),
    'c_value' : $('#new_condition_value').val(),
    'c_op' : $('#new_condition_op').val(),
    'action_type' : $('#new_type').val(),
    'a_message' : null ,
    'a_nid' : null,
    'a_sid' : null,
    'a_op' : null};

    if($('#new_condition_op').val() === 'higher'){
      info['c_op'] = 0;
    }else if($('#new_condition_op').val() === 'lower'){
     info['c_op'] = 1;
   }

   if($('#new_type').val() === 'push'){
    info['action_type'] = 0;
    info['a_message'] =  $('#new_message').val();
  }else if($('#new_type').val() === 'action'){
   info['action_type'] = 1;
   info['a_nid'] = $('#new_action_node' ).val();
   info['a_sid'] = $('#new_action_included_sensors').val();
 }

 if($('#new_action_op').val() === 'on'){
  info['a_op'] = 1;
}else if($('#new_action_op').val() === 'off'){
 info['a_op'] = 0;
}
$.ajax({
  type: "POST",
                url: "<?php echo site_url('dashboard/update_trigger');?>/"+tid, //here we are calling our user controller and get_cities method with the country_id
                data: {"info" : JSON.stringify(info)},
                success: function() //we're calling the response json array 'included_sensors'
                {
                 $url = "<?php echo site_url('dashboard/trigger_list');?>";
                 window.location.href = $url;
               }
             });
}

function removeTrigger(){
  var tid = $('#tid').val();
  $.ajax({
    type: "POST",
                url: "<?php echo site_url('dashboard/delete_trigger');?>/"+tid, //here we are calling our user controller and get_cities method with the country_id

                success: function() //we're calling the response json array 'included_sensors'
                {
                 $('#trigger-'+tid).remove();
               }
             });
}

</script>
