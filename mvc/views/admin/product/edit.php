<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chỉnh sửa sản phẩm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo URL.'Product';?>">Sản phẩm</a></li>
              <li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Cài đặt</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="formProduct" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['row']['name']; ?>">
                </div>

                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" id="link" name="link" value="<?php echo $data['row']['link']; ?>">
                </div>

                <div class="form-group">
                    <label for="id_category">Danh mục</label>
                    <select name="id_category" id="id_category" class="form-control">
                      <option value="0">--Chọn--</option>
                      <?php echo $data['category']; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" class="form-control" name="content" id="content" rows="3"><?php echo $data['row']['content']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="img">Ảnh đại diện</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img" id="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                    <br>
                    <p>
                      <img src="<?php echo URL.'uploads/products/'.$data['row']['img']; ?>" width="100">
                    </p>
                </div>

                <?php
                  // Kiểm tra status
                  ($data['row']['status']==1)?$checked='checked':$checked='';
                ?>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="status" id="status" <?php echo $checked; ?>>
                    <label class="form-check-label" for="status">Hiển thị</label>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </div>
            </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>