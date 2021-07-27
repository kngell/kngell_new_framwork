<?php
declare(strict_types=1);
class THGroups
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
     * Groupe Data table
     * =======================================================================
     * @param array $data
     * @param Token $token
     * @return string
     */
    public function groupsTable(array $data) : string
    {
        $output = '';
        $output .= '<table class="table table-striped text-center" id="ecommerce-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width:10%" class="text-center">#</th>
                            <th scope="col" style="width:20%">Name</th>
                            <th scope="col" style=>Description</th>
                            <th scope="col" style="width:20%">Parent Group</th>
                            <th scope="col" style="width:20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? "style='color:green'" : '';
            $group = ((int)$item->parentID != 0) ? current($item->getDetails($item->parentID)->get_results())->name : '';
            $output .= ' <tr>
                            <th scope="row">' . $item->grID . '</th>
                            <td>' . $item->name . '</td>
                            <td>' . $item->description . '</td>
                            <td>' . $group . '</td>
                            <td class="d-flex flex-row justify-content-center">
                                <form class="group-status" id="group-status' . $item->grID . '"/>'
                                    . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'group-status' . $item->grID)) . '
                                    <input type="hidden" name="grID" value="' . $item->grID . '">
                                    <button type="button" title="status" class="text-danger activateBtn"> <i class="fad fa-power-off fa-lg" ' . $active . '></i></button>
                                </form>
                                &nbsp;
                                <form class="edit-permissions" id="edit-permissions' . $item->grID . '">
                                    ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-permissions' . $item->grID)) . '
                                    <input type="hidden" name="grID" value="' . $item->grID . '">
                                    <button type="button" title="Edit permissions" class="text-primary editBtn mx-3" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fad fa-edit fa-lg"></i></button>
                                </form>
                                &nbsp;
                                <form class="delete-permissions" id="delete-permissions' . $item->grID . '">
                                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-permissions' . $item->grID)) . '
                                    <input type="hidden" name="grID" value="' . $item->grID . '">
                                    <button type="submit" title="Delete permissions" class="text-danger deleteBtn"><i class="fad fa-trash-alt fa-lg"></i></button>
                                </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}