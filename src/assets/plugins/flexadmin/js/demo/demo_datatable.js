import 'datatables.net-bs4/js/dataTables.bootstrap4.js';
import 'datatables.net-bs4/css/dataTables.bootstrap4.css';

class DemoDataTable {
  constructor() {}

  init() {
    $('#demo-datatable').DataTable({
      responsive: true,
      "pageLength": 25
    });
  }
}
export default DemoDataTable
new DemoDataTable().init()