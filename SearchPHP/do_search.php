<?php
include '../connection.php';


    // never trust what user wrote! We must ALWAYS sanitize user input
    $word = mysql_real_escape_string($_POST['search']);
    $word = htmlentities($word);
    // build your search query to the database
    $sql = "SELECT p.POID, c.cName, p.receiving_date, p.initial_inspection, p.final_inspection, p.nr_of_lines, p.shipping_date 
            FROM POS p, Customers c
            WHERE p.CID = c.CID 
            AND POID LIKE '%".$word."%'";
    $result = mysqli_query($link, $sql);
    // get results
echo "<table class='col-md-8 col-md-offset-2'>
<tr>
<th>POID</th>
<th>Customer</th>
<th>Receiving Date</th>
<th>Initial Inspection</th>
<th>Final Inspection</th>
<th>Number of Lines</th>
<th>Shipping Date</th>
</tr>";
if(!$result){echo "no results";}
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "<td>" . $row[5] . "</td>";
    echo "<td>" . $row[6] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($link);
?>