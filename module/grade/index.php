<?php
require_once("../../include/initialize.php");

$title   = "Grades";
$header  = "";
$content = 'list.php';

require_once("../../theme/template.php");
?>

<script type="text/javascript">
var gradeTable;
var gradeHistoryTable;

/* Escape text before putting AJAX values into HTML. */
function escapeHtml(value) {
    return $('<div>').text(value == null ? '' : value).html();
}

/*
 * Philippine percentage grading used by this module:
 * 75 - 100 = Passed
 * 0 - 74.99 = Failed
 * Blank grade = manual No Grade / Dropped / Incomplete
 */
function calculateRemark(grade, currentRemark) {

    if (grade === '' || grade === null || grade === undefined) {
        if (currentRemark === 'No Grade' ||
            currentRemark === 'Incomplete' ||
            currentRemark === 'Dropped') {
            return currentRemark;
        }
        return '';
    }

    var number = parseFloat(grade);

    if (isNaN(number) || number < 0 || number > 100) {
        return '';
    }

    return number >= 75 ? 'Passed' : 'Failed';
}

function updateRemarkStyle(select) {

    select.removeClass('border-success border-danger border-warning');

    if (select.val() === 'Passed') {
        select.addClass('border-success');
    } else if (select.val() === 'Failed') {
        select.addClass('border-danger');
    } else if (select.val() === 'No Grade' ||
               select.val() === 'Incomplete' ||
               select.val() === 'Dropped') {
        select.addClass('border-warning');
    }
}

/* Keep the remark synchronized with the grade. */
function updateRemark(subjectId) {

    var gradeInput = $('input[name="GRADE_VALUE[' + subjectId + ']"]');
    var select = $('select[name="GRADE_REMARKS[' + subjectId + ']"]');
    var grade = gradeInput.val();

    if (grade === '') {
        select.prop('disabled', false);

        if (!select.val()) {
            select.val('No Grade');
        }

        updateRemarkStyle(select);
        return;
    }

    var remark = calculateRemark(grade, '');

    select.val(remark);
    select.prop('disabled', true);
    updateRemarkStyle(select);
}

$(document).ready(function() {

    gradeTable = $('#tblgradestudents').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "order": [],
        "ajax": {
            url: "<?php echo WEB_ROOT; ?>module/grade/ajax.php",
            type: "POST",
            data: function(d) {
                d.act = 'list';
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [6] }
        ]
    });

    gradeHistoryTable = $('#tblgradehistory').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "order": [],
        "ajax": {
            url: "<?php echo WEB_ROOT; ?>module/grade/ajax.php",
            type: "POST",
            data: function(d) {
                d.act = 'history_list';
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [0, 6, 7, 8] }
        ]
    });
});

/* ============================================================
   OPEN ENCODE GRADES
   ============================================================ */
