<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php $this->load->view('admin/application/bootstrap') ?>
  <meta charset="utf-8">
  <title>Admin: NGOs</title>
</head>
<body>
  <header>
    <div  id="admin" class="container-fluid">
      <div><h1>Admin Mark</h1></div>
    </div>

    <div class="container-fluid">
      <ul class="nav justify-content-end">
        <li class="nav-item"><a class="nav-link platform" href="#">Platform</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Log Out</a></li>
      </ul>
    </div> 
  </header>

  <div class="container-fluid">
    <div class="row">
      <section id="sidebar" class="col-md-3">
        <?php $this->load->view('admin/application/sidebar_menu') ?>
      </section>

      <section id="main" class="col-md-9">
        <div><h1>List of NGO's</h1></div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">NGO Name</th>
              <th scope="col">Contact Email</th>
              <th scope="col">Contact Person</th>
              <th scope="col">NGO Username</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Red Cross</td>
              <td>info@redcross.com</td>
              <td>Maria Santiago</td>
              <td>mariaredcross</td>

              <td>
                
                <a href="/admin/ngos/view/1<?php // echo $ngo['id'] ?>" class="btn btn-link">View</a>
                <a href="/admin/ngos/delete/1<?php // echo $ngo['id'] ?>" class="btn btn-link">Delete</a>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>
  </div>
</body>
</html>
