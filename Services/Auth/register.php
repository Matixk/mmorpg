<?php

http_response_code(400);

$rootFolder = dirname(__FILE__) . "/../../";

require_once $rootFolder .  "Entities/Users/User.php";
require_once $rootFolder .  "Entities/Users/Role.php";
require_once $rootFolder . "Entities/Users/Status.php";
require_once $rootFolder . "Utils/databaseConnection.php";

use entities\Users\User;
use entities\Users\Role;
use entities\Users\Status;

if (isset($_POST["name"]) && isset($_POST["password"]))
{
    $user = new User();
    $user->roleId = Role::User;
    $user->statusId = Status::Active;
    $user->name = mysqli_real_escape_string($connection, $_POST["name"]);
    $user->password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $query = sprintf("INSERT INTO %s (role_id, status_id, name, password) VALUES
        (%d, %d, '%s', '%s')", User::TABLE_NAME, $user->roleId, $user->statusId, $user->name, $user->password);

    if (mysqli_query($connection, $query)) {
        $query = "SELECT * FROM daily_stats WHERE DATE_FORMAT(date, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d');";
        $result = $connection->query($query);

        if ($result->num_rows != 0)
        {
            $stats = $result->fetch_object();
            $stats->registered += 1;

            $query = sprintf("UPDATE daily_stats SET register = '%s' WHERE id = %d;",
                $stats->registered, $stats->id);
        }
        else
        {
            $query = "INSERT INTO daily_stats (registered, data) VALUES ('1', NOW())";
            $connection->query($query);
        }

        http_response_code(201);
        session_start();
        $userSerialized = json_encode(array(
            "id" => mysqli_insert_id($connection),
            "roleId" => $user->roleId,
            "statusId" => $user->statusId,
            "name" => $user->name,
            "created" => $user->created
        ));

        $_SESSION["user"] = $userSerialized;
        echo json_encode(array("message" => "User created."));
    } else {
        echo json_encode(array(
            "error" => mysqli_error($connection),
            "query" => $query));
    }
}
else
{
    echo json_encode(array("error" => "Unable to create user. Wrong data!"));
}

$connection->close();