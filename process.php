<?php

ob_start();
include_once "session_track.php";

require_once("lib/mfbconnect.php");


if (isset($_POST)) {

    //form validation vars
    $formok = true;
    $errors = array();

    //submission data
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $date = date('d/m/Y');
    $time = date('H:i:s');

    //form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $enquiry = $_POST['enquiry'];
    $message = $_POST['message'];

    //validate form data

    //validate name is not empty
    if (empty($name)) {
        $formok = false;
        $errors[] = "You have not entered a name";
    }

    //validate email address is not empty
    if (empty($email)) {
        $formok = false;
        $errors[] = "You have not entered an email address";
        //validate email address is valid
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formok = false;
        $errors[] = "You have not entered a valid email address";
    }

    //validate message is not empty
    if (empty($message)) {
        $formok = false;
        $errors[] = "You have not entered a message";
    }
    //validate message is greater than 20 characters
    elseif (strlen($message) < 20) {
        $formok = false;
        $errors[] = "Your message must be greater than 20 characters";
    }

    $sql_QueryStmt = "SELECT * from const where 1 = 1";


    $result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);

    $officialemail = "info@.com.ng";
    $count_QueryStmt = mysqli_num_rows($result_QueryStmt);
    if ($count_QueryStmt > 0) {
        $row_QueryStmt = mysqli_fetch_array($result_QueryStmt);
        $officialemail = $row_QueryStmt['email'];
    }


    //send email if all is ok
    if ($formok) {
        $headers = 'From: ' . $email . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n ";

        $emailbody = "<p>You have received a new message from the enquiries form on your website.</p>
                      <p><strong>Name: </strong> {$name} </p>
                      <p><strong>Email Address: </strong> {$email} </p>
                      <p><strong>Telephone: </strong> {$telephone} </p>
                      <p><strong>Enquiry: </strong> {$enquiry} </p>
                      <p><strong>Message: </strong> {$message} </p>
                      <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";

        mail($officialemail, $enquiry, $emailbody, $headers);
    }



    //send email if all is ok to acknowledge the receipt of feedback to the visitor
    if ($formok) {
        $headers = "From:  Technologies <info@.com.ng>" . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $emailbody = "<p><strong>Dear </strong> {$name} </p>
                      <p><strong>We have received your feedback. We are very appreciative of your response and submission.</strong>  </p>
                      <p><strong>We will get back to you on this matter: </strong> </p>
                      <p><strong>Yours truly: </strong> </p>
                      <p><strong>for:  EstateAdmin </strong>  </p>
                      <p>https://.com.ng</p>";

        mail($email, "Thanks for your Submission", $emailbody, $headers);
    }


    //what we need to return back to our form
    $returndata = array(
        'posted_form_data' => array(
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
            'enquiry' => $enquiry,
            'message' => $message
        ),
        'form_ok' => $formok,
        'errors' => $errors
    );


    $_SESSION['cf_returndata'] = $returndata;

    //redirect back to form
    header('location: ' . $_SERVER['HTTP_REFERER']);
}
