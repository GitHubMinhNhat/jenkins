<?php
    $open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php";
    // $product = $db->fetchAll("product");
    if(isset($_GET['page']))
    {
        $p=$_GET['page'];
    }
    else
    {
        $p=1;
    }

    
    $sql = "select * from permission";
    $select_permission = mysqli_query($con,$sql);

    $sql ="SELECT admin. * FROM admin ORDER BY ID ASC ";

    $admin=$db->fetchJone('admin',$sql,$p,10,true);
    if(isset($admin['page']))
    {
        $sotrang=$admin['page'];
        unset($admin['page']);
    }
?>
<?php require_once __DIR__. "/../../layouts/header.php" ;?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Danh Sách Admin
            <a href="../../../admin/modules/admin/add.php" class="btn btn-success" style="visibility: <?php echo $_SESSION['Permission_create_pm'] == 1 ? 'visible':'hidden ';?>">Thêm Admin</a>
        </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url_admin() ?>">Bảng điều khiển</a></li>
            <li class="breadcrumb-item active" >Danh sách Admin</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Notification Error -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>

        <!-- <div class="card mb-4">
            <div class="card-body">
                <p class="mb-0"></p>
            </div>
        </div> -->
        <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            DataTable Admin
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th style="text-align: center;">Hình</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Chức vụ</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $Number = 1 ; foreach ($admin as $item): ?>
                            <tr>
                                <td><?php echo $Number ?></td>
                                <td><?php echo $item['name'] ?></td>
                                <td  style="text-align: center;">
                                    <?php if($item['avatar']=='') :?>
                                        <img src="<?php echo uploads()?>avatar/noavatar.png" width="70px" height="70px" style="border-radius: 50%;">
                                    <?php else :?>
                                        <img src="<?php echo uploads()?>avatar/<?php echo $item['avatar']?>" width="70px" height="70px" style="border-radius: 50%;">
                                    <?php endif ?>
                                </td>
                                <td><?php echo $item['email'] ?></td>
                                <td><?php echo $item['phone'] ?></td>
                                <td>
                                    <?php $lv = $item['level'] ?>
                                    <?php foreach ($select_permission as $item1): ?>
                                        <?php if($item['level'] == $item1['id'])
                                            {
                                                echo $item1['name'];
                                            }
                                        ?>
                                    <?php endforeach ?>
                                </td>
                                <td>
                                    <?php if($item['status'] == 1 ) :?>
                                        Hoạt động
                                    <?php else : ?>
                                        Ngưng hoạt động
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a <?php echo $_SESSION['Permission_edit_pm'] == 1 ? '':'onclick="return false" style=" opacity: 0.5; "';?> class="btn btn-xs btn-info" href="../../../admin/modules/admin/edit.php?id=<?php echo $item['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                    <a <?php echo $_SESSION['Permission_delete_pm'] == 1 ? '':'onclick="return false" style=" opacity: 0.5;"';?> class="btn btn-xs btn-danger" href="../../../admin/modules/admin/delete.php?id=<?php echo $item['id'] ?>"><i  class="fa fa-trash" ></i>
                            </tr>
                        <?php $Number++; endforeach ?>
                    </tbody>
                </table>
                <div class="pull-right" style="float: right;">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                            </li>
                            <?php for($i = 1 ; $i <= $sotrang ; $i++ ):?> 
                                <?php 
                                    if(isset($_GET['page']))
                                    {
                                        $p=$_GET['page'];
                                    }
                                    else
                                    {
                                        $p=1;
                                    }
                                ?>
                                <li class="page-item <?php echo ($i==$p) ?'active': '' ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>

                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<?php require_once __DIR__. "/../../layouts/footer.php" ;?>