function openGradeModal(eid) {

    $('#GRADE_SUBJECTS_TBODY').html(
        '<tr><td colspan="3" class="text-muted text-center">Loading...</td></tr>'
    );

    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/grade/ajax.php",
        method: "POST",
        data: {
            act: 'subjects',
            ENROLLMENT_ID: eid
        },
        dataType: "json",

        success: function(d) {

            if (!d.ENROLLMENT_ID) {
                alert('Could not load that enrollment record.');
                return;
            }

            $('#GRADE_EID').val(d.ENROLLMENT_ID);
            $('#GRADE_IDNO_TEXT').text(d.IDNO || '-');
            $('#GRADE_NAME_TEXT').text(d.FULLNAME || '-');
            $('#GRADE_COURSE_TEXT').text(d.COURSE_TEXT || '-');
            $('#GRADE_TERM_TEXT').text(d.TERM_TEXT || '-');

            $('#GRADE_PICTURE').attr(
                'src',
                d.PICTURE_URL
                    ? d.PICTURE_URL
                    : '<?php echo WEB_ROOT; ?>module/student/image/1.png'
            );

            var rows = '';

            if (!d.subjects || d.subjects.length === 0) {

                rows =
                    '<tr>' +
                    '<td colspan="3" class="text-muted text-center">' +
                    'No subjects taken yet for this enrollment.' +
                    '</td>' +
                    '</tr>';

            } else {

                $.each(d.subjects, function(i, s) {

                    var subjectId = parseInt(s.SUBJECT_ID, 10);
                    var gradeValue =
                        (s.GRADE !== null && s.GRADE !== undefined)
                        ? s.GRADE
                        : '';

                    var savedRemark = s.REMARKS || '';

                    /*
                     * If the saved remark is not Incomplete/Dropped,
                     * calculate Passed/Failed again from the grade.
                     */
                    var remark = calculateRemark(
                        gradeValue,
                        savedRemark
                    );

                    var remarksOptions =
                        '<option value="">-- Remarks --</option>' +
                        '<option value="No Grade">No Grade</option>' +
                        '<option value="Dropped">Dropped</option>' +
                        '<option value="Incomplete">Incomplete</option>';

                    rows +=
                        '<tr>' +

                        '<td>' +
                            escapeHtml(s.SUBJECT_CODE) +
                            '<div class="text-muted small">' +
                                escapeHtml(s.SUBJECT_NAME) +
                            '</div>' +
                        '</td>' +

                        '<td width="25%">' +

                            '<input type="hidden" ' +
                                'name="GRADE_SUBJECT_ID[]" ' +
                                'value="' + subjectId + '">' +

                            '<input type="number" ' +
                                'step="0.01" min="0" max="100" ' +
                                'class="form-control form-control-sm grade-input" ' +
                                'name="GRADE_VALUE[' + subjectId + ']" ' +
                                'data-subject-id="' + subjectId + '" ' +
                                'value="' + escapeHtml(gradeValue) + '" ' +
                                'placeholder=" ">' +

                            '<small class="text">' +
                                '75-100 Passed, 0-74.99 Failed' +
                            '</small>' +

                        '</td>' +

                        '<td width="30%">' +

                            '<select ' +
                                'class="form-control form-control-sm grade-remarks" ' +
                                'name="GRADE_REMARKS[' + subjectId + ']" ' +
                                'data-subject-id="' + subjectId + '">' +

                                remarksOptions +

                            '</select>' +

                            '<small class="text-remark-help">' +
                                'Passed/Failed are automatic. ' +
                                'No Grade, Dropped, or Incomplete are manual when no grade is entered.' +
                            '</small>' +

                        '</td>' +

                        '</tr>';

                    /* Set selected option after HTML is created. */
                    setTimeout(function() {

                        var select = $(
                            'select[name="GRADE_REMARKS[' +
                            subjectId + ']"]'
                        );

                        if (gradeValue === '' || gradeValue === null || gradeValue === undefined) {
                            select.val(remark || 'No Grade');
                            select.prop('disabled', false);
                        } else {
                            select.val(remark);
                            select.prop('disabled', true);
                        }

                        updateRemarkStyle(select);

                    }, 0);
                });
            }

            $('#GRADE_SUBJECTS_TBODY').html(rows);

            /*
             * The setTimeout calls above should happen after the table
             * has been inserted. Re-apply saved remarks now for safety.
             */
            if (d.subjects) {
                $.each(d.subjects, function(i, s) {

                    var subjectId = parseInt(s.SUBJECT_ID, 10);
                    var gradeValue =
                        (s.GRADE !== null && s.GRADE !== undefined)
                        ? s.GRADE
                        : '';

                    var savedRemark = s.REMARKS || '';
                    var remark = calculateRemark(gradeValue, savedRemark);

                    var select = $(
                        'select[name="GRADE_REMARKS[' +
                        subjectId + ']"]'
                    );

                    if (gradeValue === '' || gradeValue === null || gradeValue === undefined) {
                        select.val(remark || 'No Grade');
                        select.prop('disabled', false);
                    } else {
                        select.val(remark);
                        select.prop('disabled', true);
                    }
                    updateRemarkStyle(select);
                });
            }

            $('#gradeModal').modal('show');
        },

        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Could not load that enrollment record.');
        }
    });
}

$(document).on('click', '.doGrade', function() {
    openGradeModal($(this).attr('EID'));
});

/* ============================================================
   GRADE INPUT -> AUTOMATIC PASSED/FAILED
   ============================================================ */
