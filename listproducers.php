<?php
include 'sessionCheck.php'; 
include __DIR__ . '/session_init.php'; 
?>
<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i class="fa fa-times"></i></a></h3>
    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
        <div class="page-sidebar sidebar">
            <?php include('sidemenu.php'); ?>
        </div>
        <div class="page-inner">
            <div class="page-title">
                <h3>Producers List</h3>
            </div>
            <div id="main-wrapper">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <button class="btn btn-success btn-sm pull-right" onclick="openAddModal()"><i class="fa fa-plus"></i> Add New</button>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Balance</th>
                                                <th>Debt</th>
                                                <th>Banner</th>
                                                <th>Count</th>
                                                <th>PL</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        include 'db.php';
                                        $sql = "SELECT u.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
                                                FROM tolly_user u
                                                LEFT JOIN (
                                                    SELECT uid, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                                                    FROM tolly_ready_for_shoot
                                                    WHERE status = 'out'
                                                    GROUP BY uid
                                                ) m ON u.uid = m.uid
                                                ORDER BY u.uid";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $banner = $row["banner"];
                                                $dir_name = $row["username"];
                                                $dir_id = $row["uid"];
                                                $dir_rate = $row["bal"];
                                                $dir_pic = $row["pic"];
                                                $dir_cr = round(($dir_rate/10000000),2);
                                                $pl_val = floatval($row["pl"]);
                                                $pl_cr = round(($pl_val/10000000),2);
                                                $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';

                                                echo "<tr data-id='$dir_id' data-table='user'>";
                                                echo "<td><img class=\"img-circle avatar\" src=\"$dir_pic\" width=\"40\" height=\"40\"></td>";
                                                echo "<td class='cell-name'><a href='proddata.php?id=$dir_id' class='btn'>$dir_name</a></td>";
                                                $debt_val = floatval($row["debt"] ?? 0);
                                                $debt_cr = round(($debt_val/10000000),2);
                                                echo "<td class='cell-rate' data-raw='$dir_rate'><b>".$dir_cr." CRORES</b></td>";
                                                echo "<td class='cell-debt' data-raw='$debt_val'><b class='text-danger'>".$debt_cr." CRORES</b></td>";
                                                echo "<td class='cell-banner'>$banner</td>";
                                                echo "<td><b>".$row["movie_count"]."</b></td>";
                                                echo "<td class='$pl_class' data-order='".$pl_cr."'><b>".$pl_cr." CRORES</b></td>";
                                                echo "<td>";
                                                echo "<span class='edit-actions'><button class='btn btn-xs btn-primary' onclick='startEdit(this)'><i class='fa fa-pencil'></i></button> ";
                                                echo "<button class='btn btn-xs btn-danger' onclick='deleteRow(this)'><i class='fa fa-trash'></i></button></span> ";
                                                echo "<span class='save-actions' style='display:none'><button class='btn btn-xs btn-success' onclick='saveEdit(this)'><i class='fa fa-check'></i></button> ";
                                                echo "<button class='btn btn-xs btn-default' onclick='cancelEdit(this)'><i class='fa fa-times'></i></button></span>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-footer">
                <p class="no-s">2015 &copy; HitandFut.com</p>
            </div>
        </div>
    </main>
    <div class="cd-overlay"></div>

    <!-- Add New Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">Add New Producer</h4>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>Username</label><input type="text" class="form-control" id="addName"></div>
            <div class="form-group"><label>Email</label><input type="email" class="form-control" id="addEmail"></div>
            <div class="form-group"><label>Password</label><input type="password" class="form-control" id="addPassword"></div>
            <div class="form-group"><label>Banner</label><input type="text" class="form-control" id="addBanner"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" onclick="addNew()">Save</button>
          </div>
        </div>
      </div>
    </div>

    <?php include 'js.php';?>
    <script type="text/javascript">
    toastr.options = {
        closeButton: false, debug: false, newestOnTop: false, progressBar: false,
        positionClass: "toast-top-right", preventDuplicates: false, onclick: null,
        showDuration: "300", hideDuration: "1000", timeOut: "5000", extendedTimeOut: "1000",
        showEasing: "swing", hideEasing: "linear", showMethod: "fadeIn", hideMethod: "fadeOut"
    };

    function openAddModal() {
        $('#addName').val('');
        $('#addEmail').val('');
        $('#addPassword').val('');
        $('#addBanner').val('');
        $('#addModal').modal('show');
    }

    function addNew() {
        var name = $('#addName').val().trim();
        var email = $('#addEmail').val().trim();
        var password = $('#addPassword').val();
        var banner = $('#addBanner').val().trim();
        if (!name || !email || !password) { toastr.error('Name, Email and Password are required'); return; }
        $.post('listAjax.php', {action:'add_user', name:name, email:email, password:password, banner:banner}, function(r) {
            if (r.status === 'ok') {
                var pic = r.pic || 'pic/default.png';
                var row = '<tr data-id="'+r.id+'" data-table="user">';
                row += '<td><img class="img-circle avatar" src="'+pic+'" width="40" height="40"></td>';
                row += '<td class="cell-name"><a href="proddata.php?id='+r.id+'" class="btn">'+name+'</a></td>';
                row += '<td class="cell-rate" data-raw="0"><b>0 CRORES</b></td>';
                row += '<td class="cell-debt" data-raw="0"><b class="text-danger">0 CRORES</b></td>';
                row += '<td class="cell-banner">'+banner+'</td>';
                row += '<td><b>0</b></td>';
                row += '<td><b>0 CRORES</b></td>';
                row += '<td><span class="edit-actions"><button class="btn btn-xs btn-primary" onclick="startEdit(this)"><i class="fa fa-pencil"></i></button> <button class="btn btn-xs btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button></span> <span class="save-actions" style="display:none"><button class="btn btn-xs btn-success" onclick="saveEdit(this)"><i class="fa fa-check"></i></button> <button class="btn btn-xs btn-default" onclick="cancelEdit(this)"><i class="fa fa-times"></i></button></span></td>';
                row += '</tr>';
                $('#example tbody').prepend(row);
                $('#addModal').modal('hide');
                toastr.success('Producer added successfully');
            } else {
                toastr.error(r.msg);
            }
        }, 'json');
    }

    function startEdit(btn) {
        var row = $(btn).closest('tr');
        row.data('origName', row.find('.cell-name a').text());
        row.data('origBanner', row.find('.cell-banner').text());
        row.find('.cell-name').html('<input type="text" class="form-control input-sm" value="'+row.data('origName')+'">');
        row.find('.cell-banner').html('<input type="text" class="form-control input-sm" value="'+row.data('origBanner')+'">');
        row.find('.edit-actions').hide();
        row.find('.save-actions').show();
    }

    function cancelEdit(btn) {
        var row = $(btn).closest('tr');
        var id = row.data('id');
        row.find('.cell-name').html('<a href="proddata.php?id='+id+'" class="btn">'+row.data('origName')+'</a>');
        row.find('.cell-banner').text(row.data('origBanner'));
        row.find('.save-actions').hide();
        row.find('.edit-actions').show();
    }

    function saveEdit(btn) {
        var row = $(btn).closest('tr');
        var id = row.data('id');
        var name = row.find('.cell-name input').val().trim();
        var banner = row.find('.cell-banner input').val().trim();
        $.post('listAjax.php', {action:'update', table:'user', id:id, name:name, banner:banner}, function(r) {
            if (r.status === 'ok') {
                row.find('.cell-name').html('<a href="proddata.php?id='+id+'" class="btn">'+name+'</a>');
                row.find('.cell-banner').text(banner);
                row.find('.save-actions').hide();
                row.find('.edit-actions').show();
                toastr.success('Updated successfully');
            } else {
                toastr.error(r.msg);
                cancelEdit(btn);
            }
        }, 'json');
    }

    function deleteRow(btn) {
        if (!confirm('Are you sure you want to delete this record?')) return;
        var row = $(btn).closest('tr');
        var id = row.data('id');
        var table = row.data('table');
        $.post('listAjax.php', {action:'delete', table:table, id:id}, function(r) {
            if (r.status === 'ok') {
                row.fadeOut(300, function(){ $(this).remove(); });
                toastr.success('Deleted successfully');
            } else {
                toastr.error(r.msg);
            }
        }, 'json');
    }
    </script>
</body>
</html>
<?php
if($conn!=null){
mysqli_close($conn);
}
?>
