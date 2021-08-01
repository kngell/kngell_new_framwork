<?php
declare(strict_types=1);
class THShippingClass
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
     * Shipping Class admin table
     *
     * @param array $data
     * @return string
     */
    public function shippingclassTable(array $data, ) : string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-striped text-center" id="ecommerce-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th scope="col" style="width:30%">Shippin Class Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">price</th>
                            <th scope="col" style="width:20%">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? "style='color:green'" : '';
            $txtactive = $item->status == 'on' ? 'Active Shipping Class' : 'Inactive Shipping Class';
            $output .= ' <tr>
                            <th scope="row">' . $item->shcID . '</th>
                            <td>' . $item->sh_name . '</td>
                            <td>' . $item->sh_descr . '</td>
                            <td>' . $item->price . '</td>
                            <td class="action">
                            <form class="units-status" id="units-status' . $item->shcID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'units-status' . $item->shcID)) . '
                                <input type="hidden" name="shcID" value="' . $item->shcID . '">
                                <button type="button" title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>&nbsp;
                            <form class="edit-shippin-class mx-2" id="edit-shippin-class' . $item->shcID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-shippin-class' . $item->shcID)) . '
                                <input type="hidden" name="shcID" value="' . $item->shcID . '">
                                <button type="button" title="Edit Shipping Class" class="text-primary editBtn mx-2" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>&nbsp;
                            <form class="delete-shipping-class" id="delete-shipping-class' . $item->shcID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-shipping-class' . $item->shcID)) . '
                                <input type="hidden" name="shcID" value="' . $item->shcID . '">
                                <button type="submit" title="Delete Shipping Class" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}