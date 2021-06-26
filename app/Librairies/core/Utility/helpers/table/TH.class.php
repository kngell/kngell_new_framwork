<?php
class TH
{
    //=======================================================================
    //comments table
    //=======================================================================

    public static function commentsTable($data)
    {
        $output ='';
        foreach ($data as $comment) {
            $output .= $comment->outputComment();
        }
        return $output;
    }
    //=======================================================================
    //Realisation table
    //=======================================================================

    public static function realisationsTable($data)
    {
        $output ='';
        foreach ($data as $rea) {
            $output .= $rea->outputRealisations();
        }
        return $output;
    }
    //=======================================================================
    //Realisation table
    //=======================================================================
    public static function searchTable($tables, $model, $data)
    {
        $output = '';
        foreach ($tables as $table) {
            $table_name = $table->{"Tables_in_blogkngell"};
            if ($table_name == 'posts') {
                $fields = [];
                $columns = $model->get_columns($table_name);
                foreach ($columns as $column) {
                    $fields[$column->Field] = $data['search'];
                }
                $output .= $model->outputSearchList($table_name, $fields);
            }
        }
        return $output;
    }
    //=======================================================================
    //Session formation table
    //=======================================================================
    public static function sessions_formationsTable($data)
    {
        $output ='';
        foreach ($data as $session) {
            $output .= $session->outputSession();
        }
        return $output;
    }
    //=======================================================================
    //Section pagination
    //=======================================================================
    public static function pagination($html_result, $model, $item)
    {
        $total_rows = $model->getAllItem()->count();
        $total_page = ceil($total_rows/$item['max']);
        if ($total_rows > $item['max']) {
            $html_result .= '<div class="pagination flex-row">
            <a href="javascript:void(0)" class="previous"><i class="fas fa-chevron-left"></i></a>';
            for ($i=1; $i <= $total_page; $i++) {
                $active = ($i == $item['page']) ? "active" : "";
                $html_result .= '<a href="javascript:void(0)" class="pages '. $active .'" id="'. $i .'">'. $i .'</a>';
            }
            $html_result .= '<a href="javascript:void(0)" class="next"><i class="fas fa-chevron-right"></i></a>
            </div>
            <div id="total_pages" style="display:none">'.$total_page.'</div>';
        }
        return $html_result;
    }
    //=======================================================================
    //Offre d'emploi
    //=======================================================================
    public static function offre_emploiTable($data)
    {
        $output = ' <table class="table table-bordered my_table">
        <thead class="table-head">
            <tr>
                <th>Date</th>
                <th>Poste</th>
                <th>Lieu</th>
                <th>Contrat</th>
            </tr>
        </thead>
        <tbody class="">';
        foreach ($data as $row) {
            $output .= '<tr id ="'. $row->ofemID .'">
            <td>' . $row->getfrontDate($row->updateAt) .'
            </td>
            <td>' . $row->titre .'
            </td>
            <td>' . $row->lieu .'
            </td>
             <td>' . $row->contrat .'
            </td>
            </tr>';
        }
        $output .= '</tbody>
        </table>';
        return $output;
    }
}