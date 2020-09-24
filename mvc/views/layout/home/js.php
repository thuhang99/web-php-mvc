<!-- Latest jQuery form server -->
<script src="https://code.jquery.com/jquery.min.js"></script>
    
<!-- Bootstrap JS form CDN -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- jQuery sticky menu -->
<script src="assets/layout/js/owl.carousel.min.js"></script>
<script src="assets/layout/js/jquery.sticky.js"></script>

<!-- jQuery easing -->
<script src="assets/layout/js/jquery.easing.1.3.min.js"></script>

<!-- Main Script -->
<script src="assets/layout/js/main.js"></script>

<!-- Slider -->
<script src="assets/layout/js/bxslider.min.js"></script>
<script src="assets/layout/js/script.slider.js"></script>

<script>
    function thanhtoan()
    {
        // Thông tin khách hàng
        var name, email, phone, address, province, dictrict, wards, flag=1;
        var err='';

        name=$('#name').val();
        email=$('#email').val();
        phone=$('#phone').val();
        address=$('#address').val();
        province=$('#province').val();
        dictrict=$('#dictrict').val();
        wards=$('#wards').val();

        if(phone=='')
        {
            err += 'Vui lòng nhập số điện thoại';
            flag=0;
        }

        // phương thức giao hàng
        var ptgh = document.getElementsByName("delivery");
        for(var i = 0; i < ptgh.length; i++){
            if(ptgh[i].checked==true)
            {
                var value_ptgh = ptgh[i].value;
            }
        }

        if(flag==1)
        {
            $.ajax({
                url: '<?php echo URL.'Layout/thanhtoan'; ?>',
                type: 'POST',
                data: {
                    'name' : name, 
                    'email': email, 
                    'phone': phone,
                    'address': address,
                    'province': province, 
                    'dictrict': dictrict,
                    'wards': wards,

                    // ptgh
                    'id_delivery': value_ptgh
                },
                success: function(result){
                    //if(result=='ok')
                    //{
                        //alert('Đã thanh toán thành công, nhân viên tư vấn sẽ liên hệ với bạn sau!');
                        // tự động chuyển trang
                        //window.location.href = '<?php echo URL; ?>';
                    //}
                    console.log(result);
                    //$('#'+table).html(result);
                }
            });
            return false;
        }
        else
        {
            alert(err);
        }
    }
    function area(table, status, name_where)
    {
        var id = $('#'+name_where).val();
        $.ajax({
            url: '<?php echo URL.'Layout/area'; ?>',
            type: 'POST',
            data: {
                'value_where' : id, 
                'table': table, 
                'status': status,
                'name_where': name_where
            },
            success: function(result){
                //alert(result);
                $('#'+table).html(result);
            }
        });
        return false;
        //alert(id);
    }
    function add_to_cart(id)
    {
        if(id==0 || id<0)
        {
            alert('Sản phẩm không tồn tại');
        }
        else
        {
            $.ajax({
                url: '<?php echo URL.'Layout/add_to_cart'; ?>',
                type: 'POST',
                data: {'id' : id},
                success: function(result){
                    //alert(result);
                    alert('Đã thêm vào giỏ');
                }
            });
            return false;
        }
    }
    function delete_cart(id)
    {
        if(id==0 || id<0)
        {
            alert('Sản phẩm không tồn tại');
        }
        else
        {
            //alert(id);
            $.ajax({
                url: '<?php echo URL.'Layout/delete_cart'; ?>',
                type: 'POST',
                data: {'id' : id},
                success: function(result){
                    //alert(result);
                    $('#tr_'+id).remove();
                }
            });
            return false;
        }
    }
    function updated_cart()
    {
        // lấy danh sách sản phẩm trong giỏ: 1. qty, 2. ID
        //alert(1);
        
        var k = '';
        
        // qty
        var input = document.getElementsByName('qty');
        // id
        var _id = document.getElementsByName('_id');
  
        for (var i = 0; i < input.length; i++) { 
            // qty
            var a = input[i];
            // id
            var b = _id[i];

            k += b.value +','+ a.value +'/';
        }

        // loại bỏ dấu / cuối
        k = k.substring(0, k.length-1);

        $.ajax({
            url: '<?php echo URL.'Layout/updated_cart'; ?>',
            type: 'POST',
            data: {'k' : k},
            success: function(result){
                alert('Đã cập nhật');
                //console.log(result);
                //$('#tr_'+id).remove();
            }
        });
        return false;
    }
</script>