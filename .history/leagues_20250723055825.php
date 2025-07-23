
<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Leagues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Leagues</li>

            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- /.card -->

            <div class="card ">
              <div class="card-header d-flex justify-content-between align-items-start">
                <h3 class="card-title mb-0">KHF Leagues</h3>

                <button type="button"
                  class="btn btn-primary btn-md mt-1"
                  data-toggle="modal"
                  data-target="#add-league-modal">
                  Add League
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

                  <thead>
                  <tr>
                    <th>#</th>
                    <th>League Name</th>
                    <th>League Desc</th>
                    <th>League Status</th>
                    <th>Gender</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    include_once 'includes/functions.php';

                            $query = "SELECT * FROM leagues ORDER BY createdAT DESC";

                            $params = [];

                            $leagues = readQuery($conn, $query, $params);
                            $i = 1;
                            if ($leagues) {
                                foreach ($leagues as $league) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($league['leagueName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($league['leagueDesc']) . "</td>";
                                    if ($league['leagueStatus'] == 'Active') {
                                      echo "<td class='text-center text-succes'><span class='badge badge-sm bg-gradient-success'>".$league['leagueStatus']."</span></td>";
                                    } else {
                                      echo "<td class='text-center text-danger'><span class='badge badge-sm bg-gradient-danger'>".$league['leagueStatus']."</span></td>";
                                    }
                                    echo "<td>" . htmlspecialchars($league['leagueGender']) . "</td>";
                                    echo "<td>" . htmlspecialchars($league['createdBy']) . "</td>";
                                    echo "<td>" . htmlspecialchars($league['updatedBy']) . "</td>";?>

                                    <td>
                                      <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-md " data-toggle="modal" data-target="#edit-league-modal" data-id="<?php echo $league['insertID']; ?>">
                                          Edit League
                                        </button>
                                        <form action="allforms.php" method="POST" class="d-inline">
                                          <input type="hidden" name="formName" value="deleteLeague">
                                          <input type="hidden" name="insertID" value="<?php echo $league['insertID']; ?>">
                                          <button type="submit" class="btn btn-danger btn-md">Delete</button>
                                        </form>
                                      </div>
                                    </td>
                                    <?php
                                    echo "<td>" . htmlspecialchars($league['updatedBy']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No leagues found</td></tr>";
                            }
                            $conn = null; // Close the database connection
                  ?>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>League Name</th>
                    <th>League Desc</th>
                    <th>LeagueStatus</th>
                    <th>Gender</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'includes/footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<div class="modal fade" id="add-league-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add League</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="allforms.php" method="POST">
                <input type="hidden" name="formName" value="addLeague">
                <div class="card-body">
                  <div class="form-group">
                    <label for="leagueName">League Name</label>
                    <input type="text" class="form-control" name = "leagueName" id="leagueName" placeholder="KHF 205/2026">
                  </div>
                  <div class="form-group">
                    <label for="leagueDesc">League Description</label>
                    <input type="text" class="form-control" id="leagueDesc"name = "leagueDesc" placeholder="Mens National Handball League">
                  </div>
                  <div class="form-group">
                    <label for="leagueGender">League Gender</label>
                    <select class="form-control" name="leagueGender" id="leagueGender">
                      <option selected disabled>Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="leagueYear">League Year</label>
                    <select class="form-control" name="leagueYear" id="leagueYear">
                      <option selected disabled>Select Year</option>
                      <?php
                        $currentYear = date('Y');
                        for ($year = $currentYear - 1; $year <= $currentYear + 3; $year++) {
                            echo "<option value=\"$year\">$year</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edit-league-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit League</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="allforms.php" method="POST">
                <input type="hidden" name="formName" value="addLeague">
                <div class="card-body">
                  <div class="form-group">
                    <label for="leagueName">League Name</label>
                    <input type="text" class="form-control" name = "leagueName" id="leagueName" placeholder="KHF 205/2026">
                  </div>
                  <div class="form-group">
                    <label for="leagueDesc">League Description</label>
                    <input type="text" class="form-control" id="leagueDesc"name = "leagueDesc" placeholder="Mens National Handball League">
                  </div>
                  <div class="form-group">
                    <label for="leagueGender">League Gender</label>
                    <select class="form-control" name="leagueGender" id="leagueGender">
                      <option selected disabled>Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="leagueYear">League Year</label>
                    <select class="form-control" name="leagueYear" id="leagueYear">
                      <option selected disabled>Select Year</option>
                      <?php
                        $currentYear = date('Y');
                        for ($year = $currentYear - 1; $year <= $currentYear + 3; $year++) {
                            echo "<option value=\"$year\">$year</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php include 'includes/corejs.php'; ?>



<!-- Page specific script -->
<script>
  $(function () {
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": true, // ✅ Enables "Show entries" dropdown
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#example2').DataTable({
    "paging": true,
    "lengthChange": true, // ✅ You can enable it here too if needed
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true
  });
});

</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    if (params.has("success")) {
      toastr.success(params.get("success"), "Success", { timeOut: 3000 });
    }

    if (params.has("error")) {
      toastr.error(params.get("error"), "Error", { timeOut: 3000 });
    }
  });
</script>
</body>
</html>
