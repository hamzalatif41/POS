<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
        header('location:index.php');
    }else{
        if($_SESSION['role']=="Admin"){
          include_once'inc/header_all.php';
        }else{
            include_once'inc/header_all_operator.php';
        }
    }

    error_reporting(0);

    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE FROM tbl_product WHERE product_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Product Has Been Deleted", "info", {
            button: "Continue",
                });
            });
            </script>';
    }

?>
<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Product list</h3>
                <a href="add_product.php" class="btn btn-success btn-sm pull-right">Add product</a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Code</th>
                                <th>Capital</th>
                                <th>selling</th>
                                <th>stock</th>
                                <th>option</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * FROM tbl_product");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ;?></td>
                                <td><?php echo $row->product_name; ?></td>
                                <td><?php echo $row->product_code; ?></td>
                                <td>Rp <?php echo number_format($row->purchase_price);?></td>
                                <td>Rp <?php echo number_format($row->sell_price); ?></td>
                                <td> <?php if($row->stock=="0"){ ?>
                                <span class="label label-danger"><?php echo $row->stock; ?></span>
                                <?php }elseif($row->stock<=$row->min_stock){ ?>
                                <span class="label label-warning"><?php echo $row->stock; ?></span>
                                <?php }else{ ?>
                                <span class="label label-primary"><?php echo $row->stock; ?></span>
                                <?php } ?>
                                <span class="label label-default"><?php echo $row->product_satuan; ?></span>
                                </td>
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="product.php?id=<?php echo $row->product_id; ?>"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <a href="edit_product.php?id=<?php echo $row->product_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <a href="view_product.php?id=<?php echo $row->product_id; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myProduct').DataTable();
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>