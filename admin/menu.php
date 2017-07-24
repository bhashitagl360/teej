<?php 
    require_once "inc/admin.php"; 

    $id = '0';
    if( isset( $_REQUEST['id'] ) &&  !empty( $_REQUEST['id'] ) ) {
        $id = $_REQUEST['id'];
    }

    if( !empty( $id ) ) {
        $menuQuery = "SELECT name, position FROM menu WHERE id=?";
        if ($menu = $mysqli->prepare($menuQuery)) {

            /* bind param */
            $menu->bind_param("i", $id);

            /* execute query */
            $menu->execute();

            /* store result */
            $menu->store_result();

            /* Get the number of rows */
            $num_of_rows = $menu->num_rows;

            /* Bind the result to variables */
            $menu->bind_result($name, $position);

            $menu_results = array();

            if ($num_of_rows >= "1") { 
                while ($menu->fetch()) {
                    $menu_results[] = $name;
                    $menu_results[] = $position;
                }
            }
            
            /* free results */
            $menu->free_result();

        }
    }


   // print '<pre>'; print_r($menu_results);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = array();


        if ( trim( strip_tags( stripslashes( $_POST['menu_name'] ) ) ) == '' ) {
          $errors[] = array("status"=>0, "id"=>"menu_name", "message"=>"Please enter menu name");
        }

        if ( !empty( $_POST['menu_name'] ) &&  !preg_match('/^[a-zA-Z ]*$/', $_POST['menu_name'])) { 
          $errors[] = array("status"=>0, "id"=>"menu_name", "message"=>"Please enter valid name");
        }

        if ( trim( strip_tags( stripslashes($_POST['menu_position'] ) ) ) == '' ) {
          $errors[] = array("status"=>0, "id"=>"menu_position", "message"=>"Please choose position");
        }

        //print '<pre>'; print_r($errors);die;

        if ( count($errors) > 0) {
            $_SESSION['errors'] = $errors;
        } else {

            

            $slug = str_replace(' ', '_', strtolower( $_POST['menu_name'] ) );
            $created_by = $_POST['menu_created_by'];

            if( isset( $_POST['menu_id'] ) && $_POST['menu_id'] > 0 ) {
                $menuSqlQuery="UPDATE menu SET name=?, slug=?, position=?, created_by=? WHERE id=?";
                $upload = $mysqli->prepare($menuSqlQuery);
                if($upload === false) {
                    die('Wrong Menu Update SQL: ' . $menuSqlQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
                }
                $upload->bind_param("ssiii", $_POST['menu_name'], $slug, $_POST['menu_position'], $created_by, $_POST['menu_id']);
                $upload->execute();

                //echo "<script>alert('Menu is successfully updated!');</script>";
                 $_SESSION["msg"]='Menu is successfully updated!';
                header("location: menu_list.php");
                exit;
            } else {
                $menuSqlQuery="INSERT INTO menu (name, slug, position, created_by) VALUES (?, ?, ?, ?)";
                $upload = $mysqli->prepare($menuSqlQuery);
                if($upload === false) {
                    die('Wrong Menu Insert SQL: ' . $sql . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
                }
                $upload->bind_param("ssii", $_POST['menu_name'], $slug, $_POST['menu_position'], $created_by);
                $upload->execute();

                //echo "<script>alert('Menu is successfully added!');</script>";
                 $_SESSION["msg"]='Menu is successfully updated!';
                header("location: menu_list.php");
                exit;
            }
        }
    }
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
                        Manage
                        <small>Menu</small>
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <?php

                            
                            if( isset( $_SESSION['errors'] ) && !empty( $_SESSION["errors"] ) ){
                                for( $e=0; $e<count( $_SESSION['errors'] ); $e++){
                                    echo '<ul>';
                                        echo '<li>';    
                                            echo $_SESSION['errors'][$e]['message'];
                                        echo '</li>';
                                    echo '</ul>';
                                    $_SESSION['errors']='';
                                }
                            }
                        ?>
                        <form name="manageMenu" method="post" onsubmit="return validation();">
                            <fieldset>
                                <div class="form-group" show-errors>
                                    <label class="control-label" for="name">Name</label>
                                    <input name="menu_name" type="text" value="<?php echo $menu_results[0]; ?>" id="menu_name" class="form-control" placeholder="Enter Menu Name" required />
                                </div>
                                <div class="form-group" show-errors>
                                    <label class="control-label" for="position">Position</label>
                                    <input name="menu_position" type="number" value="<?php echo $menu_results[1]; ?>" id="menu_position" class="form-control" placeholder="Enter Menu position" required />
                                </div>
                                <input name="menu_created_by" type="hidden" value="<?php echo $_SESSION['login_user']; ?>" id="menu_created_by" />
                                <input name="menu_id" type="hidden" value="<?php echo $id; ?>" id="menu_id" />
                                <div><?php echo $msg; ?></div>
                                <div class="panel-footer">
                                    <button class="btn btn-oval btn-info" type="submit">Save</button>
                                </div>
                            </fieldset>
                        </form>​
                    </div>
                </section>
            </aside>
        </div>
        <?php require_once 'inc/footer.php'; ?>
        <script type="text/javascript">
            function validation() { 
                return true;
            }
        </script>
    </body>
</html>
<?php
    //$menu->close();
    $mysqli->close();
?>