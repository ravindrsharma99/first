<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<style type="text/css">
a.button_CLASS {
    background: #EC6459 none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    width: 70px;
    padding: 4px 8px;
}

</style>
<script type="text/javascript" src="http://admin.iheartmyhbcu.org/Public/js/jquery.js" ></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php
//Helpers called to get all hbcu titles & organization titles
$hbc=get_all_hbcu_title();
$org=get_all_organization_title();
?>

<section id="main-content">
    <section class="wrapper site-min-height">

        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Users
                    </header>

                   <?php 
                      if ($this->session->flashdata('msg')==true) { ?>
                        <div class="alert alert-success alert-block fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <h4>
                                <i class="fa fa-ok-sign"></i>
                               <?php echo $this->session->flashdata('msg'); ?>
                            </h4>
                        </div>
                      <?php }
                      
                    ?>
                   <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered datatable" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>HBCU</th>
                                            <th>Organization</th>
                                            <th>ProfilePic</th>
                                            <th>Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                                    foreach ($userData as $user) {
                                     // echo "<prE>";   print_r($user);

                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                        <a href="<?php echo base_url('Dashboard/usertxn').'/'.$user->id ?>">
                                        <?php
                                        if ($user->first_name) {
                                        	echo $user->first_name; 
                                        }
                                        else{
                                          echo "N/A";
                                        }                                
                                        ?>
                                        </a> 
                                        </td>
                                        <td>  <?php
                                        if ($user->last_name) {
                                         echo $user->last_name; 
                                          
                                        }
                                        else{
                                          echo "N/A";
                                        }


                                         ?></td>
                                        <td><?php echo $user->email; ?></td>
                             
                                        <td>
                                            <?php
                                           
                                        $result = $this->db->query("select hb_usersHBCU.hbcu,hb_hbcu.title,hb_hbcu.logo,hb_hbcu.id from hb_usersHBCU inner join  hb_hbcu on(hb_hbcu.id=hb_usersHBCU.hbcu) where hb_usersHBCU.user_id = ".$user->id)->result();
                                        $datas = $result->title;
                                        $hbcu_id="";
                                        foreach ($result as $key => $value) {
                                            $hbcu_id.=$value->id.",";
                                            echo "&bull; ".$value->title."<br>";
                                        }
                                        $hbcu_id=rtrim($hbcu_id,",");
                                            ?>
                                        </td>
                                        <td><?php echo $user->organization_title; ?></td>

                                        <?php 
                                             
                                             if(!empty($user->profile))
                                              {  
                                                   $flag = strstr($user->profile, "facebook");

                                                    if ($flag){

                                                       $userprofile=$user->profile;
                                                    }else
                                                    {
                                                        $userprofile=base_url($user->profile);
                                                    }
                                             }else
                                             {
                                                $userprofile=base_url('Public/img/AdminImages/default.jpg');
                                             }
                                        ?>
                                        <td><img src="<?php echo $userprofile; ?>" style="width:90px;height:auto;border-radius:50%" /></td>
                                        <td><?php echo $d = date('d-M-Y g:i a',strtotime($user->created)); ?></td>
                                        <td class="alignment">
                           
                                            <?php if ($user->active_status==0) {
                                                ?>
                                            <a href="<?php echo base_url('Dashboard/suspenduser').'/'.$user->id.'?action=user_list'; ?>"  data-userid="<?php echo $user->id; ?>" name="delete" onclick="return confirm('Are You Sure?')" class="btn btn-danger">Suspend</a>
                                             
                                            <?php } else { ?>
                                              <a href="<?php echo base_url('Dashboard/activeuser').'/'.$user->id.'?action=user_list'; ?>"  data-userid="<?php echo $user->id; ?>" name="delete" onclick="return confirm('Are You Sure?')" class="btn btn-danger">Active</a>
                                             
                                            <?php } ?>


          <!--           <a href="#myModal" data-toggle="modal"
                                            data-userid="<?php echo $user->id; ?>"
                                            data-spare="<?php echo $user->isActivesparechange; ?>"
                                            data-reoccur="<?php echo $user->isActive; ?>"
                                         
                                            class="btn btn-primary">Status View</a>  -->
                                             <a id="<?php echo $user->id; ?>"
                                         
                                            class="btn btn-primary delete">Status View</a> 
                                             




                                        </td>
                                    </tr>
                                    <?php $i++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


  <!--   <div class="panel-body">
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Edit Users</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="edituser" method="POST" action="editUser" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname">
                                <input type="hidden" name="editId" id="hiddenVal" value="<?php echo $user->id; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">HBCU</label>
                                <?php echo $user->datas; ?>
                                <select multiple name="hbcu[]" id="hbcu"  class="form-control">
                                    <?php foreach ($hbc as $key ) { ?>
                                    <option value="<?php echo $key->id; ?>"
                                        >
                                        <?php echo $key->title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="Organization">Organization</label>
                                    <select  name="organization" id="organization" class="organization form-control">
                                      <option value="0">-select-</option>
                                      <?php foreach ($org as $key ) {?>
                                      <option value="<?php echo $key->id; ?>"
                                        <?php echo "selected ='selected'"?>>
                                        <?php echo $key->title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">ProfilePic</label>
                                    <img src="" style="width:90px;height:auto;border-radius:50%" id="editProfile" />
                                    <input type="file" id="exampleInputFile3" name="profile">
                                </div>
                                <button type="submit" name="editUsers" id="FORM_ID"class="btn btn-default">Submit</button>
                                <!-- <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button> -->
            <!--                 </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  -->


        <div class="panel-body">
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Edit Donation Status</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="<?php echo base_url("Dashboard/edituserstatus");?>" enctype="multipart/form-data">
                            <div class="form-group labEL_width" id="spare1">
                                <label for="fullname"> Spare Change</label>
                                    <input type="checkbox"  name="spare" value="0"  id="title"  >
                          
                          
                               
                            </div>
                            <div class="form-group labEL_width" id="reoccur12">

                                <label for="exampleInputFile">Reoccuring Donation</label> 
                                <input type="checkbox" name="reoccur"   value="0" id="reoccur"  >
              
                          
                            
                            </div> 



                                <input type="hidden" class="form-control" id="hiddenVal" name="title">
                                <!-- <input type="submit" name="editUsers" id="FORM_ID" value="Submit" class="btn btn-default"> -->
                                <button type="submit" name="editUsers" id="FORM_ID" Value="Submit" class="btn SUbmit_BUton">Submit</button>
                            
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</section>
<!-- <script type="text/javascript">
$('#myModal').on('show.bs.modal', function(e) {

    var userid = $(e.relatedTarget).data('userid');
    var fullname = $(e.relatedTarget).data('fullname');
    var email = $(e.relatedTarget).data('email');
    var hbcu = $(e.relatedTarget).data('hbcu');
    var organization = $(e.relatedTarget).data('organization');
     var profile = $(e.relatedTarget).data('profile');



    // var dg = [<?php echo '"'.implode(',', $sk).'"' ?>];
   var df = [hbcu];
   var hb = [];
   if(typeof df[0]  == 'string'){
    hb = df[0].split(',');
   }else{
    hb = df;
   }

document.getElementById('hiddenVal').value = userid;
document.getElementById('fullname').value = fullname;
document.getElementById('email').value = email;
$('#editProfile').attr('src',profile);  
// document.getElementById('hbcu').value = hbcu;

if(organization>0)
{
document.getElementById('organization').value = organization;
}else
{
document.getElementById('organization').value = 0;
}

 $('#hbcu').val(hb);
});
</script> -->
<!-- <script type="text/javascript">
$('#myModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('userid');
    var spare = $(e.relatedTarget).data('spare');
     var reoccur1 = $(e.relatedTarget).data('reoccur');

     if (spare==1) {
         // document.getElementById('title').value = spare;
         $("#title").attr("checked", true);
     }
     else if (spare==0) {
        // $('#spare1').hide();
           $("#title").attr("disabled", true);

     }
     else{
        // $('#spare1').hide();
           $("#title").attr("disabled", true);

     }


    if (reoccur1==1) {
        // document.getElementById('reoccur').value = reoccur1;
           $("#reoccur").attr("checked", true);
     }
     else if (reoccur1==0 ||    reoccur1==null || reoccur1=='') {
         $("#reoccur").attr("disabled", true);
     }
     else{
         $("#reoccur").attr("disabled", true);
     }


document.getElementById('hiddenVal').value = userid;

});
</script> -->

       <script type="text/javascript">

            $('.delete').click(function(event){

                  $('#title').attr('checked', false); 
                  $('#reoccur').attr('checked', false); 
                  $("#title").attr("disabled", true);
                  $("#reoccur").attr("disabled", true);

               // event.preventDefault();


              var id = $(this).attr("id");
                 // $("#myModal").html("");
                      // $('#title').empty();
                      //      $('#reoccur').empty();
                      //      $('input:checkbox').removeAttr('checked');


               $('#myModal').modal('show');
                  // $('#title').attr('checked', false); 
                  // $('#reoccur').attr('checked', false); 
                  // $('#myCheckbox').attr('checked', false);


              $.ajax({type: "POST",url:"<?php echo base_url("Dashboard/getuserdetail")?>",data:{id:id}}).done(function(data){
                var abc=JSON.parse(data);

                // console.log(abc.isActivesparechange.isActivesparechange);
                // console.log(abc);
                // console.log(abc.reoccur);


                var a=abc.isActivesparechange.isActivesparechange;
                var b=abc.reoccur;


                // console.log(a);
                // console.log(b);
                 // $('#title').attr('checked', false); 
                 //  $('#reoccur').attr('checked', false); 
                 //  $("#title").attr("disabled", true);
                 //  $("#reoccur").attr("disabled", true);






 
    
                    if (a==1 || a=='1') {
                      $("#title").attr("checked", false);
                        $("#title").attr("disabled", false);

                        $('#title').bootstrapToggle({
                        on: 'Disabled',
                        off: 'Enabled'
                        });

                        // $('.toggle-on').removeClass('btn-default');
                        // $('.toggle-on').removeClass('off');
                        // $( ".toggle-on" ).addClass( "btn-primary" );
                        
               document.getElementById("FORM_ID").disabled = false;   

         
                    }
                    else if (a=='0' || a==0) {
                        $("#title").attr("disabled", true);
                    document.getElementById("FORM_ID").disabled = false;

                        $('#title').bootstrapToggle({
                        on: 'Enabled',
                        off: 'Disabled'
                        });


        
                    }
                 

                    if (b==1 || b=='1') {
                      $("#reoccur").attr("checked", false);
                      $("#reoccur").attr("disabled", false);

                       $('#reoccur').bootstrapToggle({
                        on: 'Disabled',
                        off: 'Enabled'
                        });


                       document.getElementById("FORM_ID").disabled = false;   
            
                    }
                    else if (b==0 || b==3 || b=='0' || b=='3' ) {
                       $("#reoccur").attr("disabled", true);
                       document.getElementById("FORM_ID").disabled = false;  

                      $('#reoccur').bootstrapToggle({
                        on: 'Enabled',
                        off: 'Disabled'
                        });

                      // $('#reoccur').attr('checked', true); 
                
                  
                    }
                
                    document.getElementById('hiddenVal').value = id;

                    if((a=='0' || a==0 )&& (b==0 || b==3 || b=='0' || b=='3'))
                     {

                      document.getElementById("FORM_ID").disabled = true;
                        //     $('#title').bootstrapToggle({
                        // on: 'Enabled',
                        // off: 'Disabled'
                        // });    
                        //    $('#reoccur').bootstrapToggle({
                        // on: 'Enabled',
                        // off: 'Disabled'
                        // });
                           
                     }
                        
                    });
              event.preventDefault();


  // event.preventDefault();


       
     });

$('#myModal').on('hidden.bs.modal', function(e) {
  $("#myModal .modal-body").find('input:radio, input:checkbox').prop('checked', false);
  // $("#title,#reoccur").prop('checked', false).change();
  $('#title').bootstrapToggle('destroy');
  $('#reoccur').bootstrapToggle('destroy')
})


    </script>


<!--     <script type="text/javascript">
    $('.submit').click(function () {
        var self = $('input[type="radio"]:checked');
        var selValue = $('input[name=type]:checked').val();
        // console.log(selValue);
        // console.log(self);
        // return false;
        if (selValue==2) {
          var abc=$('#no_of_days').val();
          // alert(abc);
          // return false;

          if (abc<2) { 
          $("#va").show(); 
           return false; 
          }
      }
    });
</script> -->


<!-- <script>
  $(function() {
    $('#title').bootstrapToggle();
  })
</script> -->