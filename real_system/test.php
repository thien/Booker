<?php
// The message
//$message = "Line 1\r\nLine 2\r\nLine 3";
//
// In case any of our lines are larger than 70 characters, we should use wordwrap()
//$message = wordwrap($message, 70, "\r\n");
//
// Send
//mail('isthisthien@gmail.com', 'My Subject', $message);

    if(isset($_POST['delete']))
        {
             $delete_id = $_POST['checkbox'];
             $id = count($delete_id );
             if (count($id) > 0)
              {
                 foreach ($delete_id as $id_d)
                 {
                    $sql = "DELETE FROM `test` WHERE id='$id_d'";
                    $delete = mysql_query($sql);
                }
            }
            if($delete)
            {
                echo $id." Records deleted Successfully.";
            }
        }


    $sql="select * from test ";

    $res=mysql_query($sql) or die(mysql_error());
    ?>
    <form name="form1" method="POST" action="">
        <table width="578" border="1" align="center" id="menu">
        <tr>
        <th></th>
        <th>id</th>
        <th>Name</th>
        <th>email</th>
        <th>phno</th>
     </tr>

<?php
 while($row=mysql_fetch_array($res))
 {
?>

 <tr>

    <td><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $rows['id']; ?>"></td>
    <td><?php echo $row['id'];?></td>

    <td><?php echo $row['name'];?></td>
    <td><?php echo $row['emailid'];?></td>

    <td><?php echo $row['phno'];?></td>
    <?php
    echo"<td><a href='update.php?id=".$row['id']."'>Update</a></td>";
    ?>
 <?php
  }
 ?> 
 <tr><td><input type="submit" name="delete" value="Delete" id="delete"></td></tr></tr></table>

 <?php
// Check if delete button active, start this
$count = mysql_num_rows($res);
echo "$count";


?>