$(document).on('input', '.grade-input', function() {

    var subjectId = $(this).data('subject-id');
    var value = $(this).val();
    var number = parseFloat(value);
    var select = $('select[name="GRADE_REMARKS[' + subjectId + ']"]');

    if (value === '') {
        select.prop('disabled', false);
        select.val('No Grade');
        updateRemarkStyle(select);
        return;
    }

    if (!isNaN(number) && number >= 0 && number <= 100) {
        select.val(number >= 75 ? 'Passed' : 'Failed');
        select.prop('disabled', true);
        updateRemarkStyle(select);
    }
});

/* ============================================================
   MANUAL NO GRADE / DROPPED / INCOMPLETE
   ============================================================ */
$(document).on('change', '.grade-remarks', function() {

    var select = $(this);
    var subjectId = select.data('subject-id');
    var gradeInput = $('input[name="GRADE_VALUE[' + subjectId + ']"]');

    /* Manual remarks require an empty grade. */
    if (select.val() === 'No Grade' ||
        select.val() === 'Dropped' ||
        select.val() === 'Incomplete') {
        gradeInput.val('');
        select.prop('disabled', false);
        updateRemarkStyle(select);
        return;
    }

    updateRemark(subjectId);
});

/* ============================================================
   VIEW GRADES
   ============================================================ */
$(document).on('click', '.doViewGrade', function() {

    var eid = $(this).attr('EID');

    $('#VG_SUBJECTS_TBODY').html(
        '<tr><td colspan="3" class="text-muted text-center">Loading...</td></tr>'
    );

    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/grade/ajax.php",
        method: "POST",
        data: {
            act: 'subjects',
            ENROLLMENT_ID: eid
        },
        dataType: "json",

        success: function(d) {

            if (!d.ENROLLMENT_ID) {
                alert('Could not load that enrollment record.');
                return;
            }

            $('#VG_IDNO_TEXT').text(d.IDNO || '-');
            $('#VG_NAME_TEXT').text(d.FULLNAME || '-');
            $('#VG_COURSE_TEXT').text(d.COURSE_TEXT || '-');
            $('#VG_TERM_TEXT').text(d.TERM_TEXT || '-');

            $('#VG_PICTURE').attr(
                'src',
                d.PICTURE_URL
                    ? d.PICTURE_URL
                    : '<?php echo WEB_ROOT; ?>module/student/image/1.png'
            );

            var rows = '';

            if (!d.subjects || d.subjects.length === 0) {

                rows =
                    '<tr><td colspan="3" class="text-muted text-center">' +
                    'No subjects taken yet for this enrollment.' +
                    '</td></tr>';

            } else {

                $.each(d.subjects, function(i, s) {

                    var gradeText =
                        (s.GRADE !== null && s.GRADE !== undefined)
                        ? escapeHtml(s.GRADE)
                        : '<span class="text-muted">Not yet graded</span>';

                    var remark =
                        calculateRemark(
                            s.GRADE,
                            s.REMARKS || ''
                        );

                    var remarksText =
                        remark
                        ? escapeHtml(remark)
                        : '<span class="text-muted">-</span>';

                    rows +=
                        '<tr>' +
                            '<td>' +
                                escapeHtml(s.SUBJECT_CODE) +
                                '<div class="text-muted small">' +
                                    escapeHtml(s.SUBJECT_NAME) +
                                '</div>' +
                            '</td>' +
                            '<td>' + gradeText + '</td>' +
                            '<td>' + remarksText + '</td>' +
                        '</tr>';
                });
            }

            $('#VG_SUBJECTS_TBODY').html(rows);
            $('#viewGradeModal').modal('show');
        },

        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Could not load that enrollment record.');
        }
    });
});

/* ============================================================
   DELETE HISTORY GRADES
   ============================================================ */
$(document).on('click', '.doDeleteGradeHistory', function() {

    var eid = $(this).attr('data-eid');
    var name = $(this).attr('data-name');

    Swal.fire({
        title: 'Delete grade record?',
        text:
            'This will remove the encoded grade(s) for ' +
            (name || 'this student') +
            ' on this past enrollment. This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'

    }).then((result) => {

        if (result.value) {

            window.location.href =
                "<?php echo WEB_ROOT; ?>" +
                "module/grade/controller.php" +
                "?action=delete_grades&id=" + eid;
        }
    });
});
</script>
