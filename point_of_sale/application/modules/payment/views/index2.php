<?php
main_header(['create_order']);

// echo $mockup_img->Mockup_design;
?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0">Order Details / Payment</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <!-- NEW CUSTOMER -->
        <div class="card card-primary">
            <div class="card-header">
                <!-- <h3 class="card-title">New Customer Details</h3> -->
            </div>

            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 text-center user-block">
                            <span class="username">
                                <h3><?=strtoupper($cust_details->FName." ".$cust_details->LName." / ".$cust_details->Company)?></h3>
                                <input type="text" id="cust_id"  hidden value="<?=$cust_details->ID?>">
                            </span>
                            <span class="description">Customer Name</span>
                        </div>
                    </div>

                    <!-- <button type="button" class="btn btn-sm btn-danger" id="cancel_order" value="<?=$order_dets->ID?>" <?=$last_paid == 0 ? '' : 'hidden'?>>Cancel Order</button> -->
                    <button type="button" class="btn btn-sm btn-danger" id="cancel_order" value="<?=$order_dets->ID?>" <?=empty(@$last_paid_cancel_order_ref) ? '' : 'hidden'?>>Cancel Order</button>
                    <div class="row mt-2 ">
                        <div class="col-sm-6">
                           <div class="card card-primary">
                                <div class="card-body">

                                    <div class="input-group-prepend">
                                            <h5>Payment Status | 
                                            <?php
                                                if($last_paid == 0){
                                                    echo '<b class="text-danger text-bold">UNPAID</b>';
                                                } elseif($last_paid < $order_dets->Total_amt){
                                                    echo '<b class="text-primary text-bold">DOWN</b>';
                                                } elseif($last_paid >= $order_dets->Total_amt){
                                                    echo '<b class="text-success text-bold">PAID</b>';
                                                }
                                            
                                            ?></h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label><?=$order_dets->Jo_num?></label>
                                            <table class="table table-bordered" id="table_id">
                                                <thead>
                                                    <tr>
                                                        <!-- november 17 -->
                                                            <th style="width: 10%">#</th>
                                                            <th>Item</th>
                                                            <th style="width: 20%">Qty</th>
                                                            <th>Unit Price</th>
                                                            <th class="to_hide_update">Subtotal</th>
                                                            <th class="to_hide_update_2" style="display:none"></th>
                                                        <!-- end of november 17 -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                        <?php
                                                            $totalqty = 0;
                                                            $totalamt = 0;
                                                            foreach($order_items as $key => $value){ ?>
                                                             <tr class="lh-1">
                                                                <td><?=$key+1?></td>
                                                                <td><?=$value->List_name?></td>
                                                                <!-- november 17 -->
                                                                    <!-- <td><?=$value->Item_qty?></td> -->
                                                                    <!-- <td><?=number_format(($value->Item_unitprice/$value->Item_qty),2)?></td> -->
                                                                    <td><input type="number" class="form-control form-control-sm to_edit item_qty_<?=$value->ID?>" disabled value="<?=$value->Item_qty?>" ></td>
                                                                    <td><input type="number" class="form-control form-control-sm to_edit item_amount_<?=$value->ID?>" disabled value="<?=number_format(($value->Item_unitprice/$value->Item_qty),2)?>"></td>
                                                                    <td class="to_hide_update"><?=number_format($value->Item_unitprice,2)?></td>
                                                                    <td class="to_hide_update_2" style="display:none">
                                                                        <button type="button" class="btn btn-xs btn-danger" id="delete_item" data-id="<?=$value->ID?>" data-amount="<?=@$value->Item_unitprice?>" data-qty="<?=@$value->Item_qty?>" data-oid="<?=@$value->Order_ID?>" <?=!empty($session->Branch) ? 'hidden':''?>><i class="fa fa-trash"></i></button>
                                                                        <button type="button" class="btn btn-xs btn-primary" id="update_item" data-id="<?=$value->ID?>" data-oid="<?=@$value->Order_ID?>"><i class="fa fa-pen"></i></button>
                                                                    </td>
                                                                <!-- end of november 17 -->
                                                            </tr>
                                                         <?php   
                                                                $totalqty += $value->Item_qty; 
                                                                $totalamt += $value->Item_unitprice; 
                                                            }
                                                            
                                                        ?>
                                                        <tr class="text-bold text-danger">
                                                            <td>Total</td>
                                                            <td></td>
                                                            <td><?=$totalqty?></td>
                                                            <td></td>
                                                            <td>&#8369 <?=number_format($totalamt,2)?></td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                            <!-- november 17 -->
                                                <a role="button" href="<?=base_url()?>create_order/add_order?oid=<?=$order_dets->ID?>&custid=<?=$cust_details->ID?>" class="btn btn-success btn-sm" id="add_order" <?=$last_paid >= $order_dets->Total_amt ? 'hidden':''?>>Add Order</a>
                                                <button type="button" class="btn btn-warning btn-sm" id="update_order" <?=$last_paid >= $order_dets->Total_amt ? 'hidden':''?>>Update Order</button>    
                                                <button type="button" class="btn btn-warning btn-sm" id="cancel_update" style="display:none">Cancel/Done</button>
                                            <!-- end of november 17 -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                           <h6>Discount</h6>
                                           <b>&#8369 <?=number_format($order_dets->Discount,2)?></b>

                                        </div>
                                        <div class="col-sm-6">
                                           <h6>Total Amount</h6>
                                           <b>&#8369 <?=number_format($order_dets->Total_amt,2)?></b>
                                        </div>
                                    </div>

                                    <div class="row text-center mt-2" style="border-top: 1px solid black">
                                        <div class="col-sm-6">
                                            <h6>Payment Received</h6>
                                            <b class="text-success">&#8369 <?=number_format($last_paid,2)?></b>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                                $balance = $order_dets->Total_amt - $last_paid;
                                            ?>
                                           <h6>Total Balance</h6>
                                           <b class="text-danger">&#8369 <?=number_format($balance,2)?></b>
                                           <input type="number" id="Balance" value="<?=number_format($balance,2)?>" hidden>
                                        </div>
                                    </div>
                                    
                                    <br>
                                    
                                    <div class="row text-center mt-2" style="border-top: 1px solid black" id="cod_terms" 
                                        <?php if(@$cod_terms->List_name == "Cash" || @$cod_terms->List_name == "Online Payment" || @$cod_terms->List_name == NULL){
                                            echo 'hidden';
                                        }?>
                                    
                                    >
                                        <div class="col-sm-6">
                                            <h6>COD / Terms</h6>
                                            <b><?=@$cod_terms->List_name?></b>
                                        </div>
                                        <div class="col-sm-6">
                                           <h6>Set Due Date</h6>
                                           <b><?=date('M d, Y', strtotime(@$cod_terms->Due_date))?></b>
                                        </div>
                                    </div>

                                    <div class="row text-center mt-2">
                                        <div class="col-sm-10 mt-2">
                                            <form action="" class="form-horizontal">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><small>Payment Mode</small></label>
                                                    <div class="col-sm-8">
                                                        <select class="custom-select custom-select-sm rounded-0" id="Payment_mode" <?= $balance == 0 ? 'disabled' : ''?>>
                                                            <?php
                                                                foreach($p_mode as $value){ ?>
                                                                    <option value="<?=$value->ID?>"><?=$value->List_name?></option>
                                                                    
                                                                <?php } 
                                                            ?>
                                                        </select>
                                                        <small class="text-danger" <?=$session->Role != "Front Desk" ? 'hidden' : ''?>>Cash payment is disabled for Frontdesk users.</small>
                                                    </div>
                                                   
                                                    <!-- <label class="col-sm-4 col-form-label"><small>Proof of Payment</small></label> -->
                                                        <!-- <div class="col-sm-8"  id="proof_of_payment_group" style="display: none;">
                                                        <form id="uploadFormProof" enctype="multipart/form-data">
                                                            <input type="file" class="custom-file-input" name="files[]" id="payment_proof" multiple>
                                                            <label class="custom-file-label" for="exampleInputFile">
                                                                    Choose file
                                                            </label>
                                                        </form>    
                                                        </div> -->
                                                    <div class="custom-file" id="proof_of_payment_group" style="display: none;">
                                                        <form id="uploadFormProof" enctype="multipart/form-data">
                                                            <input type="file" class="custom-file-input" name="files[]" id="payment_proof" multiple>
                                                            <label class="custom-file-label" for="exampleInputFile">
                                                                Choose file
                                                            </label>
                                                        </form>    
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="rec_num" >
                                                    <label class="col-sm-4 col-form-label"><small>Receipt Number</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"  id="Receipt_number" <?= $balance == 0 ? 'disabled' : ''?> <?=$session->Role == "Front Desk" ? 'disabled' : ''?> placeholder="Enter Receipt Number">
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="ref_num" style="display: none;">
                                                    <label class="col-sm-4 col-form-label"><small>Reference Number</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"  id="Reference_number" <?= $balance == 0 ? 'disabled' : ''?> placeholder="Enter Reference Number">
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="terms" style="display: none;">
                                                    <label class="col-sm-4 col-form-label"><small>P.O Number</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"  id="po_number" <?= $balance == 0 ? 'disabled' : ''?> placeholder="Enter P.O Number">
                                                    </div>
                                                </div>
                                                 <div class="form-group row" id="way_num" style="display: none;">
                                                    <label class="col-sm-4 col-form-label"><small>Waybill Number</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"  id="Waybill_number" <?= $balance == 0 ? 'disabled' : ''?> placeholder="Enter Waybill Number">
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="d_date" style="display: none;">
                                                    <label class="col-sm-4 col-form-label"><small>Due Date</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control form-control-sm" id="Due_date" <?= $balance == 0 ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row " id="amnt">
                                                    <label class="col-sm-4 col-form-label"><small>Amount to Pay</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control form-control-sm"  id="Amount_paid" placeholder="Amount" <?= $balance == 0 ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="amnt_rendered">
                                                    <label class="col-sm-4 col-form-label"><small>Amount Rendered</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control form-control-sm"  id="Amount_rendered" placeholder="Amount" <?= $balance == 0 ? 'disabled' : ''?> <?=$session->Role == "Front Desk" ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="chnge">
                                                    <label class="col-sm-4 col-form-label"><small>Change</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control form-control-sm text-danger text-bold" id="change" placeholder="Change" disabled>
                                                    </div>
                                                </div>
                                                 
                                            </form>
                                        </div>
                                    </div>
                                   <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default" <?= $balance == 0 ? 'disabled' : ''?> <?=$session->Role=="Artist" ? 'disabled' : ''?>>Submit Payment</button>

                                   </div>
                                </div>
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <!-- ORDER DETAILS -->
                            <div class="card card-primary">
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h5>Order Details | </h5>
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="custom-select custom-select-sm rounded-0 select_update" id="o_status">
                                                    <option value="<?=$o_status->ID?>" selected><?=ucfirst($o_status->List_name)?></option>

                                                    <?php
                                                        foreach($status as $value){ ?>
                                                            <option value="<?=$value->ID?>" <?=$o_status->ID == $value->ID ? 'disabled class="text-bold text-danger"' : ''?>><?=ucfirst($value->List_name)?><?=$o_status->ID == $value->ID ? " (Selected)" : ''?></option>
                                                        <?php }
                                                    ?>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <h6>Book Date: <b><?=date('M d, Y', strtotime($order_dets->Book_date))?></b></h6>

                                            <label for="">Booking Note</label>
                                            <p class="<?=empty($order_dets->Order_note) ? 'text-danger text-bold' : ''?> note_area2"><?=empty($order_dets->Order_note) ? 'No note' : $order_dets->Order_note ?></p>
                                            <textarea  id="b_note" class="form-control note_area" placeholder="Enter Booking Note..."><?=empty($order_dets->Order_note) ? '' : $order_dets->Order_note ?></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <h6 class="dates2">Deadline: <b><?=date('M d, Y', strtotime($order_dets->Deadline))?></b></h6>
                                            <h6 class="dates">Deadline: <input id="deadline_date" class="form-control" type="date" value="<?=date($order_dets->Deadline)?>"></b></h6>

                                            <label for="">Deadline Note</label>
                                            <p class="<?=empty($order_dets->Deadline_notes) ? 'text-danger text-bold' : ''?> note_area2"><?=empty($order_dets->Deadline_notes) ? 'No note' : $order_dets->Deadline_notes ?></p>
                                            <textarea  id="d_note" class="form-control note_area" placeholder="Enter Deadline Note..."><?=empty($order_dets->Deadline_notes) ? '' : $order_dets->Deadline_notes ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">Freebies</label>
                                            <p class="<?=empty($order_dets->Freebies) ? 'text-danger text-bold' : ''?> note_area2" ><?=empty($order_dets->Freebies) ? 'No freebies' : $order_dets->Freebies ?></p>
                                            <textarea  id="freebies" class="form-control note_area" placeholder="Enter Freebies..."><?=empty($order_dets->Freebies) ? '' : $order_dets->Freebies ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">Sewer</label>
                                            <select class="custom-select custom-select-sm rounded-0 select_update" id="sewer">
                                                <option value="<?=$sewer->ID?>" selected><?=ucfirst($sewer->LName)." ,".ucfirst($sewer->FName)?></option>
                                                <?php
                                                    foreach($users as $value){ ?>
                                                        <option value="<?=$value->ID?>" <?=$sewer->ID == $value->ID ? 'disabled class="text-bold text-danger"' : ''?>><?=ucfirst($value->LName)." ,".ucfirst($value->FName)?><?=$sewer->ID == $value->ID ? " (Selected)" : ''?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Layout Artist</label>
                                            <select class="custom-select custom-select-sm rounded-0 select_update"  id="layout">
                                                <option value="<?=$lay_artist->ID?>" selected><?=ucfirst($lay_artist->LName)." ,".ucfirst($lay_artist->FName)?></option>

                                                <?php
                                                    foreach($users as $value){ ?>
                                                        <option value="<?=$value->ID?>" <?=$lay_artist->ID == $value->ID ? 'disabled class="text-bold text-danger"' : ''?>><?=ucfirst($value->LName)." ,".ucfirst($value->FName)?><?=$lay_artist->ID == $value->ID ? " (Selected)" : ''?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Setup Artist</label>
                                            <select class="custom-select custom-select-sm rounded-0 select_update" id="setup">
                                                <option value="<?=$set_artist->ID?>" selected><?=ucfirst($set_artist->LName)." ,".ucfirst($set_artist->FName)?></option>

                                                <?php
                                                    foreach($users as $value){ ?>
                                                        <option value="<?=$value->ID?>" <?=$set_artist->ID == $value->ID ? 'disabled class="text-bold text-danger"' : ''?>><?=ucfirst($value->LName)." ,".ucfirst($value->FName)?><?=$set_artist->ID == $value->ID ? " (Selected)" : ''?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-xs btn-primary btn-flat mt-2" id="update_dets" <?=$session->Role=="Artist" ? 'disabled' : ''?>>Update</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-flat mt-2" id="cancel">Cancel</button>
                                    <button type="button" class="btn btn-xs btn-success btn-flat mt-2" data-oid="<?=$order_dets->ID?>" id="save_dets">Save</button>
                                    
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Mockup Design <span><button type="button" data-oid="<?=$order_dets->ID?>" id="view_mockup" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></button></span></label>
                                                    <!-- Modal Mock Up Design-->
                                            <div class="modal" tabindex="-1" role="dialog" id="view_modal">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Mockup Design</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                     <!-- ... -->
                                                    <div class="modal-body">
                                                        <!-- Display the current mockup design -->
                                                        <img id="mockupImage" src="<?php echo base_url(); ?>assets/uploaded/proofs/<?=@$mockup_img->Mockup_design?>" alt="Mockup Design" class="img-fluid">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <!-- Add a button to view previous designs -->
                                                        <button type="button" class="btn btn-secondary" id="view_previous_designs" data-toggle="modal" data-target="#previousDesignsModal">View Previous Designs</button>
                                                    </div>

                                                    <!-- Modal for viewing previous designs -->
                                                    <div class="modal" tabindex="-1" role="dialog" id="previousDesignsModal">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Previous Mockup Designs</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Loop through the previous designs and display them -->
                                                                    <?php foreach ($previousDesigns as $design): ?>
                                                                        <img src="<?php echo base_url(); ?>assets/uploaded/proofs/<?=$design->Mockup_design?>" alt="Previous Mockup Design" class="img-fluid">
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- ... -->

                                                    </div>
                                                </div>
                                            </div>
                                                <div class="input-group input-group-xs">
                                                    <div class="custom-file">
                                                        <form id="uploadForm" enctype="multipart/form-data">
                                                            <input type="file" class="custom-file-input" name="files[]" id="modal_reqs" multiple>
                                                            <label class="custom-file-label" for="exampleInputFile">
                                                                <?php if ($mockup_img): ?>
                                                                    <?=$mockup_img->Mockup_design;?>
                                                                <?php else: ?>
                                                                    Choose file
                                                                <?php endif; ?>
                                                            </label>
                                                        </form>    
                                                    </div>
                                                    <input type="button" value="Upload Mockup"  data-name="<?=$order_dets->Cust_ID?>" data-oid="<?=$order_dets->ID?>" class="btn btn-xs btn-success float-right" id="submit_req">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            
                            <!-- PAYMENT HISTORY -->
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="input-group-prepend">
                                        <h5>Payment History</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-sm">
                                                <thead style="font-size: 14px;">
                                                    <tr>
                                                        <td>#</td>
                                                        <th>Amount Paid</th>
                                                        <th>Date Paid / Due Date</th>
                                                        <th>Payment Mode</th>
                                                        <th>Received By</th>
                                                    </tr>
                                                </thead>
                                               <!-- $p_history section -->
<tbody>
    <?php foreach ($p_history as $key => $value) { ?>
        <?php
        $clickableClass = ($value->Mode == 'Online Payment') ? 'clickable-row' : '';
        $modalID = 'paymentProofModal' . $key; // Unique modal ID for each row
        ?>
        <tr class="<?=$clickableClass?> <?=$value->Void == 1 ? 'bg-gradient-danger' : ''?>" data-toggle="<?=$value->Mode == "Cash" ? '' : 'modal'?>" data-target="#<?=$modalID?>" data-pID="<?=$value->ID?>">
            <td><?=$key + 1?></td>
            <td>&#8369 <?=number_format($value->Amount_paid, 2)?></td>
            <!-- <td><?=$value->Mode == "Cash On Delivery (COD)" ? date('M d, Y', strtotime($value->Due_date)) : date('M d, Y', strtotime($value->Date_paid))?></td> -->
            <td><?=$value->Payment_mode == 52 ? date('M d, Y', strtotime($value->Due_date)) : date('M d, Y', strtotime($value->Date_paid)) ?></td>
            <td>
                <?php
                    if($value->Mode == "Cash"){
                        echo $value->Mode."(".$value->Receipt_num.")";
                    } else if($value->Mode == "Online Payment"){
                        echo $value->Mode;
                    } else if($value->Mode == "Cash On Delivery (COD)"){
                        echo $value->Mode;
                    } else if($value->Mode == "Terms"){
                        echo $value->Mode;
                    }
                ?>
            </td>
            <td><?=ucfirst($value->FName)." ".ucfirst($value->LName)?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
</div>

</div>

<!-- $p_proof section -->
<?php foreach ($p_proof as $key => $payment) { ?>
    <div class="modal" tabindex="-1" role="dialog" id="paymentProofModal<?=$key?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proof of Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php foreach ($payment->Proof_of_payment as $proof) { ?>
                        <!-- Assuming Proof_of_payment contains the image path -->
                        <img id="paymentProofImage" src="<?php echo base_url(); ?>assets/uploaded/proofs/<?=$proof->Proof_of_payment?>" alt="Proof of Payment" class="img-fluid">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- CONFIRMATION MODAL -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to save payment?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- Add data attribute with the filename of the uploaded mockup design -->
                <button type="button" class="btn btn-primary" data-oid="<?=@$order_dets->ID?>" id="pay" data-mockup-filename="<?=@$mockup_img->Mockup_design?>">Pay</button>
            </div>
        </div>
    </div>
</div>


<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/payment/payment.js"></script>
<!-- Add the JavaScript code within the CodeIgniter view -->
<script>

</script>