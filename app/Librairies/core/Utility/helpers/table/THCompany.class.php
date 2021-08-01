<?php
declare(strict_types=1);
class THCompany
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

    public function companyTable(array $data)
    {
        $output = ' <table class="table table-striped table-bordered table-hover" id="ecommerce-datatable">
    <thead class="thead-inverse text-muted">
        <tr>
            <th>Sigle</th>
            <th>Dénomination</th>
            <th>Couriel</th>
            <th>Tél. Fix</th>
            <th>Tél. Portable</th>
            <th style="width:5%" class="text-center">contacts</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>';
        foreach ($data as $item) {
            $output .= '<tr>
            <td>
                <a href="' . PROOT . 'forms/details/' . $item->compID . '">' . htmlspecialchars_decode($item->sigle, ENT_NOQUOTES) . '</a>
            </td>
            <td>' . htmlspecialchars_decode($item->denomination, ENT_NOQUOTES) . '
            </td>
            <td>' . $item->couriel . '
            </td>
            <td>' . $item->phone . '
            </td>
            <td>
                ' . $item->mobile . '
            </td>
            <td class="text-center">
                <a href="#" title="contacts utiles"
                    class="text-success text-center"><i class="fas fa-address-book fa-lg"></i></a>&nbsp;
            </td>
            <td class="action">
                <a href="' . PROOT . 'admin/company_details/' . $item->compID . '" title="view details" class="text-info"><i
                        class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;
                <form class="edit-company-frm" id="edit-company-frm' . $item->compID . '">
                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-company-frm' . $item->compID)) . '
                            <input type="hidden" name="compID" value="' . $item->compID . '">
                    <a href="#" id="' . $item->compID . '" title="Edit Company" class="text-primary editBtn mx-2"
                    data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fas fa-edit fa-lg"></i></a>
                </form>
                    &nbsp;&nbsp;
                <form class="delete-company-frm" id="delete-company-frm' . $item->compID . '">
                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-company-frm' . $item->compID)) . '
                            <input type="hidden" name="compID" value="' . $item->compID . '">
                <button type="submit" title="Delete Company" class="text-danger deleteBtn"><i
                        class="fas fa-trash-alt fa-lg"></i></button>
                </form>

            </td>

        </tr>';
        }
        $output .= '</tbody>
        </table>';
        return $output;
    }
}