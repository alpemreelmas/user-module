<?php
// NESTED
return [
        "title" => "User Management",
        "permission" => "user_access",
        "data-feather-icon" => "users",
        "routes" => [
            [
                "title" => "Users",
                "route" => url("/user-management/users"),
                "permission" => "user_access"
            ],
            [
                "title" => "Roles",
                "route" => url("/user-management/roles"),
                "permission" => "role_access"
            ],
            "Permissions" => url("/user-management/permissions")
        ],
];
// SINGLE
/*return [
    "title" => "User Management",
    "permission" => "user_access",
    "data-feather-icon" => "users",
    "routes" => url("/user-management/permissions")
];*/
