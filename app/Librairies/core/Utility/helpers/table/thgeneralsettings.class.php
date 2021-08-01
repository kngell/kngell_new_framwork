<?php
declare(strict_types=1);
class THGeneralSettings
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
    public function GeneralSettingsTable(array $data = []) : string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-middle table-hover table-responsive" id="ecommerce-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th scope="col" style="width:10%">Setting Key</th>
                            <th scope="col" style="width:15%">Setting Name</th>
                            <th scope="col" style="width:20%">Setting Description</th>
                            <th scope="col">Setting Value</th>
                            <th scope="col" style="width:15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? "style='color:green'" : '';
            $txtactive = $item->status == 'on' ? 'Active Setting' : 'Inactive Setting';
            $output .= ' <tr>
                            <td scope="row" class="text-center">' . $item->setID . '</td>
                            <td>' . $item->setting_key . '</td>
                            <td>' . $item->setting_name . '</td>
                            <td>' . $item->htmlDecode($item->setting_descr) . '</td>
                            <td>' . $item->value . '</td>
                            <td class="action">
                            <form class="general_setting-status" id="general_setting-status' . $item->setID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'general_setting-status' . $item->setID)) . '
                                <input type="hidden" name="setID" value="' . $item->setID . '">
                                <button type="button" title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>&nbsp;
                            <form class="edit-general_setting-status mx-2" id="edit-general_setting-status' . $item->setID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-general_setting-status' . $item->setID)) . '
                                <input type="hidden" name="setID" value="' . $item->setID . '">
                                <button type="button" title="Edit Unit" class="text-primary editBtn mx-2" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>&nbsp;
                            <form class="delete-general_setting-status" id="delete-general_setting-status' . $item->setID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-general_setting-status' . $item->setID)) . '
                                <input type="hidden" name="setID" value="' . $item->setID . '">
                                <button type="submit" title="Delete Setting" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}