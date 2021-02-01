  <input type="hidden" value="<?php echo $fileName; ?>" id="scriptFileName">

  <link rel="stylesheet" href="<?php echo base_url().'assets/script/'; ?>dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url().'assets/script/'; ?>buttons.dataTables.min.css">

  <script src="<?php echo base_url().'assets/script/'; ?>jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>dataTables.bootstrap.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>dataTables.buttons.min.js"></script>
  
  <script src="<?php echo base_url().'assets/script/'; ?>buttons.colVis.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>buttons.flash.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>3.1.3/jszip.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>pdfmake.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>vfs_fonts.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>buttons.html5.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>buttons.print.min.js"></script>
  <script src="<?php echo base_url().'assets/script/'; ?>jszip.min.js"></script>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      var fileName = $("#scriptFileName").val();
      $('.example').DataTable({
        "paging": true,
      dom: 'Bfrtip',
      buttons: [
          'pageLength',
          {
              extend: 'pdf',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'excel',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'csv',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },
          'colvis'
      ],
      lengthMenu: [
          [ 100, 250, 500, -1 ],
          ['100 rows', '250 rows', '500 rows', 'Show all' ]
      ],pageLength:100
    },
    
    {
      dom: 'Bfrtip',
      buttons: [
          {
              extend: 'collection',
              text: 'Table control',
              buttons: ['colvis']
          }
      ]
    });
  });            

  $(document).ready(function() {
      var fileName = $("#scriptFileName").val();
      $('.example2').DataTable({
        "paging": false,
      dom: 'Brtip',
      buttons: [
          {
              extend: 'pdf',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'excel',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'csv',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },
          'colvis'
      ],
    },
    
    {
      dom: 'Brtip',
      buttons: [
          {
              extend: 'collection',
              text: 'Table control',
              buttons: ['colvis']
          }
      ]
    });
  });            
</script>
<style type="text/css">
    body{
        padding-right:0px !important;
    } table.dataTable.no-footer {
       border-bottom: 1px solid #ddd !important;
    }

</style>
