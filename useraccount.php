<?php
//start session
session_start();

include("lib/dbfunctions.php");


if (isset($_POST['forgotSubmit'])) {
	//check whether email is empty
	if (!empty($_POST['email'])) {
		//check whether user exists in the database
		$reset_email = $_POST['email'];


		$query = " SELECT *  FROM datum " .
			" WHERE TRIM(useremail) = TRIM('" . $reset_email . "')";

		$result = mysqli_query($_SESSION['db_connect'], $query);
		$numrows = mysqli_num_rows($result);


		if ($numrows > 0) {
			//get user details
			$row = mysqli_fetch_array($result);
			$sysuserid = $row['userid'];
			$username  = $row['names'];

			//generat unique string
			$uniqidStr = md5(uniqid(mt_rand()));;

			//update data with forgot pass code
			$query = " update datum set forgot_pass_identity ='" . $uniqidStr . "'" .
				" WHERE TRIM(useremail) = TRIM('" . $reset_email . "')";

			$result = mysqli_query($_SESSION['db_connect'], $query);

			$resetPassLink = 'https://bizmaap..com.ng/resetpassword.php?fp_code=' . $uniqidStr;

			//send reset password email
			$to = $reset_email;
			$subject = "Password Update Request";
			$mailContent = 'Dear ' . $username . ', 
			<br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
			<br/>To reset your password, visit the following link: <a href="' . $resetPassLink . '">' . $resetPassLink . '</a>
			<br/><br/>Your user name is ' . $sysuserid . '
			<br/><br/>Regards,
			<br/> Administrator';
			//set content-type header for sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			//additional headers
			$headers .= 'From:  Support Admin<support@.com.ng>' . "\r\n";
			//send email
			mail($to, $subject, $mailContent, $headers);

			$sessData['status']['type'] = 'success';
			$sessData['status']['msg'] = 'Please check your e-mail, we have sent a password reset link to your registered email.';
		} else {
			$sessData['status']['type'] = 'error';
			$sessData['status']['msg'] = 'Given email is not associated with any account.';
		}
	} else {
		$sessData['status']['type'] = 'error';
		$sessData['status']['msg'] = 'Enter email to create a new password for your account.';
	}
	//store reset password status into the session
	$_SESSION['sessData'] = $sessData;
	//redirect to the forgot pasword page
	header("Location:forgotPassword.php");
} elseif (isset($_POST['resetSubmit'])) {
	$fp_code = '';
	if (!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['fp_code'])) {
		$fp_code = $_POST['fp_code'];
		//password and confirm password comparison
		if ($_POST['password'] !== $_POST['confirm_password']) {
			$sessData['status']['type'] = 'error';
			$sessData['status']['msg'] = 'Confirm password must match with the password.';
		} else {
			//check whether identity code exists in the database

			$query = " SELECT *  FROM datum " .
				" WHERE TRIM(forgot_pass_identity) = TRIM('" . $fp_code . "')";

			$result = mysqli_query($_SESSION['db_connect'], $query);
			$numrows = mysqli_num_rows($result);

			if ($numrows > 0) {
				//update data with new password
				//get user details
				$row = mysqli_fetch_array($result);
				$sysuserid = $row['userid'];
				$username  = $row['names'];
				$password  = $_POST['password'];

				$dbobject  = new dbfunction();
				$cipher_password = $dbobject->des($sysuserid, $password, 1, 0, null, null);
				$str_cipher_password = $dbobject->stringToHex($cipher_password);

				// An UPDATE query is used to add new rows to a database table. 
				// Again, we are using special tokens (technically called parameters) to 
				// protect against SQL injection attacks. 
				$query = "  UPDATE datum SET webpassword = '" . $str_cipher_password .
					"', forgot_pass_identity = '' " .
					" WHERE TRIM(forgot_pass_identity) = TRIM('" . $fp_code . "') and trim(userid) = TRIM('" . $sysuserid . "')";

				$result = mysqli_query($_SESSION['db_connect'], $query);


				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Your account password has been reset successfully. Please login with your new password.';
			} else {
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'You are not authorized to reset new password of this account.';
			}
		}
	} else {
		$sessData['status']['type'] = 'error';
		$sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
	}
	//store reset password status into the session
	$_SESSION['sessData'] = $sessData;
	$redirectURL = ($sessData['status']['type'] == 'success') ? 'index.php' : 'resetpassword.php?fp_code=' . $fp_code;
	//redirect to the login/reset pasword page
	header("Location:" . $redirectURL);
}
