<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Pay Service Providers
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                          <div class="table-responsive">
                            <table class="display table table-bordered" id="jr">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>FirstName</th>
                                        <th>LastName</th>
                                        <th>Email</th> 
                                        <th>Phone</th>
                                        <th>ProfilePic</th>
                                        <th>Gross Amount</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <?php $i =1;             
                                  foreach ($mainData as $user) {?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $user->fname; ?>
                                    </td>
                                      <td>
                                        <?php echo $user->lname; ?>
                                    </td>
                                      <td>
                                        <?php echo $user->email; ?>
                                    </td>
                             
                                      <td>
                                        <?php echo $user->phone; ?>
                                    </td>
                                    
                                    <td><img src="<?php echo empty($user->profile_pic)?base_url('Public/img/AdminImages').'/default.jpg':$user->profile_pic; ?>" style="width:90px;height:auto;border-radius:50%" /></td>
                                    <td id="myAmnt<?php echo $user->id; ?>">
                                        <?php echo $user->myAmount; ?>
                                    </td>
                                    <td>
                                    <a href="#myModal" data-toggle="modal" class="btn btn-danger payAction" data-userid ="<?php echo $user->id; ?>">Pay</a>
                                    </td>
                                </tr>
                                <?php $i++;
                                 }   
                                ?>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>



         <div class="panel-body">

                               <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Pay Amount</h4>
                                          </div>
                                          <div class="modal-body">
                                          <form role="form" name="payMoney" method="POST" action="payMoney" enctype="multipart/form-data">
                                                  <div class="form-group">
                                                      <label for="exampleInputEmail1">Transfer Amount</label>
                                                      <input type="number" class="form-control" id="tamount" value = "" name ="amount" placeholder="">
                                                      <p id="errorMessage" style="display: none;">Withdraw Amount Should be lesser than wallet Amount.</p>
                                                       <input type="hidden" name="editId" id ="hiddenVal" value="">
                                                         <!-- <input type="hidden" name="modalAmount" id ="modalAmount" value="">  -->
                                                  </div>
                                                 <div class="form-group col-sm-10">
                                                     <div class="checkbox">
                                              <label><input type="checkbox" name="tandc" id='agree'>I ACCEPT THE TERMS </label>
                                         <p class="">The Amount will be deducted from wallet. Further refer to payment policies.</p>
                                                </div>
                                              </div>

                                      
                                                  <button type="submit"  id = "ttres3" name = "payMoney" class="btn btn-default">Submit</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              </div>
    </section>
</section>

<script type="text/javascript">
    $(document).ready(function() {

    $("body").delegate(".payAction2", "click", function () {
            var payId = $(this).attr('payId');
           // alert(revid);
            $.ajax(
                    {
                        type: 'post',
                        url: 'ajaxPay',
                        dataType: 'json',
                        data: {payId: payId},
                        cache: false,
                        beforeSend: function () {
                            $(".loadermyli").show();
                        },
                        success: function (data) {

                            
                            //         if(data == 1){

                            //           var table = $('#jr').DataTable();
                            //           table.row('#delData'+revid).remove().draw( false );
                         
                            // }
                        },
                        complete: function () {
                            $(".loadermyli").hide();
                        },
                        error: function (request, status, error) {

                        }
            });
        });

$("body").delegate(".payAction", "click", function () {
  // console.log(this);
  var payId = $(this).attr('data-userid');
  var amount = $('#myAmnt'+payId).html();
  // console.log(payId);

  document.getElementById('tamount').value = amount.trim();
  
  
});
$('#tamount').change(function() {
    var newAmt = parseInt($(this).val()); // get the current value of the input field.
    var id = $('#hiddenVal').val();
    var amount = parseInt($('#myAmnt'+id).html().trim());
    // console.log(amount);
    // console.log(newAmt);
    if (newAmt>amount) {
      $("#errorMessage").show();
      $(this).val(amount);
    } else{
      $("#errorMessage").hide();
    };
});



    $('#myModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('userid');
  
   document.getElementById('hiddenVal').value = userid;

  $('#ttres3').click(function(){

      if ($('#agree').is(":checked"))
      { 
        console.log('check');
        return true;
      }else{
        
        alert('Please accept the terms to submit Payment.');
        return false;
        $('#myModal').modal('hide');
      }
    });

/*   $('#jr').each(function() {
    var customerId = $('#jr').find("td").eq(6).html();    
    alert(customerId); return false;
});*/
});
    });

</script>


