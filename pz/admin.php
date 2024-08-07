<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>文件上传工具</title>
        <!-- 引入 Bootstrap CSS -->    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">    <!-- 引入 Bootstrap Bundle 包含 Popper.js 和 Bootstrap JS -->    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>    <!-- 如果你需要使用jQuery，也可以引入 -->    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- 引入 Font Awesome 图标库 -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px; /* 顶部留出空间 */
        }
        .file-list {
            margin-top: 20px;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width: 768px) {
            .file-list {
                margin-top: 40px;
            }
            .list-group-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            .list-group-item span {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="file-list">
            <h2 class="text-center mt-4">文件列表</h2>
            <ul class="list-group mt-3">
                <?php
                $uploadDirectory = 'uploads/';
                $files = scandir($uploadDirectory);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        echo '<li class="list-group-item">';
                        echo $file;
                        echo '<span>';
                        echo '<a href="download.php?file=' . urlencode($file) . '" class="btn btn-sm btn-primary me-2"><i class="fas fa-download"></i> 下载</a>';
                        echo '<button class="btn btn-sm btn-info" onclick="copyLink(\'' . urlencode($file) . '\')"><i class="fas fa-copy"></i> 复制链接</button>';
                        echo '</span>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- 图片预览模态框 -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">图片预览</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="previewImage" class="img-fluid" alt="预览图片">
                </div>
            </div>
        </div>
    </div>

    <script>
        // 复制链接模态框
        function copyLink(filename) {
            var copyText = window.location.origin + '/file/download.php?file=' + encodeURIComponent(filename);
            var modalHtml = `
                <div class="modal fade" id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="copyModalLabel">复制链接</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>已复制文件链接：<br><code>${copyText}</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(modalHtml); // 添加模态框 HTML 到页面中
            $('#copyModal').modal('show'); // 显示模态框
            navigator.clipboard.writeText(copyText); // 复制链接到剪贴板
        }

        // 图片预览模态框
        function previewImage() {
            var fileInput = document.getElementById('file');
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#previewModal').modal('show');
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

</body>
</html>
