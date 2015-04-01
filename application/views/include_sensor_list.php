 <html>
 <head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">

   <!-- Bootstrap Core CSS -->
   <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

   <link href="/assets/css/gridstack.css" rel="stylesheet">
   <link href="/assets/css/dashboard.css" rel="stylesheet">

   <!-- jQuery -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
   <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>

   <!-- Bootstrap Core JavaScript -->

   <script src="/assets/js/gridstack.js"></script>


 </head>

 <div id="sub-header" class="sub-header">
   <header id="header" class="">
    <span class="explorer">
      <ol class="breadcrumb">
        <li><img class="directory_img" src="/assets/img/dash_directory.png" align="center"><a href="<?php echo site_url('dashboard/directory_list');?>" target="board">Home</a></li>
        <li><?=$directory_name?> <button class="open-updateDirectoryModal btn btn-default btn-md" data-did=<?=$did?> data-dname="<?=$directory_name?>" data-toggle="modal" data-target="#UpdateDirectoryModal">
          <span class="glyphicon glyphicon-pencil">edit</span>
        </button>
      </li>
    </ol>
  </span>

  <script>
    $(document).on("click",".open-updateDirectoryModal",function(){
      var before = $(this).data('dname');
      $(".modal-body #directory_name").val(before);
      var did = $(this).data('did');
      $(".modal-body #did").val(did)
    });
  </script>

  <span class="UpdateDirectoryModal">
    <!-- Add Directory Modal -->
    <div class="modal fade" id="UpdateDirectoryModal" tabindex="-1" role="dialog" aria-labelledby="UpdateDirectoryModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
         <?php
         echo form_open('dashboard/update_directory');
         ?>
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Update Directory</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
           <input type="text" class="form-control" placeholder="Directory name" name="directory_name" id="directory_name">
           <input type="hidden" class="form-control" name="did" id="did">
         </div>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        <input type="submit" class="btn btn-primary" value=" Save " name="submit"/>
      </div>
      <?php echo form_close(); ?>
    </div><!--/Modal content-->
  </div>
</div><!--/Modal-->
</span>

<script src="/assets/js/bootstrap.min.js" rel="stylesheet"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js"></script>
<script src="/assets/js/angular_core.js"></script>

<span class="add-sensor-bundle">
 <!-- Button trigger modal -->
 <button class="btn add-sensor-btn btn-default btn-md" data-toggle="modal" data-target="#selectSensorModal">
  <span class="glyphicon glyphicon-plus"> 센서 추가</span>
</button>

<!-- Sensor Modal -->
<div class="modal fade" id="selectSensorModal" tabindex="-1" role="dialog" aria-labelledby="selectSensorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Directory에 추가할 Sensor 선택</h4>
      </div>
      <div class="modal-body">
        Directory에 추가하고자 하는 Sensor를 선택하세요
        <br>
        <?php
        if(count($nodes)>0){
          ?>
        <?php $included_sensors['#'] = 'Select Sensor Node first'; ?>
        <label for="node">Node: </label><?php echo form_dropdown('node_id', $nodes, '#', 'id="node" class="form-control"'); ?>
        <label for="sensor">Sensor: </label><?php echo form_dropdown('sensor_id', $included_sensors, '#', 'id="included_sensors" class="form-control"'); ?>
        <input type="hidden" id="did" name="did" value="<?=$did?>">
      <?php
    }else{
      echo "Register Node first";
    }
      ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        <input type="button" class="btn btn-primary" data-dismiss="modal" value=" Select " name="submit" onclick="addWidget(<?=$did?>)"/>
      </div>
    </div><!-- /modal-content -->
  </div><!-- /modal-dialog -->
</div><!-- /modal -->

</span>

</header><!-- /header -->
</div><!-- /header -->

