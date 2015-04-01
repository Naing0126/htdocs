 <html>
 <head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <!-- Bootstrap Core CSS -->
   <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="/assets/css/sensor.css" rel="stylesheet">

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
   <button class="btn add-sensor-btn btn-default btn-md" data-toggle="modal" data-target="#addSensorModal">
    <span class="glyphicon glyphicon-plus"> Add Sensor</span>
    </button>
</span>
 <span class="add-sensor-bundle">
     <!-- Button trigger modal -->
     <button class="btn add-sensor-btn btn-default btn-md" data-toggle="modal" data-target="#addNodeModal">
      <span class="glyphicon glyphicon-plus"> Add Node</span>
    </button>
  </span>


</header><!-- /header -->
</div><!-- /header -->

<!-- Sensor Modal -->
<div class="modal fade" id="addNodeModal" tabindex="-1" role="dialog" aria-labelledby="addNodeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Node</h4>
      </div>
      <div class="modal-body">
        <div>
          새로 추가할 Node의 id를 입력하세요
          <br>
           <input type="text" id="new_nid" name="new_nid" value="" placeholder="Enter new node id">
       </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
      <input type="button" class="btn btn-primary" data-dismiss="modal" value=" Add " name="submit" onclick="connectNode(<?=$uid?>)"/>
    </div>
  </div><!-- /modal-content -->
</div><!-- /modal-dialog -->
</div><!-- /modal -->

<!-- Sensor Modal -->
<div class="modal fade" id="addSensorModal" tabindex="-1" role="dialog" aria-labelledby="addSensorModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add sensor</h4>
      </div>
      <div class="modal-body">
        <div id="select_node">
          Sensor를 추가할 Node를 선택하세요.
          <br>
          <?php $nodes['#'] = 'Select node'; ?>
          <div><?php
           echo form_dropdown('node_id', $nodes, '#', 'id="node" ');
           ?>
         </div>
       </div>
       <div id="select_sensor">
         Sensor의 정보를 입력하세요.
         <br>
         <div>
          <?php
          $type_arr = array('#'=>'Select type', 'temperature' =>'temperature' ,'humidity' =>'humidity','co2' => 'co2', 'door' => 'door', 'airCleaner' => 'airCleaner', 'warningLight' => 'warningLight' );
          echo form_dropdown('type', $type_arr, '#', 'id="type"');
          ?>
          <input type="text" id="new_sid" name="new_sid" value="" placeholder="Enter new sensor id">
           <input type="text" id="new_sname" name="new_sname" value="" placeholder="Enter new sensor name">

        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
      <input type="button" class="btn btn-primary" data-dismiss="modal" value=" Add " name="submit" onclick="addSensor()"/>
    </div>
  </div><!-- /modal-content -->
</div><!-- /modal-dialog -->
</div><!-- /modal -->
<body>

  <div id="sensors_container" align="center">
    <div id="list">
      <ul class="nodes_list">
        <?php
        foreach($nodes as $entry){
         if($entry == 'Select node') continue;
         ?>
         <li><h4><?=$entry?> <button type="button" class="btn btn-default btn-xs btn-sensor-control" onclick="disconnectNode(<?=$uid?>,'<?=$entry?>')">
          <span class="glyphicon glyphicon-minus-sign"></span>
        </button></h4>
        <ul class="sensors_list">
         <?php

         if($sensor_list[$entry]['type'][0]!='null'){
          $i = 0;
          for($i = 0;$i<count($sensor_list[$entry]['type']);$i++){
            $type = $sensor_list[$entry]['type'][$i];
            $sid = $sensor_list[$entry]['sid'][$i];
            $sname = $sensor_list[$entry]['sname'][$i];
            ?>
            <li><h5><?=$sid?>, <?=$type?>, <?=$sname?></h5></li>
            <?php
          }}
          ?>
        </ul>
      </li>
      <?php
    }
    ?>
  </ul>
</div>
</div>

</body>

<script type="text/javascript">

  $(document).ready(function(){

    $('#select_sensor').hide();

    $('#node').change(function(){
          var node = $('#node').val();  // here we are taking country id of the selected one.
          if(node=='#'){
            $('#select_sensor').hide();
          }else{
            $('#select_sensor').show();
          }

        });

  });

// add Node
function connectNode(uid){
  var info = { 'uid' : uid,
  'nid' : $('#new_nid').val()
};

$.ajax({
  type: "POST",
                url: "<?php echo site_url('dashboard/add_node');?>/", //here we are calling our user controller and get_cities method with the country_id
                data: {"info" : JSON.stringify(info)},
                success: function(result) //we're calling the response json array 'included_sensors'
                {
                  if(result.cnt=='0'){
                    // add new node
                    alert('add new node');
                  }else if(result.cnt>'0'){
                    // connect exist node
                    alert('connect this user with exist node');
                  }
                   $url = "<?php echo site_url('dashboard/sensor_list');?>";
                    window.location.href = $url;
                }
              });
}
// add Sensor
function addSensor(){

  var info = { 'sensor_nid' : $('#node').val(),
  'sensor_id' : $('#new_sid').val(),
  'sensor_name' : $('#new_sname').val(),
  'sensor_type' : $('#type').val()
};

$.ajax({
  type: "POST",
                url: "<?php echo site_url('dashboard/add_sensor');?>/", //here we are calling our user controller and get_cities method with the country_id
                data: {"info" : JSON.stringify(info)},
                success: function(result) //we're calling the response json array 'included_sensors'
                {
                  if(result.cnt>0){
                    // already exist in the node
                    alert('already exist sensor!');
                  }else{
                    // connect exist node
                    alert('add sensor!');
                    $url = "<?php echo site_url('dashboard/sensor_list');?>";
                    window.location.href = $url;
                  }
                }
              });
}

// remove Node
function disconnectNode(uid, nid){

$.ajax({
  type: "POST",
                url: "<?php echo site_url('dashboard/disconnect_node');?>/"+uid+"/"+nid, //here we are calling our user controller and get_cities method with the country_id
                success: function(result) //we're calling the response json array 'included_sensors'
                {
                    alert('disconnect Node!');
                   $url = "<?php echo site_url('dashboard/sensor_list');?>";
                    window.location.href = $url;
                }
              });
}

</script>
