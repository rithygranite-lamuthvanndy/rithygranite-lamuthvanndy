<?php 
    $menu_active =130;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Supplier Info</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <table id="example" class="table table-striped table-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%">
       <thead>
          <tr>
             <th>Name</th>
             <th>Position</th>
             <th>Office</th>
             <th>Extn.</th>
             <th>Start date</th>
             <th>Salary</th>
          </tr>
       </thead>
    </table>
    </div>
</div>
<script src="../../assets/global/plugins/jquery.min.js"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js"></script>
<script src="dataTables.rowsGroup.js"></script>
<script>
    var table = $('#example').DataTable({
      // 'ajax': 'https://api.myjson.com/bins/pr6dp',
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', className: 'btn dark btn-outline'},
            { extend: 'copy', className: 'btn red btn-outline' },
            { extend: 'pdf', className: 'btn green btn-outline' },
            { extend: 'excel', className: 'btn yellow btn-outline ' },
            { extend: 'csv', className: 'btn purple btn-outline ' },
            { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
        ],
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered1 from _MAX_ total entries)",
            "lengthMenu": "_MENU_ entries",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        "order": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        "pageLength": 10,
        'rowsGroup': [0],
        // responsive: true,
        "data":
        [
                ["1","System Architect","Edinburgh","5421","2011/04/25","$320,800"],
                ["1","Additional information","","","",""],
                ["Garrett Winters","Accountant","Tokyo","8422","2011/07/25","$170,750"],
                ["Garrett Winters","Additional information","","","",""],
                ["Ashton Cox","Junior Technical Author","San Francisco","1562","2009/01/12","$86,000"],
                ["Ashton Cox","Additional information","","","",""],
                ["Cedric Kelly","Senior Javascript Developer","Edinburgh","6224","2012/03/29","$433,060"],
                ["Cedric Kelly","Additional information","","","",""],
                ["Airi Satou","Accountant","Tokyo","5407","2008/11/28","$162,700"],
                ["Airi Satou","Additional information","","","",""]
        ],
        'columnDefs': [
            {
                'targets': [1, 2, 3, 4, 5],
                // 'orderable': false,
                'searchable': false
            }
        ],
        'createdRow': function(row, data, dataIndex){
            // Use empty value in the "Office" column
            // as an indication that grouping with COLSPAN is needed
            if(data[2] === ''){
                // Add COLSPAN attribute
                $('td:eq(1)', row).attr('colspan', 5);

                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(2)', row).css('display', 'none');
                $('td:eq(3)', row).css('display', 'none');
                $('td:eq(4)', row).css('display', 'none');
                $('td:eq(5)', row).css('display', 'none');
            }
        }      
    });  
</script>
<?php include_once '../layout/footer.php' ?>
