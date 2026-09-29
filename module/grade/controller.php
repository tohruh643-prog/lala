<?php
require_once("../../include/initialize.php");
global $mydb;

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'save') {
    doSaveGrades();
} else if ($action == 'delete_grades') {
    doDeleteGradeHistory();
} else {
    redirect('index.php');
}

/*
 * GRADING RULE USED BY THIS PROJECT:
 *
 * Grade scale: 0 - 100 (Philippine percentage grading)
 * 75 to 100 = Passed
 * 0 to 74.99 = Failed
 *
 * Incomplete and Dropped are manual remarks.
 *
 * The rule is checked again here on the server, so a user cannot
 * save a wrong Passed/Failed value just by changing the HTML.
 */
function calculateGradeRemark($grade, $manualRemark) {

    $manualRemark = trim($manualRemark);

    if ($manualRemark === 'No Grade' || $manualRemark === 'Incomplete' || $manualRemark === 'Dropped') {
        return $manualRemark;
    }

    if ($grade === '' || $grade === null) {
        return '';
    }

    $grade = floatval($grade);

    if ($grade < 0 || $grade > 100) {
        return '';
    }

    return ($grade >= 75) ? 'Passed' : 'Failed';
}

function doSaveGrades() {
    global $mydb;

    $eid = isset($_POST['GRADE_EID']) ? intval($_POST['GRADE_EID']) : 0;

    if ($eid <= 0) {
        message("No enrollment record selected.", "error");
        redirect('index.php');
        return;
    }

    $mydb->setQuery("SELECT S_ID, SY_ID, SEMESTER
        FROM `tblenrollment`
        WHERE ENROLLMENT_ID = '".$eid."'
        LIMIT 1");

    $rows = $mydb->loadResultList();

    if (count($rows) < 1) {
        message("That enrollment record no longer exists.", "error");
        redirect('index.php');
        return;
    }

    $enr = $rows[0];

    $subjectIds = (isset($_POST['GRADE_SUBJECT_ID']) && is_array($_POST['GRADE_SUBJECT_ID']))
        ? $_POST['GRADE_SUBJECT_ID'] : array();

    $gradeValues = (isset($_POST['GRADE_VALUE']) && is_array($_POST['GRADE_VALUE']))
        ? $_POST['GRADE_VALUE'] : array();

    $remarksValues = (isset($_POST['GRADE_REMARKS']) && is_array($_POST['GRADE_REMARKS']))
        ? $_POST['GRADE_REMARKS'] : array();

    $savedCount = 0;

    foreach ($subjectIds as $sidRaw) {

        $subjectId = intval($sidRaw);
        if ($subjectId <= 0) {
            continue;
        }

        /* Make sure this subject actually belongs to this enrollment. */
        $mydb->setQuery("SELECT SUBJECT_ID
            FROM `tblenrollmentdetails`
            WHERE ENROLLMENT_ID = '".$eid."'
            AND SUBJECT_ID = '".$subjectId."'
            LIMIT 1");

        $validSubject = $mydb->loadResultList();

        if (count($validSubject) < 1) {
            continue;
        }

        $gradeVal = isset($gradeValues[$subjectId])
            ? trim($gradeValues[$subjectId]) : '';

        $manualRemark = isset($remarksValues[$subjectId])
            ? trim($remarksValues[$subjectId]) : '';

        /* Allow only the three manual remarks. */
        $allowedRemarks = array('No Grade', 'Incomplete', 'Dropped');
        if (!in_array($manualRemark, $allowedRemarks, true)) {
            $manualRemark = '';
        }

        /*
         * Numerical grades always determine Passed/Failed automatically.
         * Manual remarks are only allowed when the grade is blank.
         */
        if ($gradeVal === '') {
            $remarksVal = calculateGradeRemark('', $manualRemark);
            $gradeSql = 'NULL';
        } else {
            $gradeNumber = floatval($gradeVal);

            if ($gradeNumber < 0 || $gradeNumber > 100) {
                message("Grade must be between 0 and 100.", "error");
                redirect('index.php');
                return;
            }

            $remarksVal = calculateGradeRemark($gradeNumber, '');
            $gradeSql = "'".$gradeNumber."'";
        }

        $remarksSql = ($remarksVal === '')
            ? 'NULL'
            : "'".$mydb->escape_value($remarksVal)."'";

        /*
         * If nothing was entered for this subject, do not create a
         * blank grade record.
         */
        if ($gradeVal === '' && $remarksVal === '') {
            continue;
        }

        $mydb->setQuery("SELECT GRADE_ID
            FROM `tblgrades`
            WHERE ENROLLMENT_ID = '".$eid."'
            AND SUBJECT_ID = '".$subjectId."'
            LIMIT 1");

        $existing = $mydb->loadResultList();

        if (count($existing) >= 1) {

            $gradeId = intval($existing[0]->GRADE_ID);

            $mydb->InsertThis("UPDATE `tblgrades`
                SET GRADE = ".$gradeSql.",
                    REMARKS = ".$remarksSql.",
                    DATE_ENCODED = CURDATE()
                WHERE GRADE_ID = '".$gradeId."'");

        } else {

            $mydb->InsertThis("INSERT INTO `tblgrades`
                (S_ID, SUBJECT_ID, ENROLLMENT_ID, SY_ID, SEMESTER,
                 GRADE, REMARKS, DATE_ENCODED)
                VALUES
                ('".intval($enr->S_ID)."',
                 '".$subjectId."',
                 '".$eid."',
                 '".intval($enr->SY_ID)."',
                 '".$mydb->escape_value($enr->SEMESTER)."',
                 ".$gradeSql.",
                 ".$remarksSql.",
                 CURDATE())");
        }

        $savedCount++;
    }

    if ($savedCount > 0) {
        message($savedCount." grade(s) saved successfully.", "success");
    } else {
        message("No grades were entered.", "info");
    }

    redirect('index.php');
}

function doDeleteGradeHistory() {
    global $mydb;

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        message("No history record selected.", "error");
        redirect('index.php');
        return;
    }

    $mydb->setQuery("SELECT HISTORY_ID
        FROM `tblhistoryenrollment`
        WHERE ENROLLMENT_ID = '".$id."'
        LIMIT 1");

    if ($mydb->num_rows() < 1) {
        message("That history record no longer exists.", "error");
        redirect('index.php');
        return;
    }

    $mydb->setQuery("SELECT GRADE_ID
        FROM `tblgrades`
        WHERE ENROLLMENT_ID = '".$id."'");

    $gradeCount = $mydb->num_rows();

    if ($gradeCount < 1) {
        message("There are no grade records to delete for this enrollment.", "info");
        redirect('index.php');
        return;
    }

    if ($mydb->InsertThis("DELETE FROM `tblgrades`
        WHERE `ENROLLMENT_ID` = '".$id."'")) {

        message($gradeCount." grade record(s) deleted.", "info");

    } else {
        message("The grade record(s) could not be deleted.", "error");
    }

    redirect('index.php');
}
?>
