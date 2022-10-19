<?php
include_once(dirname(__FILE__)."/includes/session.php");
include_once(dirname(__FILE__)."/includes/function.php");
include_once(dirname(__FILE__)."/includes/DbConn.php");
include_once(dirname(__FILE__)."/includes/variables.php");
$mysqli = DbConn::connectToDatabase();
$page_title="Contractor LIST";
$pop_width="800";
$pop_height="600";
?>
<!doctype html>
<html>
<head>
<title>
<?php if(!empty($page_title)){ echo strtoupper($page_title)." | "; } echo strtoupper($site_title); ?>
</title>
<?php include_once("includes/css_js_header.php")?>
</head>
<body class="<?php echo $theme;?>">
<?php include_once("includes/header.php")?>
<div id="content" class="container-fluid">
  <?php include_once("includes/left_side.php")?>
  <div id="main">
    <div class="container-fluid">
      <div class="page-header">
        <div class="pull-left">
          
        </div>
        <?php include_once("includes/heading_right.php")?>
      </div>
      
      
      <div class="row">
        <div class="col-sm-12">
          <div id="mydatatable" class="box box-color box-bordered">
          	
            <div class="box-title" style="margin-top:10px;">
              <h3 style="text-transform:uppercase;"><i class="fa fa-table"></i> Contractor List </h3>
            </div>
            <div class="box-content nopadding">
                  <table id="flex1" style="display:none;" class=""></table>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript">
$("#flex1").flexigrid({
	url: 'contractorfetchable.php',
	dataType: 'json',
	 colModel : [	{display: 'ICKE Reg. No.', name : 'icke_reg_no', width : 200, sortable : true, align: 'left'},
	                {display: 'User Name', name : 'user_name', width : 200, sortable : true, align: 'left'},
					{display: 'Date', name : 'jccd_doc_receive_date', width : 200, sortable : true, align: 'left'},
					{display: 'Contractor Fees', name : 'jccd_contrator_fees', width : 200, sortable : true, align: 'left'},
					{display: 'Received By', name : 'jccd_received_by', width : 200, sortable : true, align: 'left'},
					{display: 'UserName(Operator)', name : 'jccd_operator_name', width : 200, sortable : true, align: 'left'}
                ],
                buttons : [						
						{name: '<button class="btn btn-small btn-primary btn--icon"><i class="fa fa-print"></i>Print</button>', bclass: '', onpress : printThisDeatils},
						{separator:true},
						{name: '<button class="btn btn-small btn-primary btn--icon"><i class="moon moon-file-excel"></i> Export To Excel</button><B></B>', bclass: '', onpress : exportToExcel},
						{separator:true}
                ],
                searchitems : [
					{display: 'ICKE Reg. No.', name : 'jc_icke_reg_no'}
            	],
                sortname: "TJCS.jccd_doc_receive_date",
				sortorder: "desc",
				usepager: true,
				useRp: true,
				rp: 15,
				showTableToggleBtn: true,
				onSubmit: addFormData,
				singleSelect: true,
				height: "auto"
			
				
});
function addOpen(){
	openAddEdit('workinsert.php',  <?php echo $pop_width;?>, <?php echo $pop_height;?>);
	//window.open("user_add_edit.php","_blank");
	return true;
}
function editOpen(){
	var flag=false;
	var id ="";
	var grid=document.getElementById("flex1");
	$('.trSelected', grid).each(function() {
		id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row')+3);
		flag=true;
	});
	if(flag==true){
		openAddEdit('workinsert.php?recordId='+id,  <?php echo $pop_width;?>, <?php echo $pop_height;?>);
		//window.open("user_add_edit.php?recordId="+id,"_blank");
		return true;
	}else{
		bootbox.alert('<div class="alert alert-info">  Please Select Record to Edit</div>');
		//alert("Please Select <?php echo $page_title;?> to Edit");
	}
}
function deleteOpen(){
	var flag=false;
	var id="";
	var grid=document.getElementById("flex1");
	$('.trSelected', grid).each(function() {
		id = $(this).attr('id');
		id = id.substring(id.lastIndexOf('row')+3);
		flag=true;
	});
	if(flag==true){		
		delRecord({'table_name':'work_list','field_name':'work_id','record_id':id})
		return true;
	}else{
		bootbox.alert('<div class="alert alert-info">  Please Select Record to Delete</div>');
	}
}

$(document).on('click','.chk_status',function() {
    
    var uid = $(this).attr('data_id');
    //alert(uid);
    var status_val = 0;
    if($(this).prop("checked")==true)
    {
    	var status_val = 1;
    }
    
    $(".overlay").show();
    $.ajax({
    	type: "get",
    	url: "agent_status_upd.php",
    	data: {uid:uid,status_val:status_val},
    	dataType : "json",
    	success: function(data)
    	{
    	    ///alert(data);
    	    $(".overlay").hide();
    		
    			location.reload();
    		
    	}

    });

});
</script>
<?php include_once("includes/css_js_footer.php")?>
<script>
</script>
</body>
</html>
