<?php $this->load->view('html_head', array('title' => 'Update profile')) ?>
<?php $this->load->view('header') ?>

  <div class="container">
    <?php $this->load->view('validation_errors') ?>

    <h2>Edit Engineer Profile</h2>

    <form method="POST" action="/user/engineer/profile/update"  enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group">
        <label for="form_name">Name:</label>
        <input  name="form_name"   type="text" class="form-control" id="form_name" aria-describedby="nameHelp" placeholder="Enter Name" value="<?php echo set_value('form_name') ?>">
      </div>



      <div class="form-group">
        <label for="form_contact_email">Email:</label>
        <input  name="form_email" type="text" class="form-control" id="form_email" placeholder="Enter Email" value="<?php echo set_value('form_email') ?>">
      </div>

      <div class="form-group">
        <label for="form_fields_activity">Fields of Expertise:</label>
        <input  name="form_fields_expertise" type="text" class="form-control" id="form_fields_activity" aria-describedby="form_fields_activityHelp" placeholder="Enter Field of Expertise" value="<?php echo set_value('form_fields_expertise') ?>">
      </div>

      <div class="form-group">
        <label for="">Linked In:</label>
        <input  name="form_linkedin" type="text" class="form-control" id="form_website" aria-describedby="form_linkedin_linkHelp" placeholder="Please enter your Linked In link" value="<?php echo set_value('form_linkedin') ?>">
      </div>
      <div class="form-group">
        <label for="form_username">Username:</label>
        <input  name="form_username" type="text" class="form-control" id="form_username" aria-describedby="form_usernameHelp" placeholder="Please choose Username" value="<?php echo set_value('form_username') ?>">
      </div>

      <div class="form-group">
        <label for="">About me:</label>
        <div>
        <textarea name="form_aboutme"><?php echo set_value('form_aboutme') ?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label for="form_photo">Photo</label>
        <div>
          <?php if($photo){ ?>
            <img src="/uploads/<?php echo $photo['file_name'] ?>" class="rounded" alt="..." width="200" height="200">
         <?php } ?>
 
        </div>
        <div>
          <input id="form_photo" type="file" name="form_photo" size="20">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>


  </div>


</body>
</html>