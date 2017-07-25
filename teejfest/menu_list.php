<?php 
  require_once "inc/admin.php"; 

  if(isset($_GET['deletetrue'])) { 
    if($_GET['deletetrue'] == "true") { 
        $idIs = base64_decode( $_GET['DelId'] );
        $delete = $mysqli->prepare("DELETE FROM menu WHERE id = ?");
        $delete->bind_param('i',  $idIs);
        $delete->execute(); 
        $delete->close();
        if($upload === false) {
            $msg='Wrong Menu delete SQL: ' . $menuSqlQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error;
        } else {
            $msg="Sucessfully Delete the row!";
        }
    }
  }

  $menuQuery = "SELECT id, name, slug, position, created_by FROM menu";
  $result = $mysqli->query($menuQuery);
?>
<!DOCTYPE html>
<html>
    <?php require_once 'inc/meta.php'; ?>
    <body class="skin-blue">
        <?php require_once 'inc/header.php'; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
          <?php require_once 'inc/left-sidebar.php'; ?>
          <aside class="right-side">
                <section class="content-header">
                    <h1>
                        Manage Menu
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="javascript:void(0)">Manage Menu</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Menu Listing</h3>
                                    <?php
                                      if(  $_SESSION["msg"] !== '' ){
                                        echo '<p>'. $_SESSION["msg"].'</p>';
                                         $_SESSION["msg"]='';
                                      }

                                      if(  $msg !== '' ){
                                        echo '<p>'. $msg.'</p>';
                                         $msg='';
                                      }
                                    ?>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                  <?php if ($result->num_rows > 0) { ?>
                                  <table id="menu" class="table table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <th>Name</th>
                                          <th>Slug</th>
                                          <th>Position</th>
                                          <th>Author</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php while($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                          <td><?php echo $row['name']; ?></td>
                                          <td><?php echo $row['slug']; ?></td>
                                          <td><?php echo $row['position']; ?></td>
                                          <td><?php echo $row['created_by']; ?></td>
                                          <td>
                                            <a href="menu.php?id=<?php echo base64_encode( $row['id'] ); ?>">
                                              Update
                                            </a>
                                            |
                                            <a href="menu_list.php?DelId=<?php echo base64_encode( $row['id'] ); ?>&deletetrue=true" onClick="return askme();">
                                              Delete
                                            </a>
                                          </td>
                                        </tr>
                                        <?php } ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <th>Name</th>
                                          <th>Slug</th>
                                          <th>Position</th>
                                          <th>Author</th>
                                          <th>Action</th>
                                        </tr>
                                      </tfoot>
                                  </table>
                                  <?php } else {

                                    } ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside>  
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('#menu').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });

            function askme() {
              $ask=confirm("Are you sure to delete!");
              if($ask == true) {
                return true;
              } else { 
                return false; 
              }
            }
        </script>
    </body>
</html>