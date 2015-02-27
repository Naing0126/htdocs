<!DOCTYPE html>
<html>
<head>
    <link href="css/gridstack.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="js/gridstack.js"></script>


</head>

<header id="header" class="">
    <div class="explorer">
            <h2 id="path">Trigger</h2>
    </div>
</header><!-- /header -->

<body>
    <div class="grid-stack">
    <div class="grid-stack-item"
        data-gs-x="2" data-gs-y="5"
        data-gs-width="3" data-gs-height="8">
            <div class="grid-stack-item-content"></div>
            <button type="">hi</button>
    </div>
    <div class="grid-stack-item"
        data-gs-x="6" data-gs-y="5"
        data-gs-width="3" data-gs-height="8">
            <div class="grid-stack-item-content"></div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    var options = {
        cell_height: 80,
        vertical_margin: 10
    };
    $('.grid-stack').gridstack(options);
});
</script>
</div>
</body>
</html>