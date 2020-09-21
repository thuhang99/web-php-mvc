<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- ckeditor -->
<script src="ckeditor/ckeditor.js"></script>
<script>CKEDITOR.replace('content');</script>

<!-- link ảnh -->
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

<!-- Change name to link -->
<script>
function ChangeToSlug()
{
  var title, slug;

  //Lấy text từ thẻ input title 
  title = document.getElementById("name").value;

  //Đổi chữ hoa thành chữ thường
  slug = title.toLowerCase();

  //Đổi ký tự có dấu thành không dấu
  slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
  slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
  slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
  slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
  slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
  slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
  slug = slug.replace(/đ/gi, 'd');
  //Xóa các ký tự đặt biệt
  slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
  //Đổi khoảng trắng thành ký tự gạch ngang
  slug = slug.replace(/ /gi, "-");
  //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
  //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
  slug = slug.replace(/\-\-\-\-\-/gi, '-');
  slug = slug.replace(/\-\-\-\-/gi, '-');
  slug = slug.replace(/\-\-\-/gi, '-');
  slug = slug.replace(/\-\-/gi, '-');
  //Xóa các ký tự gạch ngang ở đầu và cuối
  slug = '@' + slug + '@';
  slug = slug.replace(/\@\-|\-\@|\@/gi, '');
  //In slug ra textbox có id “slug”
  document.getElementById('link').value = slug;
}
</script>

<!-- Kiểm tra dữ liệu bảng product -->
<script>
  <?php
    $url = $_GET['url'];
    $url = explode('/', $url);

    if($url[0]=='Product'){
      if( isset($url[1]) ){
        if($url[1]!=''){
  ?>
  $(document).ready(function(){
    $('#formProduct').on('submit', function(e){
      // Tắt load lại trang, chặn submit
      e.preventDefault();
      // Khai báo biến
      var name, link, content, img, status, flag=1, err='';
      // Lấy dữ liệu
      name = $('#name').val();
      link = $('#link').val();
      img = $('#img').val();
      // Sửa lại
      status = $('#status').prop("checked");
      // Kiểm tra dữ liệu
      
      // Kiểm tra Tên
      // if(name.length > 10){
      //   flag=0;
      //   err+='Tên sản phẩm vượt quá số kí tự quy định,';
      // }

      // Kiểm tra Link
      // if(link.length > 10){
      //   flag=0;
      //   err+='Link sản phẩm vượt quá số kí tự quy định';
      // }

      // Lấy dữ liệu nội dung trong ckeditor
      content = CKEDITOR.instances['content'].getData() 
      // alert(content);

      var form = new FormData(this);
      form.append('content', content);
      // chỉnh sửa status
      (status==true) ? status=1: status=0;
      // thêm status
      form.append('status', status);

      // thêm id
      form.append('id', <?php echo (isset($url[2])) ? $url[2]:0; ?>);

      // KẾT QUẢ
      if(flag==1){
        // Gửi ajax qua back-end xử lý
        // alert('ok');
        $.ajax({
          // Đường dẫn đến nơi xử lý
          url: '<?php echo URL; ?>Product/process_<?php echo $url[1]; ?>',
          // Phương thức gửi đi
          type: 'POST',
          // Dữ liệu gửi đi
          data: form,
          // 3 thông số bắt buộc để back-end nhận được dữ liệu khi new FormData(this)
          contentType: false,
          cache: false,
          processData: false,
          // Kết quả trả về từ back-end
          success: function(rs){
            if(rs=='ok'){
              window.location.href = '<?php echo URL; ?>Product';
            }else if(rs=='ok-update'){
              alert('Đã cập nhật thành công');
            }else{
              alert(rs);
            }
            //console.log(rs);
          }
        });
        // Thực hiện xong dừng luôn
        return false;
      }else{
        // Báo lỗi
        alert(err);
      }

    });
  });
  <?php }}} ?>

  function xoa_ngay(id)
  {
    // xóa dòng trên bảng
    $('#del_'+id).remove();
    //alert(id);
    $.ajax({
      url: '<?php echo URL.'Product/delete'; ?>',
      type: 'POST',
      data: {
        'id' : id
      },
      success: function(result){
        alert(result);
      }
    });
    return false;
  }

</script>