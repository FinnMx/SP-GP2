<?php
require("header.php");
require("require.php");


$EID = $_GET['eid'];

$sql = "SELECT * 
        FROM Engineer 
        WHERE Engineer_ID = :EID";

$stmt = $db->prepare($sql);
$stmt->bindParam(':EID', $EID, SQLITE3_TEXT);
$result = $stmt->execute();

$GGarrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
  $GGarrayResult[] = $row; //adding a record until end of records
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
</head>

<br>

<body>
  <div class="container">  

    <h1 style="color:#fff; text-align:center">WELCOME <?=$GGarrayResult[0]['F_name'];?></h1>
    <br>

    <div class="row">
      <div class="col-md-1"></div>

      <!-- GROUP DETAILS
      ----------------------------------------------------------------------------------------------------->
      <div class="col-md-10">
      <div class="w-box">

        <div class="row">

          <div class="col-md-6">
            <h3 style="color:#0C4582; text-align:center">TABLE</h3>
            <br>
            <!-- TABLE -->
            <div class="b-box">
              <table class="styled-table" style="display:block; height:140px; overflow:auto;">
                <thead >
                  <tr>
                    <th>ID</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>GROUP ID</th>
                  </tr>
                </thead>
                <?php
                //getting engineer data
                $sql = "SELECT Engineer_ID,F_name,L_name,Group_ID FROM Engineer WHERE Group_ID =:gid";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':gid', $GGarrayResult[0]['Group_ID'], SQLITE3_TEXT);
                $result = $stmt->execute();

                $EarrayResult = []; //prepare an empty array first
                while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                  $EarrayResult[] = $row; //adding a record until end of records
                }

                for ($i = 0; $i < count($EarrayResult); $i++) :
                ?>
                  <tbody>
                    <tr>
                      <td><?php echo $EarrayResult[$i]['Engineer_ID'] ?></td>
                      <td><?php echo $EarrayResult[$i]['F_name'] ?></td>
                      <td><?php echo $EarrayResult[$i]['L_name'] ?></td>
                      <td><?php echo $EarrayResult[$i]['Group_ID'] ?></td>
                    </tr>
                  </tbody>
                <?php endfor; ?>
              </table>
            </div>
            <!-- END OF TABLE -->    
          </div>

          <!-- GOOGLE BAR CHART
          -----------------------------------------------------------------------------------------------------
            
            <!-- DISPLAYING THE CHART -->
            <div id="piechart" style="width: 900px; height: 500px;"></div>
          </div>
  
        </div><!-- end of row -->
      </div>
      </div>
  </div><!-- container -->
  <br><br>
</body>

</html>