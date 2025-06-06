<?php

namespace App\Controllers;

class dashboardcontroller
{
    public static function redirectToDashboard($roleId)
    {
        switch ($roleId) {
            case 1:
                header('Location: /dashboard/admin/index.php');
                break;
            case 2:
                header('Location: /dashboard/receptionist/index.php');
                break;
            case 3:
                header('Location: /dashboard/manager/transport/index.php');
                break;
            case 4:
                header('Location: /dashboard/manager/cleaning/index.php');
                break;
            case 5:
                header('Location: /dashboard/manager/kitchen/index.php');
                break;
            case 6:
                header('Location: /dashboard/driver/index.php');
                break;
            case 7:
                header('Location: /dashboard/cleaner/index.php');
                break;
            case 8:
                header('Location: /dashboard/kitchen_staff/index.php');
                break;
            default:
                header('Location: /auth/login.php');
                break;
        }

        exit;
    }
}
