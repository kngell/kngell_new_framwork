<?php
declare(strict_types=1);
class THBrand
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
    public function brandTable(array $data) : string
    {
        $output = '';
        $output .= '<table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col" style="width:10%" class="text-center">#</th>
                            <th scope="col" style="width:20%">Name</th>
                            <th scope="col" style=>Description</th>
                            <th scope="col" style="width:20%">Photo</th>
                            <th scope="col" style="width:20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? 'style="color:green;"' : '';
            $output .= ' <tr>
                            <th scope="row">' . $item->brID . '</th>
                            <td>' . $item->br_name . '</td>
                            <td>' . $item->br_descr . '</td>
                            <td>' . '' . '</td>
                            <td class="d-flex flex-row justify-content-center">
                                <form class="brand-status" id="brand-status' . $item->brID . '"/>'
                                    . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'brand-status' . $item->brID)) . '
                                    <input type="hidden" name="brID" value="' . $item->brID . '">
                                    <button type="button" title="status" class="text-danger activateBtn"> <i class="far fa-power-off fa-lg" ' . $active . '></i></button>
                                </form>
                                &nbsp;
                                <form class="edit-brand-frm" id="edit-brand-frm' . $item->brID . '">
                                    ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-brand-frm' . $item->brID)) . '
                                    <input type="hidden" name="brID" value="' . $item->brID . '">
                                    <button type="button" title="Edit Brand" class="text-primary editBtn mx-3" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="far fa-edit fa-lg"></i></button>
                                </form>
                                &nbsp;
                                <form class="delete-brand-frm" id="delete-brand-frm' . $item->brID . '">
                                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-brand-frm' . $item->brID)) . '
                                    <input type="hidden" name="brID" value="' . $item->brID . '">
                                    <button type="submit" title="Delete Brand" class="text-danger deleteBtn"><i class="far fa-trash-alt fa-lg"></i></button>
                                </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}