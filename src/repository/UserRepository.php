<?php

class UserRepository
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function validateLogin($username, $password)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT password FROM users WHERE username = :username'
            );
            $statement->execute(array('username' => $username));
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetch();
            $actualPassword = $result['password'];

            return password_verify($password, $actualPassword) == 1 ? true : false;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * All functions relating to users
     */
    function getUserId($username)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT id FROM users WHERE username = :username'
            );
            $statement->execute(array('username' => $username));
            $result = $statement->fetch();

            return $result['id'];
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return null;
    }

    function getUserData($id, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM users
                 INNER JOIN user_access_roles 
                     ON (users.access_role_id = user_access_roles.id) 
                 LEFT JOIN active_drivers 
                     ON (active_drivers.id = users.id) 
                 LEFT JOIN carriers 
                     ON (carriers.id = active_drivers.carrier_id) 
                 WHERE users.id = :id'
            );
            $statement->execute(array('id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetch();
            if (!$result || !count($result)) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
                die('this is why');
                return null;
            }
            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }
            $data = array(
                'id' => $result['id'][0],
                'email' => $result['email'],
                'username' => $result['username'],
                'password' => $result['password'],
                'accessRole' => $result['role'],
                'firstName' => $result['first_name'],
                'lastName' => $result['last_name'],
                'phoneNumber' => $result['phone_number'],
                'carrier' => $result['carrier']
            );

            $user = new User();
            $user->set(json_encode($data));
            return $user;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }


    function createUser($email, $username, $password, $accessRoleId, $firstName, $lastName, $id = null)
    {
        try {
            $statement = $this->connection->prepare(
                'INSERT INTO users(id, email, username, password, access_role_id, first_name, last_name) 
                 VALUES(:id, :email, :username, :password, :access_role_id, :first_name, :last_name)'
            );
            $statement->execute(array(
                ':id' => $id,
                ':email' => $email,
                ':username' => $username,
                ':password' => $password,
                ':access_role_id' => $accessRoleId,
                ':first_name' => $firstName,
                ':last_name' => $lastName,
            ));
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    //TODO
    function updateUser($user)
    {
        if (!($user instanceof User)) {
            echo 'failed to update user, the specified user is invalid:<br />';
            echo $user . '<br />';
            return;
        }
        try {
            $statement = $this->connection->prepare(
                'UPDATE users SET username=:username, password=:password, email=:email WHERE username=:username'
            );
            $statement->bindParam(':username', $user->username);
            $statement->bindParam(':password', $user->password);
            $statement->bindParam(':email', $user->email);
            $statement->execute();
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    //TODO
    function deleteUser($username)
    {
        try {
            $statement = $this->connection->prepare(
                'DELETE FROM users WHERE username = :username'
            );
            $statement->bindParam(':username', $username);
            $statement->execute();
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }
}
