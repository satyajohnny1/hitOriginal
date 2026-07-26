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
     
  
    <!-- Search Form -->
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
       	<div class="page-sidebar sidebar">
                  <?php include('sidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">
            <div class="page-title">
                <h3>Directors List</h3>                
            </div>
            
          
            
            <div id="main-wrapper" >
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
                                                                    <th>director</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>
                                                                    <th>Count</th>
                                                                    <th>PL</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
												<!-- director serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                   			include 'db.php'; 
                                                   			$sql = "SELECT d.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl 
                                                   			        FROM tolly_director d
                                                   			        LEFT JOIN (
                                                   			            SELECT director_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                                                   			            FROM (
                                                   			                SELECT did as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                                                   			                UNION ALL
                                                   			                SELECT d2 as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND d2 > 0
                                                   			                UNION ALL
                                                   			                SELECT d3 as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND d3 > 0
                                                   			            ) t
                                                   			            GROUP BY director_id
                                                   			        ) m ON d.director_id = m.director_id";
                                                   			$result = mysqli_query($conn, $sql);
                                                   			
                                                   			if (mysqli_num_rows($result) > 0) {
                                                   				while($row = mysqli_fetch_assoc($result)) {
                                                   					$dir_id = $row["director_id"];
                                                   					$dir_name = $row["director_name"];
                                                   					$dir_rate = $row["director_rate"];
                                                   					$dir_grade = $row["director_grade"];
                                                   					$dir_status = $row["director_status"];
                                                   					$dir_rating = $row["director_rating"];
                                                   					$dir_pic = $row["director_pic"];
                                                   					$dir_cr = round(($dir_rate/10000000),2);   
                                                   					$pl_val = floatval($row["pl"]);
                                                   					$pl_cr = round(($pl_val/10000000),2);
                                                   					$pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
                                                   					
                                                   					echo "<tr data-id='$dir_id' data-table='director'>";
                                                   					echo  "<td><img class=\"img-circle avatar\" src=\"$dir_pic\" width=\"40\" height=\"40\"></td>";
                                                   					echo "<td class='cell-name'><a href='director.php?id=$dir_id' class='btn'>$dir_name</a></td>";
                                                   					echo "<td class='cell-rate' data-raw='$dir_rate'><b>".$dir_cr." CRORES</b></td>";
                                                   					echo "<td class='cell-rating'>$dir_rating</td>";
                                                   					echo "<td><b>".$row["movie_count"]."</b></td>";
																		echo "<td class='$pl_class' data-order='".$pl_cr."'><b>".$pl_cr." CRORES</b></td>";
																		echo "<td>";
																		echo "<span class='edit-actions'><button class='btn btn-xs btn-primary' onclick='startEdit(this)'><i class='fa fa-pencil'></i></button> ";
																		echo "<button class='btn btn-xs btn-danger' onclick='deleteRow(this)'><i class='fa fa-trash'></i></button></span> ";
																		echo "<span class='save-actions' style='display:none'><button class='btn btn-xs btn-success' onclick='saveEdit(this)'><i class='fa fa-check'></i></button> ";
																		echo "<button class='btn btn-xs btn-default' onclick='cancelEdit(this)'><i class='fa fa-times'></i></button></span>";
																		echo "</td>";
                                                   					echo  "</tr>"; 
                                                   				}
                                                   			}  
                                                                ?>
                                                             </tbody>
                                        </table>  
                                     </div>
                                </div>
                            </div></div></div>
          
            </div>
            <!-- Main Wrapper -->

   		 
            <div class="page-footer">
                <p class="no-s">2015 &copy; HitandFut.com</p>
            </div>
        </div>
        <!-- Page Inner -->
    </main>
    <!-- Page Content -->
  
    <div class="cd-overlay"></div>

    <!-- Add New Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">Add New Director</h4>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>Name</label><input type="text" class="form-control" id="addName"></div>
            <div class="form-group"><label>Rate</label><input type="number" class="form-control" id="addRate"></div>
            <div class="form-group"><label>Grade</label><input type="text" class="form-control" id="addGrade"></div>
            <div class="form-group"><label>Status</label><input type="text" class="form-control" id="addStatus" value="pending"></div>
            <div class="form-group"><label>Rating</label><input type="number" class="form-control" id="addRating" value="0"></div>
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
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "5000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}

	function openAddModal() {
		$('#addName').val('');
		$('#addRate').val('');
		$('#addGrade').val('');
		$('#addStatus').val('pending');
		$('#addRating').val('0');
		$('#addModal').modal('show');
	}

	function addNew() {
		var name = $('#addName').val().trim();
		var rate = $('#addRate').val();
		var grade = $('#addGrade').val().trim();
		var status = $('#addStatus').val().trim();
		var rating = $('#addRating').val();
		if (!name) { toastr.error('Name is required'); return; }
		$.post('listAjax.php', {action:'add', table:'director', name:name, rate:rate, grade:grade, status:status, rating:rating}, function(r) {
			if (r.status === 'ok') {
				var cr = (rate / 10000000).toFixed(2);
				var pic = r.pic || '';
				var row = '<tr data-id="'+r.id+'" data-table="director">';
				row += '<td><img class="img-circle avatar" src="'+pic+'" width="40" height="40"></td>';
				row += '<td class="cell-name"><a href="director.php?id='+r.id+'" class="btn">'+name+'</a></td>';
				row += '<td class="cell-rate" data-raw="'+rate+'"><b>'+cr+' CRORES</b></td>';
				row += '<td class="cell-rating">'+rating+'</td>';
				row += '<td><b>0</b></td>';
				row += '<td><b>0 CRORES</b></td>';
				row += '<td><span class="edit-actions"><button class="btn btn-xs btn-primary" onclick="startEdit(this)"><i class="fa fa-pencil"></i></button> <button class="btn btn-xs btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button></span> <span class="save-actions" style="display:none"><button class="btn btn-xs btn-success" onclick="saveEdit(this)"><i class="fa fa-check"></i></button> <button class="btn btn-xs btn-default" onclick="cancelEdit(this)"><i class="fa fa-times"></i></button></span></td>';
				row += '</tr>';
				$('#example tbody').prepend(row);
				$('#addModal').modal('hide');
				toastr.success('Director added successfully');
			} else {
				toastr.error(r.msg);
			}
		}, 'json');
	}

	function startEdit(btn) {
		var row = $(btn).closest('tr');
		row.data('origName', row.find('.cell-name a').text());
		row.data('origRate', row.find('.cell-rate').data('raw'));
		row.data('origRating', row.find('.cell-rating').text());
		row.find('.cell-name').html('<input type="text" class="form-control input-sm" value="'+row.data('origName')+'">');
		row.find('.cell-rate').html('<input type="number" class="form-control input-sm" value="'+row.data('origRate')+'">');
		row.find('.cell-rating').html('<input type="number" class="form-control input-sm" value="'+row.data('origRating')+'">');
		row.find('.edit-actions').hide();
		row.find('.save-actions').show();
	}

	function cancelEdit(btn) {
		var row = $(btn).closest('tr');
		var id = row.data('id');
		row.find('.cell-name').html('<a href="director.php?id='+id+'" class="btn">'+row.data('origName')+'</a>');
		var cr = (row.data('origRate') / 10000000).toFixed(2);
		row.find('.cell-rate').html('<b>'+cr+' CRORES</b>');
		row.find('.cell-rating').text(row.data('origRating'));
		row.find('.save-actions').hide();
		row.find('.edit-actions').show();
	}

	function saveEdit(btn) {
		var row = $(btn).closest('tr');
		var id = row.data('id');
		var name = row.find('.cell-name input').val().trim();
		var rate = row.find('.cell-rate input').val();
		var rating = row.find('.cell-rating input').val();
		var grade = row.data('origGrade') || '';
		var status = row.data('origStatus') || 'pending';
		$.post('listAjax.php', {action:'update', table:'director', id:id, name:name, rate:rate, grade:grade, status:status, rating:rating}, function(r) {
			if (r.status === 'ok') {
				var cr = (rate / 10000000).toFixed(2);
				row.find('.cell-name').html('<a href="director.php?id='+id+'" class="btn">'+name+'</a>');
				row.find('.cell-rate').attr('data-raw', rate).html('<b>'+cr+' CRORES</b>');
				row.find('.cell-rating').text(rating);
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
