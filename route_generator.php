<?php
return [
    "routes" => [
        "User Management" => [
            "Users" => [
                "route" => url("/user-management/users"),
                "permission" => "user_access"
            ],
            "Roles" => [
                "route" => url("/user-management/roles"),
                "permission" => "role_access"
            ],
            "Permissions" => url("/user-management/permissions")
        ],
        "permission" => "user_access"
    ]
];
