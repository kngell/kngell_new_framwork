<?php
declare(strict_types=1);
class THSliders
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
    public function slidersTable(array $data = []) : string
    {
        $output = '<div id="tbl-alertErr"></div>';
        $output .= '<table class="table table-responsive" id="ecommerce-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width:2%" class="text-center">#</th>
                            <th class="no-sort">Image</th>
                            <th scope="col" style="width:10%">Page</th>
                            <th scope="col" style="width:10%">Title</th>
                            <th scope="col" style="width:10%">SubTitle</th>
                            <th scope="col">Text/Description</th>
                            <th scope="col">Button text</th>
                            <th scope="col">Button link</th>
                            <th scope="col" style="width:15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $item) {
            $active = $item->status == 'on' ? "style='color:green'" : '';
            $txtactive = $item->status == 'on' ? 'Active Setting' : 'Inactive Setting';
            $media = !empty($item->p_media) ? ImageManager::asset_img(unserialize($item->p_media)[0]) : ImageManager::asset_img('products' . US . 'product-80x80.jpg');
            $output .= ' <tr>
                            <th scope="row" class="text-center">' . $item->slID . '</th>
                            <td>
                            <a href="ecommerce-product-detail.html">
                                <img class="img-thumbnail" alt="Product" src="' . $media . '" width="48">
                            </a>
                            </td>
                            <td>' . $item->page_slider . '</td>
                            <td>' . $item->slider_title . '</td>
                            <td>' . $item->slider_subtitle . '</td>
                            <td>' . $item->htmlDecode($item->slider_text) . '</td>
                            <td>' . $item->slider_btn_text . '</td>
                            <td>' . $item->slider_btn_link . '</td>
                            <td class="action">
                   
                            <form class="sliders-status" id="sliders-status' . $item->slID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'sliders-status' . $item->slID)) . '
                                <input type="hidden" name="slID" value="' . $item->slID . '">
                                <button type="button" title="' . $txtactive . '" class="text-danger activateBtn"> <i class="fal fa-power-off fa-lg" ' . $active . '></i></button>
                            </form>
                        
                            <form class="edit-sliders-status mx-2" id="edit-sliders-status' . $item->slID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-sliders-status' . $item->slID)) . '
                                <input type="hidden" name="slID" value="' . $item->slID . '">
                                <button type="button" title="Edit Unit" class="text-primary editBtn mx-2" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-edit fa-lg"></i></button>
                            </form>
                         
                            <form class="delete-sliders-status" id="delete-sliders-status' . $item->slID . '"/>'
                                . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-sliders-status' . $item->slID)) . '
                                <input type="hidden" name="slID" value="' . $item->slID . '">
                                <button type="submit" title="Delete Setting" class="text-danger deleteBtn"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </form>
                        
                            </td>   
                        </tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
}