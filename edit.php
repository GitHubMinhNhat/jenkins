<?php
    $open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php";

    $id = intval(getInput('id'));
    $Editadmin = $db->fetchID("admin" ,$id);

    $sql = "select * from permission";
    $select_permission = mysqli_query($con,$sql);

    if(empty($Editadmin))
    {
        $_SESSION['error'] ="Dữ liệu không tồn tại";
        redirectAdmin("admin");
    }

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        
        $data =
        [
            "name" => postInput('name'),
            "email" => postInput("email"),
            "phone" => postInput("phone"),
            "password" => MD5(postInput("password")),
            "address" => postInput("address"),
            "level" => postInput("level"),
        ];
        $error=[];
        if(postInput('name')=='')
        {
            $error['name']="Vui lòng nhập tên đầy đủ";
        }
        if(postInput('email')=='')
        {
            $error['email']="Vui lòng nhập email";
        }
        else
        {
            if(postInput("email") != $Editadmin['email'])
            {
                $is_check = $db->fetchOne("admin","email='".$data['email']."' ");
                if($is_check!=NULL)
                {
                    $error['email']="Email đã tồn tại";
                }
            }
        }
        if(postInput('phone')=='')
        {
            $error['phone']="Vui lòng nhập số điện thoại";
        }

        if(postInput('address')=='')
        {
            $error['address']="Vui lòng nhập địa chỉ";
        }
        if(postInput('level')=='')
        {
            $error['level']="Vui lòng nhập cấp độ";
        }
        if($data['password']!= MD5(postInput("re_password")))
        {
            $error['re_password']="Mật khẩu không chính xác";
        }
        if(postInput('password')!=NULL && postInput("re_password") != NULL)
        {
            if(postInput('password')!=postInput('re_password'))
            {
                $error['re_password']="mật khẩu không đúng";
            }
            else
            {
                $data['password']=MD5(postInput('password'));
            }
        }
        if(! isset($_FILES['avatar']))
        {
            $error['avatar']="Vui lòng chọn hình ảnh đại diện";
        }
        //The blank is not necessarily faulty
        if(empty($error))
        {
            if(isset($_FILES['avatar']))
            {
                $file_name = $_FILES['avatar']['name'];
                $file_tmp = $_FILES['avatar']['tmp_name'];
                $file_type = $_FILES['avatar']['type'];
                $file_erro = $_FILES['avatar']['error'];

                if($file_erro == 0)
                {
                    $part = ROOT ."avatar/";
                    $data['avatar'] = $file_name;
                }
            }
            $id_update =$db->update("admin",$data,array("id"=>$id));
            if($id_update>0)
            {
                move_uploaded_file($file_tmp,$part.$file_name);
                $_SESSION['success']="Cập nhật quản trị thành công!";
                redirectAdmin("admin");
            }
            else
            {
                $_SESSION['error']="Cập nhật quản trị KHÔNG thành công!";
                redirectAdmin("admin");
            }
            
        }
    }
?>
<?php require_once __DIR__. "/../../layouts/header.php" ;?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật quản trị viên</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Bảng điều khiển</a></li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Cập nhật quản trị viên</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Notification Error -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-folder-plus mr-1"></i>
            <b> Cập nhật quản trị viên</b>
        </div>
        <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Họ và tên</b></label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="inputEmail3" placeholder="Nguyễn Văn A" name="name" value="<?php echo $Editadmin['name'] ?>">
                    <?php if(isset($error['name'])):?>
                        <p class="text-danger">  <?php echo $error['name'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Hình</b></label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" id="inputEmail3" placeholder="15%" name="avatar">
                    <?php if(isset($error['avatar'])):?>
                        <p class="text-danger">  <?php echo $error['avatar'] ?> </p>
                    <?php endif ?>
                    <img style="margin-top: 15px;" src="<?php echo uploads()?>avatar/<?php echo $Editadmin['avatar'] ?>" width="200px" height="200px">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Email</b></label>
                <div class="col-sm-8">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email@gmail.com" name="email" value="<?php echo $Editadmin['email'] ?>">
                    <?php if(isset($error['email'])):?>
                        <p class="text-danger">  <?php echo $error['email'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Số điện thoại</b></label>
                <div class="col-sm-8">
                <input type="number" class="form-control" id="inputEmail3" placeholder="099666999" name="phone" value="<?php echo $Editadmin['phone'] ?>">
                    <?php if(isset($error['phone'])):?>
                        <p class="text-danger">  <?php echo $error['phone'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mật khẩu</b></label>
                <div class="col-sm-8">
                <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="password" value="<?php echo $Editadmin['password'] ?>">
                    <?php if(isset($error['password'])):?>
                        <p class="text-danger">  <?php echo $error['password'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Nhập lại mật khẩu</b></label>
                <div class="col-sm-8">
                <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="re_password" value="<?php echo $Editadmin['password'] ?>" >
                    <?php if(isset($error['re_password'])):?>
                        <p class="text-danger">  <?php echo $error['re_password'] ?> </p>
                    <?php endif ?>
                </div>
            </div> 
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Địa chỉ</b></label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="inputEmail3" placeholder="Khu phố X - Phường Y - Quận Z - TP HCM" name="address" value="<?php echo $Editadmin['address'] ?>">
                    <?php if(isset($error['address'])):?>
                        <p class="text-danger">  <?php echo $error['address'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Cấp Độ</b></label>
                <div class="col-sm-8">
                    <select class="form-control" name="level">
                        <?php foreach ($select_permission as $item): ?>
                            <option value="<?php echo $item['id'] ?>" <?php echo $Editadmin['level'] == $item['id'] ? "selected='selected'":''?> > <?php echo $item['name'] ?> </option>
                        <?php endforeach ?>
                    </select> 
                    <?php if(isset($error['level'])):?>
                        <p class="text-danger">  <?php echo $error['level'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-md-2 col-sm-8">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
</main>
<?php require_once __DIR__. "/../../layouts/footer.php" ;?>