<?php
$base_url = site_url('');
?>
<body ng-app='angular' ng-controller='directoryCtrl' ng-init="init('<?=$did?>','<?=$base_url?>')" >

  <!-- load included sensors in directory -->
  <div class="sensor-bundle-list" id="sensor-bundle-list" align="center">
      <?php
    $type_cnt = array('temperature' =>'0' ,'humidity' =>'0','co2' => '0', 'door' => '0', 'airCleaner' => '0', 'warningLight' => '0' );
    $type_names = array('0'=>'temperature', '1'=>'humidity', '2'=>'co2', '3'=>'door', '4' =>'airCleaner', '5' => 'warningLight');
    $groups = array
    (
      'temperature' => array(),
      'humidity' => array(),
      'co2' => array(),
      'door' => array(),
      'airCleaner' => array(),
      'warningLight' => array()
      );
    // grouping by each sensor type
    if(count($sensors)>0){
      foreach($sensors['sensor_id'] as $k=>$v){
        $type = $sensors['sensor_type'][$k];
        $groups[$type][$type_cnt[$type]]=$k;
        $type_cnt[$type] += 1;
      }
    }else{
      ?>
      <h1>Please Add Sensor :D</h1>

      <?php
    }

    for($i = 0; $i < count($groups);$i++){
      // create sensor-bundle
      $type_name = $type_names[$i];
      if($type_cnt[$type_name]<1)
        continue;
      ?>
      <div id="<?=$type_name?>-bundle" class="sensor-bundle col-md-3 col-sm-3" align="center">
        <div class="sensor-bundle-name" align="center">
          <?=$type_name?>
        </div>
        <div id="<?=$type_name?>-stack" class="grid-stack" data-gs-width="3">
         <?php
         for($j = 0;$j<count($groups[$type_name]);$j++){
           $nid = $sensors['sensor_nid'][$groups[$type_name][$j]];
           $sid = $sensors['sensor_id'][$groups[$type_name][$j]];
           $sname = $sensors['sensor_name'][$groups[$type_name][$j]];
           ?>
           <script>$('#<?=$type_name?>-bundle').css('height','+=130px');</script>

           <div id="<?=$sid?>" class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12" data-gs-height="1.5">
            <div class="grid-stack-item-content sensor " >
              <div class="sensor-name">
                <button type="button" class="btn btn-default btn-xs btn-sensor-control" onclick="removeWidget('<?=$type_name?>','<?=$did?>','<?=$sid?>','<?=$nid?>')">
                  <span class="glyphicon glyphicon-minus-sign"></span>
                </button>
                <div class="name">{{sensors.info.sensor_name[sensors.index['<?=$sid?>']['<?=$nid?>']]}} ({{sensors.info.sensor_id[sensors.index['<?=$sid?>']['<?=$nid?>']]}})</div>
              </div>
              <div class="sensor-content">
                <div class="value">
                  {{sensors.info.recent_data[sensors.index['<?=$sid?>']['<?=$nid?>']]}}
                  <?php
                  if($type_name=="temperature"){
                    ?>
                    º
                    <?php
                  }else if($type_name=="humidity"){
                    ?>
                    %
                    <?php
                  }else if($type_name=="co2"){
                    ?>
                    ppm
                    <?php
                  }
                  ?>
                </div>
                <div class="time">
                {{sensors.info.recent_data_time[sensors.index['<?=$sid?>']['<?=$nid?>']]}}
                </div>
              </div><!-- /sensor-content -->
            </div><!-- /sensor-item-content -->
          </div><!--/sensor-item-->
          <?php
        }?>
      </div><!--sensor-stack-->
    </div><!--sensor-bundle-->
    <?php
  }
  ?>
</div><!--sensor-bundle-list-->

<script type="text/javascript">

 $(document).ready(function(){
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
});

 $(function () {
  $('.grid-stack').gridstack({
    width: 12,
    cell_height: 120
  });

  var grid = $('.grid-stack').data('gridstack');
  grid.resizable($('.grid-stack-item'),false);

});

 function addWidget(did){
  var nid = $('#node').val();
    var sid = $('#included_sensors').val();  // here we are taking
    $.ajax({
      type: "POST",
                url: "<?php echo site_url('dashboard/add_sensor_to_directory');?>/"+did+"/"+sid+"/"+nid, //here we are calling our user controller and get_cities method with the country_id
                success: function(added_sensor) //we're calling the response json array 'included_sensors'
                {

                  if(added_sensor==null)
                    alert("the sensor is exist in thid directory!");

                  $url = "<?php echo site_url('dashboard/load_directory');?>/"+did;
                  window.location.href = $url;

                }

              });


  }

  function removeWidget(type,did,sid,nid){

    $.ajax({
      type: "POST",
                url: "<?php echo site_url('dashboard/delete_sensor_from_directory');?>/"+did+"/"+sid+"/"+nid, //here we are calling our user controller and get_cities method with the country_id

                success: function(result) //we're calling the response json array 'included_sensors'
                {

                  if(result.cnt=='0'){
                  $('#'+type+'-bundle').remove();
                }else{
                 $('#'+type+'-bundle').css('height',  '-=120px');
                 var grid = $('#'+type+'-stack').data('gridstack');
                 grid.remove_widget($('#'+sid));
               }
             }

           });
  }

</script>
