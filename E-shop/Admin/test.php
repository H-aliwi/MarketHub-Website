<?php 
session_start();

include("intil.php");  //<!-- router -->?>


<section class="dashboard">

<div class="container">
 <table>
    <thead><!--table header --->
        <tr><!--table row 1 --->
            <th colspan="3">Customer details </th>  <!--colspan="3" means table take 3 colum-->
        </tr>
      <tr> <!--table row 2 --->
        <th>Name</th>
        <th>Sale</th>
        <th>Username</th>
    </tr>   
    </thead>

    <tbody>
     <tr><!--table row 3 --->
        <td>Hussain</td> <!--table row 1  cell 1--->
        <td>300 BD</td>   <!--table row 1  cell 2--->
        <td>Hussainjaffer84</td>  <!--table row 1  cell 3--->
    </tr>
    <tr><!--table row 4 --->
        <td>Mohamed</td>
        <td>200 BD</td>
        <td>Mohamed4__</td>

    </tr>
    </tbody>
    <tfoot>
        <tr><!--table row 5 --->
            <th>Total</th>
            <th colspan="2">500</th>
        </tr>
    </tfoot>
</table>
</div>




    <!-- code here -->


</section>


<?php
include($tmpl . 'footer.php'); //<!-- footer -->
?>