<?php
declare(strict_types=1);
class THOrders
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
     * Order Data table
     * ===============================================================================================
     * @return string
     */
    public function ordersTable(array $data = []) : string
    {
        $output = '';
        $output .= '<table class="table table-middle table-hover">
        <thead>
            <tr>
                <th>
                    <label class="custom-checkbox">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </th>
                <th>Order</th>
                <th>Date</th>
                <th>Status</th>
                <th>Billing to</th>
                <th>Ship to</th>
                <th>Total</th>
                <th class="text-center" style="width: 100px;">Action</th>
            </tr>
        </thead>
                    <tbody>';
        foreach ($data as $order) {
            $ord_status = $this->get_OrdersStatus($order->ord_status);
            $ord_billing_addr = $this->get_OrderAddress($order->ord_billing_addr);
            $ord_delivery_addr = $this->get_OrderAddress($order->ord_delivery_addr);
            $output .= ' <tr>
                            <td>
                                <label class="custom-checkbox index-checkbox">
                                    <input type="checkbox">
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <a href="#"><strong>' . $order->ord_number . '&nbsp;' . '' . $order->firstName . '&nbsp;' . $order->lastName . '</strong>
                                </a>
                            </td>
                            <td>' . H::time_in_ago((new DateTime($order->created_at))->getTimestamp()) . '</td>
                            <td><span class="' . $ord_status['class'] . '">' . $ord_status['status'] . '</span></td>
                
                            <td>' . $ord_billing_addr . '
                                <span class="d-block"><i>via Cash on delivery</i></span>
                            </td>
                            <td><a target="_blank" href="#">' . $ord_delivery_addr . '</a></td>
                            <td class="price">' . $order->get_currency($order->ord_amountTTC) . '</td>
                            <td>
                                <ul class="list-unstyled table-actions">
                                    <li>
                                        <form class="edit-order" id="edit-order' . $order->ordID . '">
                                        ' . FH::csrfInput('csrftoken', $this->token->generate_token(8, 'edit-order' . $order->ordID)) . '
                                        <input type="hidden" name="brID" value="' . $order->ordID . '">
                                            <button type="button"><i class="fal fa-pen"
                                                data-bs-original-title="Edit"
                                                data-bs-toggle="tooltip"></i>
                                            </button>
                                        </form>
                                    </li>
                                    <li><button type="button"><i class="fal fa-chart-bar"
                                            data-bs-original-title="Analytics"
                                            data-bs-toggle="tooltip"></i></button></li>
                                    <li><button type="button"><i class="fal fa-trash" data-bs-original-title="Archive"
                                            data-bs-toggle="tooltip"></i></button></li>
                                </ul>
                            </td>
                        </tr>';
        }
        $output .= '</tbody></table>';
        return $output;
    }

    /**
     * Get Order Status
     *
     * @param string $order
     * @return array
     */
    private function get_OrdersStatus(string $order) : array
    {
        switch ($order) {
            case 'traitement':
                $status = 'Processing';
                $status_class = 'badge bg-info rounded';
                break;
            case 'preparation':
                $status = 'On hold';
                $status_class = 'badge bg-warning rounded';
                break;
            case 'livraison':
                $status = 'On Shipping';
                $status_class = 'badge bg-secondary rounded';
                break;
            case 'livré':
                $status = 'Completed';
                $status_class = 'badge bg-success rounded';
                break;

            default:
                $status = 'On Error';
                $status_class = 'badge bg-danger rounded';
                break;
        }
        return ['status' => $status ?? '', 'class' => $status_class ?? ''];
    }

    /**
     * Get Order Address
     *
     * @param array $addr
     * @return string
     */
    private function get_OrderAddress(array $addr = []) : string
    {
        if (isset($addr) && count($addr) === 1) {
            $addr = current($addr);
            return $addr->htmlDecode($addr->address1 . ',&nbsp;' . $addr->address2 . ',&nbsp;' . $addr->zip_code . ',&nbsp;' . $addr->ville . ',&nbsp;' . $addr->region . ',&nbsp;' . $addr->pays);
        }
    }
}