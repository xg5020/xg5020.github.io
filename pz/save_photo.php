<?php
if (isset($_POST['image'])) {
    // 解码base64图像数据
    $imageData = $_POST['image'];
    $filteredData = explode(',', $imageData);
    $unencodedData = base64_decode($filteredData[1]);
    
    // 生成唯一的文件名：精确到秒的日期转换成的md5数值.png
    $filename = 'uploads/' . date('YmdHis') . '.png';
    
    // 保存图像文件
    file_put_contents($filename, $unencodedData);
    
    echo '照片保存成功';
} else {
    echo '未收到图像数据';
}
?>
