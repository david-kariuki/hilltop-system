<?php
include_once "../../app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$data = $_SESSION['reports_data'];
$data = json_decode($data);
$table_data = $data->table_data;

?>
<style type="text/css">
.heading_section {
  width: 100%;
}

.heading_section h1 {
  width: 100%;
  text-align: center;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #2780f4;
  text-decoration: underline;
}

.heading_section .subtitle_head {
  width: 100%;
  margin: 0;
  padding: 0;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  margin-bottom: 20px;
}

.heading_section .subtitle_head .field_section {
  width: 50%;
  padding-left: 20px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

.heading_section .subtitle_head .field_section h4,
.heading_section .subtitle_head .field_section p {
  height: 20px;
  margin: 0;
  padding: 0;
  margin-left: 10px;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #686868;
}
.table_section{
    width: 300px;
    
}

</style>

<!-- <style type="text/css">

</style> -->

    <page>
        <div class="heading_section">
            <h1><?php echo "Hill Top Wines And Spirits<br>".$data->Title; ?></h1>
            <div class="subtitle_head">
                <div class="field_section">
                    <h4>Period:</h4>
                    <p><?php echo $data->Period; ?></p>
                </div>
                <div class="field_section">
                    <h4>Date:</h4>
                    <p><?php echo $data->Date_today; ?></p>
                </div>
            </div>
        </div>
        <div class="table_section">
            <table style="width: 100%; border: solid 1px black; margin-left:20px">
                <thead>
                    <tr>
                    <th scope="col" style="background-color: rgb(39, 128, 244); color:white;" >#</th>
                    <th scope="col" style="background-color: rgb(39, 128, 244); color:white;" >Sale ID</th>
                    <th scope="col" style="background-color: rgb(39, 128, 244); color:white;" >Sale Type</th>
                    <th scope="col" style="background-color: rgb(39, 128, 244); color:white;" >Sale Quantity</th>
                    <th scope="col" style="background-color: rgb(39, 128, 244); color:white;" >Sale Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($table_data as $key => $value) {

                    ?>
                    <tr>
                        <th scope="row" style="text-align: left;    width: 6%";><?php echo $count ?></th>
                        <td style="text-align: left;    width: 36%;    border:solid grey 1px; "><?php echo $value->sale_ID ?></td>
                        <td style="text-align: left;    width: 36%;    border:solid grey 1px; "><?php echo $value->sale_type ?></td>
                        <td style="text-align: left;    width: 36%;    border:solid grey 1px; "><?php echo $value->sale_Quantity ?></td>
                        <td style="text-align: left;    width: 36%;    border:solid grey 1px; "><?php echo number_format($value->sale_Amount);
                        $count++; ?></td>
                    </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </page>