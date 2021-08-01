<?php
declare(strict_types=1);
class THUnits
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

    /**
     * Units Datatable
     *
     * @param array $data
     * @return string
     */
    public function unitsTable(array $data = []) : string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-striped text-center" id="ecommerce-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th scope="col" style="width:30%">Unit</th>
                            <th scope="col">Description</th>
                            <th scope="col" style="width:20%">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? "style='color:green'" : '';
            $txtactive = $item->status == 'on' ? 'Active Unit' : 'Inactive Unit';
            $output .= ' <tr>
                            <th scope="row">' . $item->unID . '</th>
                            <td>' . $item->unit . '</td>
                            <td>' . $item->descr . '</td>
                            <td class="action">
                            <form class="units-status" id="units-status' . $item->unID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'units-status' . $item->unID)) . '
                                <input type="hidden" name="unID" value="' . $item->unID . '">
                                <button type="button" title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>&nbsp;
                            <form class="edit-unit-status mx-2" id="edit-unit-status' . $item->unID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-unit-status' . $item->unID)) . '
                                <input type="hidden" name="unID" value="' . $item->unID . '">
                                <button type="button" title="Edit Unit" class="text-primary editBtn mx-2" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>&nbsp;
                            <form class="delete-unit-status" id="delete-unit-status' . $item->unID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-unit-status' . $item->unID)) . '
                                <input type="hidden" name="unID" value="' . $item->unID . '">
                                <button type="submit" title="Delete Unit" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}