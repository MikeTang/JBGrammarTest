<div class="content2">
     <div class="row mt40">
          <div class="col-xs-12">
                    <div class="row">
                         <div class="col-xs-12 t_c">
                              <p class="sub_title">Welcome to</p>
                              <h1 class="main_title"><?php echo TITLE;?></h1>
                         </div>
                         <!-- <div class="col-xs-12">
                              
                              <ul class="nav nav-pills">
                                   <li class="active"><a href="#">Login</a></li>
                                   <li><a href="#">Signup</a></li>
                              </ul>
                              
                         </div> -->
                    </div>

                    <div class="row mt40">
                         <div class="col-xs-12">
                         <?php 
                         $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
                         echo form_open("signup/index", $attributes);?>

                         <fieldset>
                              <div class="input-group">
                                   <span class="input-group-addon input_label" id="basic-addon1">Phone Number</span>
                                   <input class="form-control" id="txt_phone" name="txt_phone" placeholder="" type="text" value="" aria-describedby="basic-addon1">
                                   <span class="text-danger"><?php echo form_error('txt_phone'); ?></span>
                                   <div class="input-group-addon">
                                        <a class="btn btn-default btn-code">Get Code</a>
                                   </div>
                                   
                              </div>

                              <div class="input-group mt10">
                                   <span class="input-group-addon input_label" id="basic-addon1">Validation Code</span>
                                   <input class="form-control" id="txt_phoneCode" name="txt_phoneCode" placeholder="" type="text" value="" aria-describedby="basic-addon1">
                                   <span class="text-danger"><?php echo form_error('txt_phoneCode'); ?></span>
                              </div>

                              <div class="input-group mt10">
                                   <span class="input-group-addon input_label" id="basic-addon1">Password</span>
                                   <input class="form-control" id="txt_password" name="txt_password" placeholder="" type="password" value="" aria-describedby="basic-addon1">
                                   <span class="text-danger"><?php echo form_error('txt_password'); ?></span>
                              </div>

                              <div class="input-group mt10">
                                   <span class="input-group-addon input_label" id="basic-addon1">Repeat Password</span>
                                   <input class="form-control" id="txt_rpassword" name="txt_rpassword" placeholder="" type="password" value="" aria-describedby="basic-addon1">
                                   <span class="text-danger"><?php echo form_error('txt_rpassword'); ?></span>
                              </div>

                             
                             
                             

                              <div class="form-group mt20">
                                   <div class="col-lg-12 col-sm-12 t_c">
                                        <input id="btn_signup" name="btn_signup" type="submit" class="btn btn-default t_c green_button transition" value="Sign Up" />
                                   </div>
                              </div>
                         </fieldset>

                         <?php echo form_close(); ?>
                         <?php echo $this->session->flashdata('msg'); ?>
                         </div>
                    </div>
               </div>
          </div>
</div>

<script>
     var getCodeURL = "<?php echo site_url('signup/getValidationCode'); ?>"; 
</script>
