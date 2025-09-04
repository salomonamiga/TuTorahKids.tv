<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php"); ?>
<title>Fotos - TuTorahKids.tv</title>

<head>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FancyBox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
    <!-- FancyBox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .gallery img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
        .gallery a.download-button {
            
        }
    </style>
</head>

<body>
    <?php include("menu.php"); ?>

    <div id="contenedorpagina" style="border-top: 15px solid #141414;">
        <div class="container app-lg">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center my-5">
                            </br>
                            <h1 class="letb">Fotos</h1>
                            </br>
                            <div id="fancybox-gallery" class="gallery">
                                <!-- Las imágenes de Google Drive se cargarán aquí -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>

    <script>
        const apiKey = 'AIzaSyDtqjw8a52mWgn-TJyFFKrNOpO1Bn7Wj1c';
        const folderId = '1AXLWKx66wnfNeYUvXLGR1YAxADKb0hid';

        function listFiles() {
            $.ajax({
                url: `https://www.googleapis.com/drive/v3/files?q='${folderId}'+in+parents&key=${apiKey}&fields=files(id,name,thumbnailLink,webContentLink,mimeType)`,
                type: 'GET',
                success: function (data) {
                    var files = data.files;
                    var gallery = $('#fancybox-gallery');
                    files.forEach(function (file) {
                        if (file.mimeType.startsWith('image/')) {
                            var imgURL = file.thumbnailLink.replace('=s220', '=s600');
                            var fullImageURL = `https://drive.google.com/uc?id=${file.id}`;
                            var downloadURL = `https://drive.google.com/uc?export=download&id=${file.id}`;
                            gallery.append(`
                                <a href="${fullImageURL}" data-fancybox="gallery">
                                    <img src="${imgURL}" alt="">
                                </a>
                            `);
                        }
                    });
                    // Inicializar FancyBox
                    Fancybox.bind('[data-fancybox="gallery"]', {
                        Toolbar: {
                            display: [
                                { id: "zoom", position: "left" },
                                { id: "download", position: "left" },
                                { id: "close", position: "right" },
                            ],
                        },
                        download: function (slide) {
                            return slide.src;
                        }
                    });
                },
                error: function (response) {
                    console.error('Error:', response);
                }
            });
        }

        $(document).ready(function () {
            listFiles();
        });
    </script>
</body>

</html>
