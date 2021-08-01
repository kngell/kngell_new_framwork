<?php
declare(strict_types=1);
class THWarehouse
{
    protected Token $token;

    /**
     * Main constructor
     * ================================================================================================
     * @param Token $token
     * @param array $data
     */
    public function __construct(Token $token = null, )
    {
        $this->token = $token;
    }

    public function warehouseTable(array $data)
    {
        $output = ' <table class="table table-striped table-bordered table-hover" id="ecommerce-datatable">
        <thead class="thead-inverse text-muted">
            <tr>
                <th>#</th>
                <th>Warehouse</th>
                <th>description</th>
                <th>company</th>
                <th>Country</th>
                <th class="text-center" style="width:5%;">status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? 'style="color:green;"' : '';
            $output .= '<tr>
            <td>
                ' . $item->whID . '
            </td>
            <td>' . $item->htmlDecode($item->wh_name) . '
            </td>
            <td>' . $item->htmlDecode($item->wh_descr) . '
            </td>
            <td>
                ' . $item->denomination . '
            </td>
            <td>
            ' . implode($item->get_countrie($item->country_code)) . '
            </td>
            <td class="text-center">     
                <form class="warehouse-status" id="warehouse-status' . $item->whID . '"/>'
                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'brand-status' . $item->whID)) . '
                <input type="hidden" name="whID" value="' . $item->whID . '">
                <button type="button" title="status" class="text-danger activateBtn"> <i class="far fa-power-off fa-lg" ' . $active . '></i></button>
                </form>
            </td>
       
            <td class="action">
                <form class="edit-warehouse-frm" id="edit-warehouse-frm' . $item->whID . '">
                    ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-warehouse-frm' . $item->whID)) . '
                 <input type="hidden" name="whID" value="' . $item->whID . '">
                    <button type="button" title="Edit Brand" class="text-primary editBtn mx-3" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="far fa-edit fa-lg"></i></button>
                </form>
                &nbsp;
                <form class="delete-warehouse-frm" id="delete-warehouse-frm' . $item->whID . '">
                    ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-brand-frm' . $item->whID)) . '
                    <input type="hidden" name="whID" value="' . $item->whID . '">
                    <button type="submit" title="Delete Brand" class="text-danger deleteBtn"><i class="far fa-trash-alt fa-lg"></i></button>
                </form>

            </td>
        </tr>';
        }
        $output .= '</tbody>
        </table>';
        return $output;
    }
}