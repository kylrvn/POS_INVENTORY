
<?php

if(!empty($expenses)){
    foreach($expenses as $key => $value){ 
        // $d_date = date('Y-m-d',strtotime($value->Deadline));
        ?>
    <tr>
        <td><?=@$key+1?></td>
        <td><?= date('M d, Y',strtotime(@$value->Date))?></td>
        <td><?=@$value->Descr?></td>
        <td><?=@$value->Actual_Money?></td>
        <td><?=@$value->Incharge?></td>
        <td><?=@$value->expense?></td>
        <td><?=@$value->Balance?></td>
    </tr>

 <?php  
     }
} else { ?>
         <tr>
                <td colspan="8">
                    <div><center><h6>No data available in table.</h6></center></div>
                </td>
            </tr>
<?php }
?>