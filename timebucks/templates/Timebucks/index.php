<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>TimeBucks <b>Records</b></h2>
                </div>
               
            </div>
        </div>
        <table id="timebuck-table" class="display" style="width:100%">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Requirements</th>
                <th>Epc</th>
                <th>Click url</th>
            </thead>
        </table>

        <script>
            $(document).ready(function() {
                var table = $('#timebuck-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "pagingType": "simple",
                    "pagingType": "full_numbers",
                    "ajax": {
                        "url": "/getRecords", // Replace with your controller action URL
                        "type": "POST",
                        headers: {
                            'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')); ?>,
                        },
                    },
                    "searchDelay": 500,
                    "columns": [{
                            data: "name",
                            "orderable": false,
                            "searchable": false,
                        },
                        {
                            data: "description",
                            "orderable": false,
                            "searchable": false,
                        },
                        {
                            data: "requirements",
                            "orderable": false,
                            "searchable": false,
                        },
                        {
                            data: "epc"
                        },
                        {
                            data: "click_url",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row, meta) { // render event defines the markup of the cell text 
                                var a = '<a href=' + row.click_url +' target="_blank"> Click to open </a>'; // row object contains the row data
                                return a;
                            }

                        },
                    ],

                });
                table.ajax.reload();
            });
        </script>

    </div>
</div>