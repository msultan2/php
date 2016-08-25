<html>
<head>
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>
<body>
<form method="post" enctype="multipart/form-data" id="image_upload_form" action="uploadcode.php">
<input type="file" name="images" id="images" multiple accept="image/x-png, image/gif, image/jpeg, image/jpg" />
<button type="submit" id="btn">Upload Files!</button>
</form>
<div id="response"></div>
<ul id="image-list">

</ul>

<script>

(function () {
var input = document.getElementById("images"), 
    formdata = false;

function showUploadedItem (source) {
    var list = document.getElementById("image-list"),
        li   = document.createElement("li"),
        img  = document.createElement("img");
    img.src = source;
    li.appendChild(img);
    list.appendChild(li);
}   

if (window.FormData) {
    formdata = new FormData();
    document.getElementById("btn").style.display = "none";
}

input.addEventListener("change", function (evt) {
    document.getElementById("response").innerHTML = "Uploading . . ."
    var i = 0, len = this.files.length, img, reader, file;

	
	
    for ( ; i < len; i++ ) {
        file = this.files[i];

        if (!!file.type.match(/image.*/)) {
            if ( window.FileReader ) {
                reader = new FileReader();
                reader.onloadend = function (e) { 
                    showUploadedItem(e.target.result, file.fileName);
                };
                reader.readAsDataURL(file);
            }
            if (formdata) {
                formdata.append("images[]", file);
            }
        }   
    }

    if (formdata) {
        $.ajax({
            url: "uploadcode.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (res) {
			alert("fefe2");
			alert(res);
                document.getElementById("response").innerHTML = res;
            }
        });
    }
}, false);
}());

</script>
</body>
</html>
