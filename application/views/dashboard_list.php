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
   <script src="/assets/js/Chart.js"></script>

 </head>
 <div id="sub-header" class="sub-header">
   <header id="header" class="">

    <script src="/assets/js/bootstrap.min.js" rel="stylesheet"></script>

    <span class="add-widget">
     <!-- Button trigger modal -->
     <button class="btn add-widget-btn btn-default btn-md" data-toggle="modal" data-target="#selectTypeModal">
      <span class="glyphicon glyphicon-plus"> Widget 추가</span>
    </button>


  </span>

</header><!-- /header -->
</div><!-- /header -->

<!-- Select Type Modal -->
<div class="modal fade" id="selectTypeModal" tabindex="-1" role="dialog" aria-labelledby="selectTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Dashboard에 추가할 Widget Type 선택</h4>
      </div>
      <div class="modal-body">
        Dashboard에 추가하고자 하는 Widget Type 선택하세요
        <br>
        <?php
        $types = array(
          '#' => 'Select type',
          'sensor' => 'Sensor',
          'chart' => 'Chart'
          );
        echo form_dropdown('type', $types, '#', 'id="type" class="form-control"');
        ?>
        <input type="hidden" id="dashboard_id" name="dashboard_id" value="<?=$uid?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        <input type="button" class="btn btn-primary" data-dismiss="modal" value=" Select " name="submit" onclick="addWidget('<?=$uid?>')"/>
      </div>
    </div><!-- /modal-content -->
  </div><!-- /modal-dialog -->
</div><!-- /modal -->

<!-- Select Sensor Modal -->
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
        <input type="hidden" id="widget_id" name="widget_id" value="defalut">
        <?php $included_sensors['#'] = 'Select Gateway first'; ?>
        <label for="gateway">Gateway: </label><?php echo form_dropdown('gateway_id', $gateways, '#', 'id="gateway" class="form-control"'); ?>
        <label for="sensor">Sensor: </label><?php echo form_dropdown('sensor_id', $included_sensors, '#', 'id="included_sensors" class="form-control"'); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        <input type="button" class="btn btn-primary" data-dismiss="modal" value=" Select " name="submit" onclick="connectSensor()"/>
      </div>
    </div><!-- /modal-content -->
  </div><!-- /modal-dialog -->
</div><!-- /modal -->

<body id="dashboard">

 <div id="main-stack" class="grid-stack" data-gs-width="12" align="center">
   <?php
   foreach($widgets['sensor_gid'] as $k=>$v){
    $length = count($widgets['sensor_gid']) -1;
    $index = $length-$k;
    $widget_id = $widgets['widget_id'][$index];
    $sid = $widgets['sid'][$index];
    $sensor_gid = $widgets['sensor_gid'][$index];
    $sensor_model = $widgets['sensor_model'][$index];
    $type = $widgets['sensor_type'][$index];
    switch($type){
      case '1':
      $type = 'temperature';
      break;
      case '2':
      $type = 'humidity';
      break;
    }
    $widget_type =  $widgets['widget_type'][$index];
    $x = 2*($index%5);
    $y = $index/5;
    if($widget_type==='sensor'){
      ?>

      <div id="widget<?=$widget_id?>" class="grid-stack-item" data-gs-x="<?=$x?>" data-gs-y="<?=$y?>" data-gs-width="2" data-gs-height="1" style="margin: 20px;">
        <div class="grid-stack-item-content widget" >
          <div class="widget-name">
            <button id="<?=$sid?>" type="button" class="btn btn-default btn-xs btn-sensor-control" onclick="removeWidget('<?=$uid?>','<?=$widget_id?>')">
              <span class="glyphicon glyphicon-minus-sign"></span>
            </button>
            <div class="name"><?=$widget_type?> - <?=$sensor_model?></div>
          </div>
          <div class="widget-content">
           <div class="type">
            <?=$type?>
          </div>
          <div class="value">
            23
          </div>
          <div class="update">
            2분 전
          </div>
        </div><!-- /sensor-content -->
      </div><!-- /sensor-item-content -->
    </div><!--/sensor-item-->
    <?php
  }
  else if($widget_type==='chart'){
    ?>
    <div id="widget<?=$widget_id?>" class="grid-stack-item" data-gs-x="<?=$x?>" data-gs-y="<?=$y?>" data-gs-width="12" data-gs-height="2" style="margin: 20px;">
      <div class="grid-stack-item-content widget" >
        <div class="widget-name">
          <button id="<?=$sid?>" type="button" class="btn btn-default btn-xs btn-sensor-control" onclick="removeWidget('<?=$uid?>','<?=$widget_id?>')">
            <span class="glyphicon glyphicon-minus-sign"></span>
          </button>
          <div class="name"><?=$widget_type?> - <?=$sensor_model?></div>
        </div>
        <div class="widget-content chart" align="center">
          <canvas  class="col-lg-11 col-sm-11" id="canvas<?=$widget_id?>" width="95%" height="15%"></canvas>
          <script>
            var testData = {
              labels : [],
              datasets : [
              {
                fillColor : "rgba(172,194,132,0.4)",
                strokeColor : "#ACC26D",
                pointColor : "#fff",
                pointStrokeColor : "#9DB86D",
                data : []
              }
              ]
            };

            var datas = document.getElementById('canvas<?=$widget_id?>').getContext('2d');
            var dataChart = new Chart(datas).Line(testData);

            <?php
              for($i=0;$i<$data_date['cnt'][$sid];$i++){
                $date = $data_date[$sid][$i];
                $value = $data_value[$sid][$i];
                ?>
                 var date = <?=$date?>;
                 var value = <?=$value?>;
                dataChart.addData([value],date);

                <?php
              }
            ?>
          </script>
        </div><!-- /sensor-content -->
      </div><!-- /sensor-item-content -->
    </div><!--/sensor-item-->
    <?php
  }
}?>
</div><!--sensor-stack-->

