<?php
global $mydb;
?>

<section class="content">
  <div class="container-fluid">

    <?php check_message(); ?>

    <div class="row">
      <div class="col-12">

        <div class="card card-info card-outline">

          <div class="card-header">
            <h3 class="card-title mb-0">
              <i class="fa fa-graduation-cap mr-1 text-muted"></i>
              Grades
            </h3>
          </div>

          <div class="card-body">

            <?php if (!$mydb->tableExists('tblenrollment')): ?>

              <div class="alert alert-warning mb-3">
                <i class="fa fa-exclamation-triangle mr-1"></i>
                Table <code>tblenrollment</code> was not found in the database.
              </div>

            <?php endif; ?>

            <table id="tblgradestudents"
                   class="table table-bordered table-striped"
                   style="width:100%">

              <thead>
                <tr>
                  <th>#</th>
                  <th>ID No.</th>
                  <th>Student Name</th>
                  <th>Course</th>
                  <th>Year Level</th>
                  <th>AY / Semester</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody></tbody>

            </table>

          </div>
        </div>

      </div>
    </div>

    <!-- ============================================================
         HISTORY GRADE
         ============================================================ -->

    <div class="row">
      <div class="col-12">

        <div class="card card-secondary card-outline">

          <div class="card-header">
            <h3 class="card-title mb-0">
              <i class="fa fa-history mr-1 text-muted"></i>
              History Grade
            </h3>
          </div>

          <div class="card-body">

            <?php if (!$mydb->tableExists('tblhistoryenrollment')): ?>

              <div class="alert alert-warning mb-3">
                <i class="fa fa-exclamation-triangle mr-1"></i>
                Table <code>tblhistoryenrollment</code> was not found
                in the database.
              </div>

            <?php endif; ?>

            <table id="tblgradehistory"
                   class="table table-bordered table-striped"
                   style="width:100%">

              <thead>
                <tr>
                  <th>#</th>
                  <th>ID No.</th>
                  <th>Student Name</th>
                  <th>Course</th>
                  <th>Year Level</th>
                  <th>AY / Semester</th>
                  <th>Status</th>
                  <th>Grades</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody></tbody>

            </table>

          </div>
        </div>

      </div>
    </div>

  </div>
</section>


<!-- ================================================================
     ENCODE GRADES MODAL
     ================================================================ -->

<div class="modal fade" id="gradeModal">

  <div class="modal-dialog modal-lg">

    <form action="controller.php?action=save" method="POST">

      <div class="modal-content">

        <div class="modal-header">

          <h4 class="modal-title">
            <i class="fa fa-graduation-cap text-info"></i>
            &nbsp;Encode Grades
          </h4>

          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>


        <div class="modal-body">

          <input type="hidden"
                 name="GRADE_EID"
                 id="GRADE_EID"
                 value="">


          <div class="row">

            <!-- STUDENT INFORMATION -->
            <div class="col-md-3">

              <div class="card card-info card-outline mb-0">

                <div class="card-body box-profile text-center">

                  <img id="GRADE_PICTURE"
                       class="profile-user-img img-fluid img-circle"
                       src="<?php echo WEB_ROOT; ?>module/student/image/1.png"
                       alt="Student photo">

                  <h3 id="GRADE_IDNO_TEXT"
                      class="profile-username text-center mt-2 mb-0"
                      style="font-size:1rem;">
                    -
                  </h3>

                  <p id="GRADE_NAME_TEXT"
                     class="text-muted text-center mb-0">
                    -
                  </p>

                </div>


                <ul class="list-group list-group-flush">

                  <li class="list-group-item p-2">
                    <small class="text-muted d-block">Course</small>
                    <span id="GRADE_COURSE_TEXT">-</span>
                  </li>

                  <li class="list-group-item p-2">
                    <small class="text-muted d-block">
                      AY / Semester
                    </small>
                    <span id="GRADE_TERM_TEXT">-</span>
                  </li>

                </ul>

              </div>

            </div>


            <!-- SUBJECTS AND GRADES -->
            <div class="col-md-9">

              <div class="alert alert-info py-2">
                <i class="fa fa-info-circle"></i>

                <strong>Automatic Remarks:</strong>
                75-99 = Passed,
                3.01–5.00 = Failed.

                <br>

                <strong>Manual Remarks:</strong>
                Incomplete or Dropped.
              </div>


              <table class="table table-sm table-hover mb-0">

                <thead class="thead-light">

                  <tr>
                    <th>Subject</th>
                    <th width="25%">Grade</th>
                    <th width="30%">Remarks</th>
                  </tr>

                </thead>

                <tbody id="GRADE_SUBJECTS_TBODY">

                  <tr>
                    <td colspan="3"
                        class="text-muted text-center">
                      Loading...
                    </td>
                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>


        <div class="modal-footer justify-content-between">

          <button type="button"
                  class="btn btn-default"
                  data-dismiss="modal">
            Cancel
          </button>

          <button type="submit"
                  class="btn btn-info">
            <i class="fa fa-save"></i>
            Save Grades
          </button>

        </div>

      </div>

    </form>

  </div>
</div>


<!-- ================================================================
     VIEW GRADES MODAL
     ================================================================ -->

<div class="modal fade" id="viewGradeModal">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">
          <i class="fa fa-eye text-info"></i>
          &nbsp;View Grades
        </h4>

        <button type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>


      <div class="modal-body">

        <div class="row">

          <div class="col-md-3">

            <div class="card card-info card-outline mb-0">

              <div class="card-body box-profile text-center">

                <img id="VG_PICTURE"
                     class="profile-user-img img-fluid img-circle"
                     src="<?php echo WEB_ROOT; ?>module/student/image/1.png"
                     alt="Student photo">

                <h3 id="VG_IDNO_TEXT"
                    class="profile-username text-center mt-2 mb-0"
                    style="font-size:1rem;">
                  -
                </h3>

                <p id="VG_NAME_TEXT"
                   class="text-muted text-center mb-0">
                  -
                </p>

              </div>


              <ul class="list-group list-group-flush">

                <li class="list-group-item p-2">
                  <small class="text-muted d-block">
                    Course
                  </small>
                  <span id="VG_COURSE_TEXT">-</span>
                </li>

                <li class="list-group-item p-2">
                  <small class="text-muted d-block">
                    AY / Semester
                  </small>
                  <span id="VG_TERM_TEXT">-</span>
                </li>

              </ul>

            </div>

          </div>


          <div class="col-md-9">

            <table class="table table-sm table-hover mb-0">

              <thead class="thead-light">

                <tr>
                  <th>Subject</th>
                  <th width="20%">Grade</th>
                  <th width="30%">Remarks</th>
                </tr>

              </thead>

              <tbody id="VG_SUBJECTS_TBODY">

                <tr>
                  <td colspan="3"
                      class="text-muted text-center">
                    Loading...
                  </td>
                </tr>

              </tbody>

            </table>

          </div>

        </div>

      </div>


      <div class="modal-footer justify-content-between">

        <button type="button"
                class="btn btn-default"
                data-dismiss="modal">
          Close
        </button>

      </div>

    </div>

  </div>

</div>


<style>
/* Small visual feedback for automatic/manual remarks. */
.grade-remarks.border-success {
    border-width: 2px;
}

.grade-remarks.border-danger {
    border-width: 2px;
}

.grade-remarks.border-warning {
    border-width: 2px;
}

.remark-help {
    display: block;
    margin-top: 3px;
}
</style>
