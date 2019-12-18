<?php
//signin.php
include 'simpleconnect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo '<h3>Sign in</h3>';
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['password_1']) && $_SESSION['password_2'] == true)
{
    echo 'You are already signed in, you can <a href="logout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
         </form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        if (isset($_POST['login_user'])) {
          
        $errors = array(); /* declare the array for later use */

        if(!isset($_POST['username']))
        {
            $errors[] = 'The username field must not be empty.';
        }
        if(!isset($_POST['password_1']))
        {
            $errors[] = 'The password field must not be empty.';
        }
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
          	$results = mysqli_query($connection, $query);

            // $results = mysqli_query($connection, $query);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc($connection,$result))
                    {
                        $_SESSION['userid']    = $row['userid'];
                        $_SESSION['username']  = $row['username'];
                        $_SESSION['password'] = $row['password'];
                    }

                    echo 'Welcome, ' . $_SESSION['username'] . '. <a href="simplechat.php">Proceed to the forum overview</a>.';
                }
            }
        }
    }
  }
}
?>