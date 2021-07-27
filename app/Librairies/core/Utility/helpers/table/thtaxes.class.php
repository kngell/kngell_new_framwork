<?php
declare(strict_types=1);
class THTaxes
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

    public function taxesTable(array $data) : ?string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-bordered text-center table-hover table-striped" id="ecommerce-datatable">
                    <thead class="mt-2">
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th scope="col" style="width:10%">Taxe Name</th>
                            <th scope="col">Description</th>
                            <th scope="col" style="width:10%">Rate</th>
                            <th scope="col" style="width:20%">Tag class</th>
                            <th scope="col">Associates Categories</th>
                            <th scope="col" style="width:20%">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $taxe) {
            $active = $taxe->status == 'on' ? "style='color:green'" : '';
            $txtactive = $taxe->status == 'on' ? 'Deactivate Category' : 'Activate Category';
            $output .= ' <tr>
                            <th scope="row">' . $taxe->tID . '</th>
                            <td>' . $taxe->t_name . '</td>
                            <td>' . $taxe->t_descr . '</td>
                            <td>' . $taxe->t_rate . '</td>
                            <td>' . $taxe->t_class . '</td>
                            <td>' . $taxe->categorie . '</td>
                            <td class="d-flex flex-row justify-content-center">
                            <form class="taxe-status" id="taxe-status' . $taxe->tID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'taxe-status' . $taxe->tID)) . '
                                <input type="hidden" name="tID" value="' . $taxe->tID . '">
                                <button type="button"  title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>
                            &nbsp;
                            <form class="edit-taxes-frm mx-2" id="edit-taxes-frm' . $taxe->tID . '">
                            ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-taxes-frm' . $taxe->tID)) . '
                            <input type="hidden" name="tID" value="' . $taxe->tID . '">
                                <button type="button" title="Edit Taxe" class="text-primary editBtn mx-3" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>
                            &nbsp;
                            <form class="delete-taxe-frm" id="delete-taxe-frm' . $taxe->tID . '">
                                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-taxe-frm' . $taxe->tID)) . '
                                <input type="hidden" name="tID" value="' . $taxe->tID . '">
                                <button type="submit" title="Delete Taxe" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}