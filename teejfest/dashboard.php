<?php require_once "inc/admin.php"; ?>
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
                        Dashboard
                        <small>Panel</small>
                    </h1>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        Manage
                                    </h3>
                                    <p>
                                        Menu
                                    </p>
                                </div>
                                
                                <a href="<?php echo 'menu_list.php';?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
        <?php require_once 'inc/footer.php'; ?>
    </body>
</html>