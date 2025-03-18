<?php
include("conection.php");
$id = 1;
$sql = "SELECT id FROM citys ORDER BY id DESC";
$rs = $con->query($sql);
if ($rs->num_rows > 0) {
    $row = $rs->fetch_array();
    $id = $row[0] + 1;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City</title>
    <!-- style -->
    <link rel="stylesheet" href="city.css">
    <!-- link font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- bootstrap  -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class='frm'>
        <form class='upl'>
            <input type="hidden" name="txt-edit-id" id="txt-edit-id" value="0">
            <label for="">ID</label>
            <input type="text" name="txt-id" id="txt-id" class="frm-control" value="<?php echo $id ?>">
            <label for="">City Name</label>
            <input type="text" name="txt-name" id="txt-name" class="frm-control">
            <label for="">Description</label>
            <textarea name="txt-des" id="txt-des" class="frm-control"></textarea>
            <select name="txt-status" id="txt-status" class="frm-control">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <label for="">Photo</label>
            <div class="img-box">
                <input type="file" name="txt-file" id="txt-file " class="frm-control txt-file">
                <input type="text" id="txt-img-name" name="txt-img-name">
            </div>
            <a class="btn-post" style="text-decoration: none;">
                Post
            </a>
        </form>
    </div>
    <div class="container-fluid">
        <div class="col-xl-8 m-auto">
            <table id="tblData" class="table table-dark table-hover align-middle" border="1px"
                style="table-layout: fixed;">
                <tr>
                    <th>ID</th>
                    <th>City Name</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT * FROM citys ORDER BY id DESC";
                $rs = $con->query($sql);
                while ($row = $rs->fetch_array()) {

                    echo "
                        <tr>
                            <td>{$row[0]}</td>
                            <td>{$row[1]}</td>
                            <td>{$row[2]}</td>
                            <td>          
                                <img src='./img/{$row[3]}' alt='{$row[3]}' width='50%'>
                            </td>
                            <td>{$row[4]}</td>
                            <td> 
                                <input type='button' value='Edit' class='btnEdit'>
                                <input type='button' data-id='{$row['id']}' value='Delete' class='btnDelete'>
                            </td>
                        </tr>
                        ";
                }
                ?>

            </table>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        var tbl = $('#tblData');
        var loading = "<div class='loading'></div>";
        var ind;
        //get edit data
        tbl.on('click', '.btnEdit', function () {
            var eThis = $(this);
            var tr = eThis.parents('tr');
            var id = tr.find("td:eq(0)").text();
            var name = tr.find("td:eq(1)").text();
            var Des = tr.find("td:eq(2)").text();
            var status = tr.find("td:eq(4)").text();
            var img = tr.find("td:eq(3) img").attr("alt");
            $('#txt-id').val(id);
            $('#txt-name').val(name);
            $('#txt-des').val(Des);
            $('#txt-status').val(status);
            $("#txt-img-name").val(img)
            $(".img-box").css({ "background-image": "url(img/" + img + ")" });
            $("#txt-edit-id").val(id);
            ind = tr.index();
        });

        $(".btn-post").click(function () {
            var eThis = $(this);
            var Parent = eThis.parents('.frm');
            var id = Parent.find("#txt-id");
            var name = Parent.find("#txt-name");
            var des = Parent.find("#txt-des");
            var imgBox = Parent.find('.img-box');
            var photo = Parent.find('#txt-img-name');
            var file = Parent.find('.txt-file');
            var status = Parent.find('#txt-status');
            if (name.val() == '') {
                alert("Please enter name");
                name.focus();
                return;
            } else if (des.val() == '') {
                des.focus();
                alert('Please eneter description');
                return;
            }
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
            $.ajax({
                url: 'save-city.php',
                type: 'POST',
                data: frm_data,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    //work before success
                    eThis.html("<i class='fa fa-spinner fa-spin'></i> Wait...");
                    eThis.css({ "pointer-events": "none" });

                },
                success: function (data) {
                    //work after success
                    if (data.dpl == true) {
                        alert("Dublicate Name");
                        name.focus();
                        eThis.html("Post");
                        eThis.css({ "pointer-events": "auto" });
                        return;
                    }

                    if (data.edit == true) {
                        tbl.find('tr:eq(' + ind + ') td:eq(1)').text(name.val());
                        tbl.find('tr:eq(' + ind + ') td:eq(2)').text(des.val());
                        tbl.find('tr:eq(' + ind + ') td:eq(3) img').attr("src", "img/" + photo.val() + "");
                        tbl.find('tr:eq(' + ind + ') td:eq(3) img').attr("alt", "" + photo.val() + "");
                        tbl.find('tr:eq(' + ind + ') td:eq(4)').text(status.val());
                    } else {
                        var tr = "<tr>" +
                            "<td>" + id.val() + "</td>" +
                            "<td>" + name.val() + "</td>" +
                            "<td>" + des.val() + "</td>" +
                            "<td> <img src=img/" + photo.val() + " width='50%' alt=" + photo.val() + "> </td>" +
                            "<td>" + status.val() + "</td>" +
                            "<td> <input type='button' value='Edit' class='btnEdit'> </td>" +
                            "</tr>";
                        tbl.find('tr:eq(0)').after(tr);
                        name.val('');
                        des.val('');
                        name.focus();
                        photo.val('');
                        file.val('');
                        imgBox.css({ "background-image": "url('img/bg.png')" });
                        id.val(data.id + 1);
                    }
                    eThis.html("Post");
                    eThis.css({ "pointer-events": "auto" });

                }
            });//ajax
        })//post

        $('.txt-file').change(function () {
            var eThis = $(this);
            var Parent = eThis.parents('.frm');
            var imgBox = Parent.find('.img-box');
            var photo = Parent.find('#txt-img-name');
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
            $.ajax({
                url: 'upl-img.php',
                type: 'POST',
                data: frm_data,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    //work before success
                    imgBox.append(loading);
                },
                success: function (data) {
                    //work after success
                    imgBox.css({ "background-image": "url('img/" + data.imgName + "')" });
                    imgBox.find('.loading').remove();
                    photo.val(data.imgName);
                }
            });//ajax
        });


        // Handle delete button click
        tbl.on('click', '.btnDelete', function () {
            var btn = $(this);
            var row = btn.closest('tr');
            var id = btn.data('id');

            if (confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    url: 'delete-city.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    beforeSend: function () {
                        btn.text('Deleting...');
                    },
                    success: function (response) {
                        if (response.success) {
                            row.fadeOut(300, function () {
                                $(this).remove();
                            });
                        } else {
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    },
                    complete: function () {
                        btn.text('Delete');
                    }
                });
            }
        });


    });//document
</script>

</html>