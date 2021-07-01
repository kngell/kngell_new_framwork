<?php
declare(strict_types=1);
class THProducts
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

    public function productsTable(array $data = []) : string
    {
        $output = '';
        $output .= '<table id="ecommerce-datatable" class="table table-middle table-hover table-responsive">
        <thead>
            <tr>
                <th class="no-sort">
                    <label class="custom-checkbox"> <input type="checkbox"><span></span></label>
                </th>
                <th class="no-sort">Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Units Sold</th>
                <th>Status</th>
                <th class="text-center no-sort">Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $item) {
            if ($item->p_status == 1) {
                $status_class = 'bg-success';
                $status_text = 'active';
            } else {
                $status_class = 'bg-danger';
                $status_text = 'inactive';
            }
            $media = !empty($item->p_media) ? ImageManager::asset_img(unserialize($item->p_media)[0]) : ImageManager::asset_img('products' . US . 'product-80x80.jpg');
            $output .= '<tr>
                <td>
                    <label class="custom-checkbox">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </td>
                <td>
                    <a href="ecommerce-product-detail.html">
                        <img class="img-thumbnail" alt="Product" src="' . $media . '" width="48">
                    </a>
                </td>
                <td><a href="' . PROOT . 'admin' . US . 'new_product' . '">' . $item->p_title . '</a></td>
                <td>' . 'Categorie' . '</td>
                <td>' . $item->get_currency($item->p_regular_price) . '</td>
                <td>' . $item->p_qty . '</td>
                <td>2</td>
                <td><span class="badge ' . $status_class . ' rounded">' . $status_text . '</span></td>
                <td>
                    <ul class="list-unstyled table-actions">
                        <li>
                            <form id="edit_product' . $item->pdtID . '">
                                ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit_product' . $item->pdtID)) . '
                                <input type="hidden" name="pdtID" value="' . $item->pdtID . '">
                                <button type="button" title="Edit Product" class="editBtn" data-bs-toggle="modal" data-bs-target="#modal-box"><i class="fal fa-pen"
                                    ></i>
                                </button>
                            </form>
                        </li>
                        <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings"
                                    data-bs-toggle="tooltip"></i></a></li>
                        <li><a href="#"><i class="fal fa-chart-bar"
                                    data-bs-original-title="Analytics"
                                    data-bs-toggle="tooltip"></i></a></li>
                        <li><a href="#"><i class="fal fa-clone"
                                    data-bs-original-title="Duplicate"
                                    data-bs-toggle="tooltip"></i></a></li>
                        <li>
                            <form class="delete-product-frm" id="delete-product-frm' . $item->pdtID . '">
                            ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-product-frm' . $item->pdtID)) . '
                            <input type="hidden" name="pdtID" value="' . $item->pdtID . '">
                                <button type="submit" title="Delete Product" class="deleteBtn"><i class="fal fa-trash" data-bs-original-title="Archive"
                                    data-bs-toggle="tooltip"></i></button></li>
                            </form>
                    </ul>
                </td>
            </tr>';
        }
        $output .= '</tbody></table>';
        return $output;
    }
}