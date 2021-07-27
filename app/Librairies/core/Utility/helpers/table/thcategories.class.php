<?php
declare(strict_types=1);
class THCategories
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
     * Categories table
     * ===============================================================================================
     * @param array $data
     * @param Token $token
     * @return string|null
     */
    public function categoriesTable(array $data = []) : ?string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-bordered text-center table-hover table-striped" id="ecommerce-datatable">
                    <thead class="mt-2">
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th scope="col" style="width:20%">Categorie</th>
                            <th scope="col">Description</th>
                            <th scope="col" style="width:15%">Photo</th>
                            <th scope="col" style="width:20%">Parent Categorie</th>
                            <th scope="col" style="width:20%">Brand</th>
                            <th scope="col" style="width:20%">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $cat) {
            $catgorie = ((int)$cat->parentID != 0) ? $this->getParentCategorie($data, $cat->parentID) : '';
            $active = $cat->status == 'on' ? "style='color:green'" : '';
            $txtactive = $cat->status == 'on' ? 'Deactivate Category' : 'Activate Category';
            $output .= ' <tr>
                            <th scope="row">' . $cat->catID . '</th>
                            <td>' . $cat->categorie . '</td>
                            <td>' . $cat->description . '</td>
                            <td>' . $cat->photo . '</td>
                            <td>' . $catgorie . '</td>
                            <td>' . $cat->br_name . '</td>
                            <td class="d-flex flex-row justify-content-center">
                            <form class="categorie-status" id="categorie-status' . $cat->catID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'categorie-status' . $cat->catID)) . '
                                <input type="hidden" name="catID" value="' . $cat->catID . '">
                                <button type="button"  title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>
                            &nbsp;
                            <form class="edit-categorie-frm mx-2" id="edit-categorie-frm' . $cat->catID . '">
                            ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-categorie-frm' . $cat->catID)) . '
                            <input type="hidden" name="catID" value="' . $cat->catID . '">
                                <button type="button" title="Edit Category" class="text-primary editBtn mx-3" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>
                            &nbsp;
                            <form class="delete-categorie-frm" id="delete-categorie-frm' . $cat->catID . '">
                                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-categorie-frm' . $cat->catID)) . '
                                <input type="hidden" name="catID" value="' . $cat->catID . '">
                                <button type="submit" title="Delete Caegory" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }

    public function getParentCategorie(array $categories = [], int $parentID) : string
    {
        $Parentscategories = array_filter($categories, function ($categorie) use ($parentID) {
            return $categorie->catID == $parentID;
        });
        if (count($Parentscategories) === 1) {
            return current($Parentscategories)->categorie;
        }
        return '';
    }
}