<script type="text/javascript">

 $(document).ready(function(){
        $('#gateway').change(function(){ //any select change on the dropdown with id country trigger this code
        $("#included_sensors > option").remove(); //first of all clear select items
            var gid = $('#gateway').val();  // here we are taking country id of the selected one.

            $.ajax({
              type: "POST",
                url: "<?php echo site_url('dashboard/get_included_sensors');?>/"+gid, //here we are calling our user controller and get_cities method with the country_id

                success: function(included_sensors) //we're calling the response json array 'included_sensors'
                {
                    $.each(included_sensors,function(sid,sensor_model) //here we're doing a foeach loop round each sensor with id as the key and city as the value
                    {
                        var opt = $('<option />'); // here we're creating a new select option with for each city
                        opt.val(sid);
                        opt.text(sensor_model);
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

 function addWidget(uid){
    var type = $('#type').val();  // here we are taking
    var widget_id;
    var width, height;

    $.ajax({
      type: "POST",
                url: "<?php echo site_url('dashboard/add_widget_to_dashboard');?>/"+uid+"/"+type, //here we are calling our user controller and get_cities method with the country_id
                success: function(added_widget) //we're calling the response json array 'included_sensors'
                {
                  widget_id = added_widget.widget_id;

                  var element = "<div id='widget"+widget_id+"'' class='grid-stack-item'>";
                  element += "<div class='grid-stack-item-content widget' >";
                  element += "<div class='widget-name'>";
                  element+= "<button type='button' class='btn btn-default btn-xs btn-sensor-control' onclick='removeWidget("+uid+","+widget_id+")'>";
                  element+= "<span class='glyphicon glyphicon-minus-sign'></span></button>";
                  element+= "<div class='name' id='name"+widget_id+"'>Please select Sensor</div></div>";

                  if(type==='sensor'){
                    width = '2';
                    height = '1';
                    element += "<div class='widget-content' align='center'>";
                    element += '<div id="sensor_content'+widget_id+'"><button class="btn add-sensor-btn btn-primary btn-md" data-widget_id='+widget_id+' data-toggle="modal" data-target="#selectSensorModal">센서 추가</button></div>';
                  }else if(type==='chart'){
                    width = '12';
                    height = '2';
                    element += "<div class='widget-content chart' align='center'>";
                     element += '<div id="connect_sensor'+widget_id+'"><button class="btn add-sensor-btn btn-primary btn-md" data-widget_id='+widget_id+' data-toggle="modal" data-target="#selectSensorModal">센서 추가</button></div>';
                    element += "<canvas id='canvas"+widget_id+"' width='1400' height='100'>";
                    element += "</canvas>";
                  }
                  element += "</div>";
                  element += "</div></div><!--sensor-item-->";

                  var el = $.parseHTML(element);
                  var grid = $('#main-stack').data('gridstack');
                grid.add_widget(el,0, 0, width, height, true);
              }
            });
}

 $(document).on("click", ".add-sensor-btn", function () {
                   var widget_id = $(this).data('widget_id');
                   $(".modal-body #widget_id").val(widget_id);
                 });

function connectSensor(){
   var sid = $('#included_sensors').val();
   var widget_id = $('#widget_id').val();
   $.ajax({
      type: "POST",
                url: "<?php echo site_url('dashboard/connect_widget_with_sensor');?>/"+widget_id+"/"+sid, //here we are calling our user controller and get_cities method with the country_id
                success: function(updated_widget) //we're calling the response json array 'included_sensors'
                {
                  var type = updated_widget.widget_type;
                  var name = updated_widget.sensor_model;
                  var sensor_type = updated_widget.sensor_type;
                   document.getElementById('name'+widget_id).innerHTML = type + " - " +name;
                  if(type==='sensor'){
                    var content = "<div class='type'>"+sensor_type+"</div><div class='value'>23</div><div class='update'>2분 전</div>";
                    document.getElementById('sensor_content'+widget_id).innerHTML = content;
                  }else if(type==='chart'){
                    document.getElementById('connect_sensor'+widget_id).innerHTML = '';
                     var testData = {
                    labels : [],
                    datasets : [
                    {
                      fillColor : "rgba(172,194,132,0.4)",
                      strokeColor : "#ACC26D",
                      pointColor : "#fff",
                      pointStrokeColor : "#9DB86D",
                      data : []
                    }
                    ]
                  };
                  document.getElementById('canvas'+widget_id).setAttribute('height','200');
                    var datas = document.getElementById('canvas'+widget_id).getContext('2d');
                var dataChart = new Chart(datas).Line(testData);
                var i;
                for(i=1;i<updated_widget.cnt;i++){
                  dataChart.addData([updated_widget.data_value[i]],updated_widget.data_date[i]);
                }

                }
              }
            });
}

function removeWidget(uid,widget_id){

  $.ajax({
    type: "POST",
                url: "<?php echo site_url('dashboard/delete_widget_from_dashboard');?>/"+uid+"/"+widget_id, //here we are calling our user controller and get_cities method with the country_id

                success: function() //we're calling the response json array 'included_sensors'
                {
                 var grid = $('#main-stack').data('gridstack');
                 grid.remove_widget($('#widget'+widget_id));
               }

             });
}

</script>
