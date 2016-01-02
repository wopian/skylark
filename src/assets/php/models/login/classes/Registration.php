<?php
/**
 * Class registration
 * handles the user registration
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }
    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        if (empty($_POST['driverName'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['driverPassword_new']) || empty($_POST['driverPassword_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['driverPassword_new'] !== $_POST['driverPassword_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['driverPassword_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['driverName']) > 64 || strlen($_POST['driverName']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['driverName'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['driverEmail'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['driverEmail']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['driverEmail'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['driverName'])
            && strlen($_POST['driverName']) <= 64
            && strlen($_POST['driverName']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['driverName'])
            && !empty($_POST['driverEmail'])
            && strlen($_POST['driverEmail']) <= 64
            && filter_var($_POST['driverEmail'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['driverPassword_new'])
            && !empty($_POST['driverPassword_repeat'])
            && ($_POST['driverPassword_new'] === $_POST['driverPassword_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escaping, additionally removing everything that could be (html/javascript-) code
                $driverName = $this->db_connection->real_escape_string(strip_tags($_POST['driverName'], ENT_QUOTES));
                $driverEmail = $this->db_connection->real_escape_string(strip_tags($_POST['driverEmail'], ENT_QUOTES));
                $driverPassword = $_POST['driverPassword_new'];
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $driverHash = password_hash($driverPassword, PASSWORD_DEFAULT);
                // check if user or email address already exists
                $sql = "SELECT * FROM drivers WHERE driverName = '" . $driverName . "' OR driverEmail = '" . $driverEmail . "';";
                $query_check_driverName = $this->db_connection->query($sql);
                if ($query_check_driverName->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO drivers (driverName, driverHash, driverEmail)
                            VALUES('" . $driverName . "', '" . $driverHash . "', '" . $driverEmail . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);
                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
