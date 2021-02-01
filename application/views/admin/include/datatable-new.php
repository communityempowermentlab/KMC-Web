<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/tables/datatable/datatables.min.css">

<!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<!-- END: Page Vendor JS-->


<!-- BEGIN: Page JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/datatables/datatable.min.js"></script>
<!-- END: Page JS-->


<script type="text/javascript">
	$(".dataex-html5-selectors-ex").DataTable(
		{
			dom:"Bfrtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,5]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,5]}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);


	$(".dataex-html5-selectors-lounge").DataTable(
		{
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,5,6,8,9,10,11]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,5,6,8,9,10,11]}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);


	$(".dataex-html5-selectors-log").DataTable(
		{
			dom:"Bfrtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:":visible"}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:":visible"}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);


	$(".dataex-html5-selectors-staff").DataTable(
		{	
			"paging": false,
			"ordering": false,
        	"info":     false,
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,6,7,8]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,6,7,8]}
			},
			{
				extend:"print",exportOptions:{columns:[1,2,3,4,6,7,8]}
			}]
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);

	$(".dataex-html5-selectors-mother").DataTable(
		{	
			"paging": false,
			"ordering": false,
        	"info":     false,
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,4,5,6,7,8,9,10]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,4,5,6,7,8,9,10,11]}
			},
			{
				extend:"print",exportOptions:{columns:[1,2,4,5,6,7,8,9,10,11]}
			}]
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);

	$(".dataex-html5-selectors-baby").DataTable(
		{	
			"paging": false,
			"ordering": false,
        	"info":     false,
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,6,7,8]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,3,4,5,6,9,10,11,12,13]}
			},
			{
				extend:"print",exportOptions:{columns:[1,3,4,5,6,9,10,11,12,13]}
			}]
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);
	$(".dataex-html5-selectors-facility").DataTable(
		{	
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,5]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,5]}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);


	$(".dataex-html5-selectors-enquiry").DataTable(
		{
			dom:"Brtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,5,6,7,8,9,10]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10]}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);

	$(".dataex-html5-selectors-notification").DataTable(
		{
			dom:"Bfrtip",
			buttons:
			[
				{extend:"pdfHtml5",
				exportOptions:
				{columns:[1,2,3,4,5,6,7,8,9,10]}
			},
			{
				extend:"csvHtml5",exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10]}
			},
			{
				extend:"print",exportOptions:{columns:":visible"}
			}],
			lengthMenu: [
		          [ 20, 100, 200, -1 ],
		          ['20 rows', '100 rows', '200 rows', 'Show all' ]
		    ],pageLength:20
		}),
	$(".scroll-horizontal-vertical").DataTable(
		{scrollY:200,scrollX:!0}
		);

</script>