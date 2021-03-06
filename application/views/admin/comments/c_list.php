<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php $this->load->view('admin/application/bootstrap') ?>
  <meta charset="utf-8">
  <title>Admin: Comments</title>
</head>
<body>
<?php $this->load->view('admin/application/header') ?>

  <div class="container-fluid">
    <div class="row">
      <section id="sidebar" class="col-md-2">
        <?php $this->load->view('admin/application/sidebar_menu') ?>
      </section>

      <section id="main" class="col-md-10">
        <div><h1>List of Comments</h1></div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#ID</th>
              <th scope="col">Comment</th>
              <th scope="col">Name</th>
              <th scope="col">Created</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php foreach($data as $item){ ?>
              <th scope="row"><?= $item['c_id']?></th>
              <td><?= $item['c_content']?></td>
              <td><?= $item['name']?></td>
              <td><?= $item['created_at']?></td>
              <td>
                <form method="post" action="/admin/comment/delete">
                  <input type="hidden" name="c_id" value="<?= $item['c_id']; ?>">
                  <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                </form>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </section>
    </div>
  </div>
</div>
</body>
</html>
