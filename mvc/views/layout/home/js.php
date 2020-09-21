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