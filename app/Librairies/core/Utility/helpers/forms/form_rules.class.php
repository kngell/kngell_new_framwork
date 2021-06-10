<?php
class Form_rules
{
    // =======================================================================
    // Users section
    // =======================================================================
    // Users groups
    public static function groups()
    {
        return [
            'name' => [
                'display' => 'Group Name',
                'required' => true,
                'max' => 65,
                'unique' => 'groups',
            ],
        ];
    }

    // Units validation
    public static function units()
    {
        return [
            'unit' => [
                'display' => 'Unit',
                'required' => true,
                'max' => 65,
                'unique' => 'units',
            ],
        ];
    }

    //Users datas
    public static function users()
    {
        return [
            'terms' => [
                'required' => true,
                'display' => ''
            ],
            'firstName' => [
                'required' => true,
                'min' => 2,
                'max' => 64,
                'display' => 'Firstname'
            ],
            'lastName' => [
                'required' => true,
                'min' => 2,
                'max' => 64,
                'display' => 'Lastname'
            ],
            'userName' => [
                'display' => 'Username',
                'required' => true,
                'unique' => 'users',
                'min' => 2,
                'max' => 20
            ],
            'email' => [
                'display' => 'Email',
                'required' => true,
                'unique' => 'users',
                'max' => 150,
                'valid_email' => true
            ],
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 5,
                'max' => 64
            ],
            'cpassword' => [
                'display' => 'Confirm Password',
                'required' => true,
                'min' => 5,
                'matches' => 'password'
            ]
        ];
    }

    //login rules
    public static function login()
    {
        return [
            'email' => [
                'display' => 'Email',
                'required' => true,
                'valid_email' => true
            ],
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 5
            ]
        ];
    }

    public static function change_pass_admin_user()
    {
        return [
            'curpass' => [
                'display' => 'Current Password',
                'required' => true,
                'max' => 65,
                'min' => 5
            ],
            'newpass' => [
                'display' => 'New Password',
                'required' => true,
                'min' => 5,
            ],
            'cnewpass' => [
                'display' => 'Confirm New Password',
                'required' => true,
                'min' => 5,
                'matches' => 'newpass'
            ]
        ];
    }

    public static function forgot()
    {
        return [
            'email' => [
                'display' => 'Email',
                'required' => true,
                'valid_email' => true
            ]
        ];
    }

    public static function resetPass()
    {
        return [
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 5
            ],
            'cpassword' => [
                'display' => 'Confirm Password',
                'required' => true,
                'min' => 5,
                'matches' => 'password'
            ]
        ];
    }

    public static function admin_login()
    {
        return [
            'username' => [
                'display' => 'Username',
                'required' => true,
                'min' => 5,
                'max' => 65
            ],
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 5,
                'max' => 65
            ]
        ];
    }

    // =======================================================================
    // Product section
    // =======================================================================
    //Add categories rules
    public static function categories()
    {
        return [
            'categorie' => [
                'display' => 'Categorie',
                'required' => true,
                'unique' => 'categories',
                'max' => 45
            ],
        ];
    }

    public static function products()
    {
        return [
            'p_title' => [
                'display' => 'Product title',
                'required' => true,
                'min' => 2,
                'max' => 150
            ],
            'p_short_descr' => [
                'display' => 'Product short description',
                'required' => true,
                'min' => 2,
                'max' => 255
            ],
            'p_regular_price' => [
                'display' => 'Price',
                'is_numeric' => true
            ]
        ];
    }

    // =======================================================================
    // Companies
    // =======================================================================
    public static function company()
    {
        return [
            'denomination' => [
                'display' => 'Company Name',
                'required' => true,
                'min' => 2,
                'max' => 150
            ],
            'couriel' => [
                'display' => 'E-Mail',
                'required' => true,
                'min' => 2,
                'max' => 155,
                'valid_email' => true,
                'unique' => 'company',
            ],
        ];
    }

    // =======================================================================
    // Checkout
    // =======================================================================
    // Infos contact
    public static function infos_contact()
    {
        return [
            'firstName' => [
                'display' => 'First Name',
                'required' => true,
                'min' => 2,
                'max' => 64
            ],
            'lastName' => [
                'display' => 'Last Name',
                'required' => true,
                'min' => 2,
                'max' => 64,
            ],
            'email' => [
                'display' => 'E-Mail',
                'required' => true,
                'min' => 2,
                'max' => 150,
                'valid_email' => true,
                'unique' => 'users',
            ],
            'address' => [
                'display' => 'Adresse',
                'required' => true,
            ],
            'ville' => [
                'display' => 'Ville',
                'required' => true,
            ],
            'zip_code' => [
                'display' => 'Code Postal',
                'required' => true,
            ],
        ];
    }
}
