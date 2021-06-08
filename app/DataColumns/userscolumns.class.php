<?php

declare(strict_types=1);

class UsersColumns extends AbstractDatatableColumns
{
    public function columns(): array
    {
        return [
            [
                'db_row' => 'userID',
                'dt_row' => 'mIG',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'firstName',
                'dt_row' => 'First Name',
                'class' => '',
                'show_column' => true,
                'sortable' => true,
                'formatter' => ''
            ],
            [
                'db_row' => 'lastName',
                'dt_row' => 'Last Name',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'userName',
                'dt_row' => 'Username',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'email',
                'dt_row' => 'Email Address',
                'class' => '',
                'show_column' => true,
                'sortable' => true,
                'formatter' => ''
            ],
            [
                'db_row' => 'password',
                'dt_row' => 'Password',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'registerDate',
                'dt_row' => 'Created At',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'updatedAt',
                'dt_row' => 'Modifiedat',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'profileImage',
                'dt_row' => 'Thumbnail',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => 'phone',
                'dt_row' => 'Telephone',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
            [
                'db_row' => '',
                'dt_row' => 'Action',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ]
        ];
    }
}