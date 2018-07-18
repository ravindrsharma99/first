<style type="text/css">
a.button_CLASS {
    background: #EC6459 none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    width: 70px;
    padding: 4px 8px;
}
</style>
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
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>HBCU</th>
                                            <th>Organization</th>
                                            <th>ProfilePic</th>
                                            <th>Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                                    foreach ($userData as $user) {?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->full_name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <!-- <td><?php echo $user->hbcu_title; ?></td> -->
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
                                        <td>
                                            <a href="#myModal" data-toggle="modal"
                                            data-userid="<?php echo $user->id; ?>"
                                            data-fullname="<?php echo $user->full_name; ?>"
                                            data-email="<?php echo $user->email; ?>"
                                            data-profile="<?php echo $userprofile; ?>"
                                            data-hbcu="<?php echo $hbcu_id; ?>"
                                            data-organization="<?php echo $user->organization; ?>"
                                            class="btn btn-primary">Edit</a>

                                            <a href="<?php echo base_url('Dashboard/deleteUser').'/'.$user->id.'?action=user_list'; ?>"  data-userid="<?php echo $user->id; ?>" name="delete" onclick="return confirm('Are You Sure?')" class="btn btn-danger">Delete</a>
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


    <div class="panel-body">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<script type="text/javascript">
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
</script>


