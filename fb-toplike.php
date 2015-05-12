<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Dv4Biz">
<title>FB LIKE</title>
<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/yeti/bootstrap.min.css" rel="stylesheet">
<!-- <link href='//fonts.googleapis.com/css?family=Khand:700' rel='stylesheet' type='text/css'> -->
<link rel="author" href="https://plus.google.com/116213764471264380715">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="activities" class="container">
<div class="page-header">
    <h2>กิจกรรมกดไลค์ ร้านบ้านฟ้า</h2>
</div>
<div class="container-fluid">
    <table class="table table-stripe table-hover" id="example">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Time</th>
                <th>Name</th>
                <th>Like</th>
            </tr>
        </thead>
        <tbody>
<?php
/**
 * [$url เปลี่ยนเฉพาะตัวเลข เป็นเลข id บน facebook ของ user หรือ page ที่ต้องการนำอัลบั้มมาแสดงผล]
 * [$obj ดังข้อมูลมาจาก graphAPI ของ facebook รูปแบบข้อมูลจะเป็น JSON]
 * [$ng ตัวแปรนับจำนวนอัลบั้ม เริ่มต้นจาก 0]
 * [$limit กำหนดให้แสดงกี่อัลบั้ม]
 */
    $url = "http://graph.facebook.com/1442498996018130?fields=photos.limit(100)";
    $obj = json_decode(file_get_contents($url));

    // echo '<pre>';
    // print_r($obj);
    // echo '</pre>';
    foreach($obj->photos->data as $item) {
        $name = (empty($item->name)) ? 'none' : $item->name;
        $date = strtotime('2014-07-24 00:00:00');
        $current = strtotime($item->created_time);

        if ($current > $date) {
            echo '
            <tr>
                <td class="col-sm-2"><a target="_blank" href="'.$item->link.'"><img src="'.$item->picture.'" class="img-responsive"></a></td>
                <td class="col-sm-2">'.date('j F \a\t H:i', strtotime($item->created_time)).'</td>
                <td class="col-sm-3">'.$name.'</td>
                <td class="col-sm-5 getlike" data-id="'.$item->id.'"><span id="like'.$item->id.'"></span></td>
            </tr>';
        }
    }

?>
        </tbody>
    </table>
</div>
</div>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
/**
 * FB-TopLike!
 * 2014 BaanPha
 * @MoreMeng : +Thanikul Sriuthis
 * Modified Date 2014-08-24 20:59:03
 */

$(function(){
    $('.getlike').each(function() {
        var id = $(this).attr('data-id');
        var phurl = "http://graph.facebook.com/"+ id +"?fields=likes.limit(0).summary(true)";

        $.getJSON(phurl, function (data) {
            // alert(JSON.stringify(data));
            var cn = data.likes.summary.total_count;
            if ( cn > 0 && cn < 11){
                pclass = 'info';
            } else if (cn > 10 && cn < 21) {
                pclass = 'default';
            } else if (cn > 20 && cn < 31) {
                pclass = 'success';
            } else if (cn > 30 && cn < 41) {
                pclass = 'warning';
            } else if (cn > 40) {
                pclass = 'danger';
            }

            $('#like'+id).append('<div class="progress"><div class="progress-bar progress-bar-'+pclass+'" role="progressbar" aria-valuenow="' + data.likes.summary.total_count + '" aria-valuemin="0" aria-valuemax="100" style="width: '+ data.likes.summary.total_count +'%;">    ' + data.likes.summary.total_count + '</div></div>');
        });
    });

    $('tr').dblclick(function(){
        $(this).hide();
    })
 });

</script>
</body>
</html>