<?php
require_once("../../include/initialize.php");
	  if (!isset($_SESSION['ACCOUNT_ID'])){
     // redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;

	case 'register' :
	doRegister();
	break;
	 
	}
    
	function doInsert(){
		// `IDNO`, `LRN_NO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `AGE`,
		// `BPLACE`, `NATIONALITY`, `RELIGION`, `COURSE_ID`, `STATUS`,
		// `CONTACT_NO`, `EMAIL`, `HOME_ADD`

		$student = new Student();

		$IDNO         = $_POST['IDNO'];
		$LRN_NO       = isset($_POST['LRN_NO'])       ? trim($_POST['LRN_NO'])       : '';
		$FNAME        = $_POST['FNAME'];
		$LNAME        = $_POST['LNAME'];
		$MNAME        = $_POST['MNAME'];
		$SEX          = $_POST['SEX'];
		$BDAY         = $_POST['BDAY'];
		$AGE          = isset($_POST['AGE'])          ? trim($_POST['AGE'])          : '';
		$BPLACE       = isset($_POST['BPLACE'])       ? trim($_POST['BPLACE'])       : '';
		$NATIONALITY  = isset($_POST['NATIONALITY'])  ? trim($_POST['NATIONALITY'])  : '';
		$RELIGION     = isset($_POST['RELIGION'])     ? trim($_POST['RELIGION'])     : '';
		$COURSE_ID    = isset($_POST['COURSE_ID'])    ? intval($_POST['COURSE_ID'])  : 0;
		$STATUS       = isset($_POST['STATUS'])       ? trim($_POST['STATUS'])       : 'Active';
		$CONTACT_NO   = isset($_POST['CONTACT_NO'])   ? trim($_POST['CONTACT_NO'])   : '';
		$EMAIL        = isset($_POST['EMAIL'])        ? trim($_POST['EMAIL'])        : '';
		$HOME_ADD     = isset($_POST['HOME_ADD'])     ? trim($_POST['HOME_ADD'])     : '';

		$res = $student->find_all_student($IDNO);

		if ($res >=1) {
			message("Student IDNO already exist!", "error");
			redirect('index.php');
			return;
		}

		$student->IDNO        = $IDNO;
		$student->LRN_NO      = $LRN_NO;
		$student->FNAME       = $FNAME;
		$student->LNAME       = $LNAME;
		$student->MNAME       = $MNAME;
		$student->SEX         = $SEX;
		$student->BDAY        = $BDAY;
		$student->AGE         = $AGE;
		$student->BPLACE      = $BPLACE;
		$student->NATIONALITY = $NATIONALITY;
		$student->RELIGION    = $RELIGION;
		$student->COURSE_ID   = ($COURSE_ID > 0) ? $COURSE_ID : null;
		$student->STATUS      = $STATUS;
		$student->CONTACT_NO  = $CONTACT_NO;
		$student->EMAIL       = $EMAIL;
		$student->HOME_ADD    = $HOME_ADD;

		$istrue = $student->create();

		if ($istrue == true) {

			/* Photo upload. Saved as <IDNO>.<ext> in module/student/image/,
			   matching student_photo_url() in view.php. No DB column needed. */
			if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] == UPLOAD_ERR_OK) {

				$safeIdno = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$IDNO);
				$ext      = strtolower(pathinfo($_FILES['PHOTO']['name'], PATHINFO_EXTENSION));
				$allowed  = array('jpg', 'jpeg', 'png');

				if ($safeIdno !== '' && in_array($ext, $allowed)) {
					$dest = __DIR__.DIRECTORY_SEPARATOR.'image'.DIRECTORY_SEPARATOR.$safeIdno.'.'.$ext;
					move_uploaded_file($_FILES['PHOTO']['tmp_name'], $dest);
				}
			}

			message("New Student [". $IDNO ."] has been created successfully!", "success");
			redirect('index.php');
		} else {
			message("No user has been created successfully!", "error");
			redirect('index.php');
		}
	}

	function doEdit(){

			$student = new Student();

			$UID   = $_POST['UID'];

			$IDNO         = $_POST['IDNO1'];
			$LRN_NO       = isset($_POST['LRN_NO1'])      ? trim($_POST['LRN_NO1'])      : '';
			$FNAME        = $_POST['FNAME1'];
			$MNAME        = $_POST['MNAME1'];
			$LNAME        = $_POST['LNAME1'];
			$SEX          = isset($_POST['SEX1'])         ? $_POST['SEX1']               : '';
			$BDAY         = isset($_POST['BDAY1'])        ? $_POST['BDAY1']               : '';
			$AGE          = isset($_POST['AGE1'])         ? trim($_POST['AGE1'])          : '';
			$BPLACE       = isset($_POST['BPLACE1'])      ? trim($_POST['BPLACE1'])       : '';
			$NATIONALITY  = isset($_POST['NATIONALITY1']) ? trim($_POST['NATIONALITY1'])  : '';
			$RELIGION     = isset($_POST['RELIGION1'])    ? trim($_POST['RELIGION1'])     : '';
			$COURSE_ID    = isset($_POST['COURSE_ID1'])   ? intval($_POST['COURSE_ID1'])  : 0;
			$STATUS       = isset($_POST['STATUS1'])      ? trim($_POST['STATUS1'])       : '';
			$CONTACT_NO   = isset($_POST['CONTACT_NO1'])  ? trim($_POST['CONTACT_NO1'])   : '';
			$EMAIL        = isset($_POST['EMAIL1'])       ? trim($_POST['EMAIL1'])        : '';
			$HOME_ADD     = isset($_POST['HOME_ADD1'])    ? trim($_POST['HOME_ADD1'])     : '';

			$student->IDNO        = $IDNO;
			$student->LRN_NO      = $LRN_NO;
			$student->FNAME       = $FNAME;
			$student->MNAME       = $MNAME;
			$student->LNAME       = $LNAME;
			$student->AGE         = $AGE;
			$student->BPLACE      = $BPLACE;
			$student->NATIONALITY = $NATIONALITY;
			$student->RELIGION    = $RELIGION;
			$student->CONTACT_NO  = $CONTACT_NO;
			$student->EMAIL       = $EMAIL;
			$student->HOME_ADD    = $HOME_ADD;

			if ($COURSE_ID > 0) {
				$student->COURSE_ID = $COURSE_ID;
			}
			if ($STATUS != '') {
				$student->STATUS = $STATUS;
			}

			/* Only overwrite gender when a real choice was made, so a blank
			   dropdown never wipes an existing value. */
			if ($SEX == 'Male' || $SEX == 'Female') {
				$student->SEX = $SEX;
			}

			/* Same guard for the date: an empty date input must not turn a
			   stored BDAY into 0000-00-00. */
			if ($BDAY != '') {
				$student->BDAY = $BDAY;
			}

			$istrue = $student->update($UID);

			if ($istrue == true){

				/* Optional photo replace. Saved as <IDNO>.<ext>, same
				   convention as doInsert() and student_photo_url(). */
				if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] == UPLOAD_ERR_OK) {

					$safeIdno = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$IDNO);
					$ext      = strtolower(pathinfo($_FILES['PHOTO']['name'], PATHINFO_EXTENSION));
					$allowed  = array('jpg', 'jpeg', 'png');

					if ($safeIdno !== '' && in_array($ext, $allowed)) {
						$dest = __DIR__.DIRECTORY_SEPARATOR.'image'.DIRECTORY_SEPARATOR.$safeIdno.'.'.$ext;
						move_uploaded_file($_FILES['PHOTO']['tmp_name'], $dest);
					}
				}

			 	message("Details has been Updated successfully!", "success");
			 	redirect('index.php');

			 }else{
			 	message("No user account has been updated successfully!", "error");
			 	redirect('index.php');
			 }
	}


	/* -------------------------------------------------------------------
	   STAGE 1 of the enrollment flow: RESERVE

	   Creates the tblenrollment row with STATUS = Reserved. SECTION_ID and
	   DATE_ENROLLED are deliberately left NULL - they get filled in during
	   Stage 2 (Sectioning) on the Enrollment screen.

	   Ends by sending the user to Enrollment so the new reservation is
	   right in front of them, ready to be sectioned.
	   ------------------------------------------------------------------- */
	function doRegister(){

		global $mydb;

		$S_ID       = isset($_POST['R_SID'])           ? intval($_POST['R_SID'])          : 0;
		$SY_ID      = isset($_POST['R_SY'])            ? intval($_POST['R_SY'])           : 0;
		$COURSE_ID  = isset($_POST['R_COURSE'])        ? intval($_POST['R_COURSE'])       : 0;
		$YEAR_LEVEL = isset($_POST['R_YEARLEVEL'])     ? trim($_POST['R_YEARLEVEL'])      : '';
		$SEMESTER   = isset($_POST['R_SEMESTER'])      ? trim($_POST['R_SEMESTER'])       : '';
		$CATEGORY   = isset($_POST['R_CATEGORY'])      ? trim($_POST['R_CATEGORY'])       : 'New';
		$CURRICULUM = isset($_POST['R_CURRICULUM'])    ? trim($_POST['R_CURRICULUM'])     : '';
		$RESERVED   = isset($_POST['R_DATE_RESERVED']) ? trim($_POST['R_DATE_RESERVED'])  : '';

		$enrollmentPage = WEB_ROOT.'module/enrollment/index.php';

		if ($S_ID <= 0 || $SY_ID <= 0 || $COURSE_ID <= 0 || $YEAR_LEVEL == '' || $SEMESTER == '') {
			message("Please complete all the reservation fields.", "error");
			redirect('index.php');
			return;
		}

		if ($RESERVED == '') { $RESERVED = date('Y-m-d'); }

		/* One reservation per student per school year per semester. The
		   database also enforces this with a unique key, but catching it
		   here gives a readable message instead of a PDO error. */
		$mydb->setQuery("SELECT ENROLLMENT_ID FROM `tblenrollment` 
			WHERE S_ID     = '".$S_ID."' 
			  AND SY_ID    = '".$SY_ID."' 
			  AND SEMESTER = '".$mydb->escape_value($SEMESTER)."' 
			LIMIT 1");
		if ($mydb->num_rows() >= 1) {
			message("This student already has a record for that academic year and semester.", "error");
			redirect('index.php');
			return;
		}

		$encodedBy = isset($_SESSION['UID']) ? intval($_SESSION['UID']) : 0;
		$encodedSql = ($encodedBy > 0) ? "'".$encodedBy."'" : "NULL";

		$curriculumSql = ($CURRICULUM == '') ? "NULL" : "'".$mydb->escape_value($CURRICULUM)."'";

		$sql = "INSERT INTO `tblenrollment` 
			(`S_ID`, `COURSE_ID`, `SECTION_ID`, `SY_ID`, `YEAR_LEVEL`, `SEMESTER`, 
			 `CATEGORY`, `CURRICULUM_YR`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`, `ENCODED_BY`) 
			VALUES ('".$S_ID."', '".$COURSE_ID."', NULL, '".$SY_ID."', 
			'".$mydb->escape_value($YEAR_LEVEL)."', '".$mydb->escape_value($SEMESTER)."', 
			'".$mydb->escape_value($CATEGORY)."', ".$curriculumSql.", 
			'".$mydb->escape_value($RESERVED)."', NULL, 'Reserved', ".$encodedSql.")";

		$istrue = $mydb->InsertThis($sql);

		if ($istrue) {

			/* Keep the student record in step with the course they reserved
			   for, so the Student list shows the right program. */
			$mydb->InsertThis("UPDATE `tblstudent` SET `COURSE_ID` = '".$COURSE_ID."' WHERE `S_ID` = '".$S_ID."'");

			message("Slot reserved. Use Sectioning to complete the enrollment.", "success");
			redirect($enrollmentPage);
		} else {
			message("The reservation could not be saved.", "error");
			redirect('index.php');
		}
	}


	


	function doDelete(){
		
				$id = 	$_GET['id'];

				$student = New Student();
	 		 	$student->delete($id);
			 
			message("Student already Deleted!","info");
			redirect('index.php');
		
	}

	
?>