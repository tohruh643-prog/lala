<?php
//JAY SOLUTIONS

$student = null;
$enroll  = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT * FROM `tblstudent` WHERE `S_ID`='".(int)$_GET['id']."' LIMIT 1");
    $student = $mydb->loadSingleResult();

    // Latest enrollment record for this student (course / section / school year), if any
    $mydb->setQuery("SELECT e.*, c.COURSE_CODE, c.COURSE_NAME, s.SECTION_NAME, sy.SCHOOL_YEAR
                      FROM `tblenrollment` e
                      LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID
                      LEFT JOIN `tblsections` s ON s.SECTION_ID = e.SECTION_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      WHERE e.S_ID='".(int)$_GET['id']."'
                      ORDER BY e.ENROLLMENT_ID DESC LIMIT 1");
    $enroll = $mydb->loadSingleResult();
}

/* ---------------------------------------------------------------------
   STUDENT PHOTO

   The old code pointed at a single hardcoded file, image/1.png, which
   was never actually in the folder. That is why the page showed a broken
   image icon for every student.

   Photos now live in module/student/image/ named after the student's
   ID number, e.g. 2011072501.jpg. This looks for that file on disk and
   falls back to default.png when the student has no photo yet, so the
   page never shows a broken image again.

   To add a photo for a new student: drop <IDNO>.jpg into that folder.
   Nothing else to change, no database column needed.
   --------------------------------------------------------------------- */
function student_photo_url($idno) {

    $dir = __DIR__.DIRECTORY_SEPARATOR.'image'.DIRECTORY_SEPARATOR;
    $web = WEB_ROOT.'module/student/image/';

    // Strip anything that is not safe in a filename. The IDNO comes from
    // the database, but this keeps a stray value from reaching the path.
    $safe = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$idno);

    if ($safe !== '') {
        foreach (array('jpg', 'jpeg', 'png', 'JPG', 'PNG') as $ext) {
            if (is_file($dir.$safe.'.'.$ext)) {
                // filemtime busts the browser cache when a photo is replaced
                return $web.$safe.'.'.$ext.'?v='.filemtime($dir.$safe.'.'.$ext);
            }
        }
    }

    if (is_file($dir.'default.png')) {
        return $web.'default.png';
    }
    return '';
}

$photoUrl = $student ? student_photo_url($student->IDNO) : '';
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$student): ?>
    <div class="alert alert-warning">
      No student was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/student/">student list</a> and click the view button of a student.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image / Basic Info -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?php echo $photoUrl; ?>"
                   style="width:128px; height:128px; object-fit:cover;"
                   alt="<?php echo htmlspecialchars($student->FNAME.' '.$student->LNAME); ?>">
            </div>

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($student->FNAME.' '.$student->MNAME.' '.$student->LNAME); ?>
            </h3>

            <p class="text-muted text-center">
              Student ID: <?php echo htmlspecialchars($student->IDNO); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <b>Gender</b>
                <span class="text-muted"><?php echo htmlspecialchars($student->SEX); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <b>Birthday</b>
                <span class="text-muted"><?php echo htmlspecialchars($student->BDAY); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <b>Status</b>
                <span class="text-muted"><?php echo htmlspecialchars($student->STATUS); ?></span>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/student/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Enrollment summary -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Current Enrollment</h3>
          </div>
          <div class="card-body">
            <?php if ($enroll): ?>
              <strong><i class="fas fa-book mr-1"></i> Course</strong>
              <p class="text-muted">
                <?php echo htmlspecialchars($enroll->COURSE_CODE.' - '.$enroll->COURSE_NAME); ?>
              </p>
              <hr>
              <strong><i class="fas fa-users mr-1"></i> Section</strong>
              <p class="text-muted">
                <?php
                  /* SECTION_ID is nullable now: a student who has only
                     reserved a slot has no section yet. */
                  echo ($enroll->SECTION_NAME === null || $enroll->SECTION_NAME === '')
                     ? 'Not yet sectioned'
                     : htmlspecialchars($enroll->SECTION_NAME);
                ?>
              </p>
              <hr>
              <strong><i class="fas fa-calendar mr-1"></i> School Year</strong>
              <p class="text-muted"><?php echo htmlspecialchars($enroll->SCHOOL_YEAR); ?></p>
              <hr>
              <strong><i class="fas fa-info-circle mr-1"></i> Enrollment Status</strong>
              <p class="text-muted"><?php echo htmlspecialchars($enroll->STATUS); ?></p>
            <?php else: ?>
              <p class="text-muted">This student is not yet enrolled in any course/section.</p>
            <?php endif; ?>
          </div>
        </div>

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile Info</a></li>
              <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Contact Info</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">

              <div class="active tab-pane" id="profile">
                <table class="table table-bordered">
                  <tr>
                    <th style="width:30%">Student ID Number</th>
                    <td><?php echo htmlspecialchars($student->IDNO); ?></td>
                  </tr>
                  <tr>
                    <th>Full Name</th>
                    <td><?php echo htmlspecialchars($student->FNAME.' '.$student->MNAME.' '.$student->LNAME); ?></td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($student->SEX); ?></td>
                  </tr>
                  <tr>
                    <th>Birthday</th>
                    <td><?php echo htmlspecialchars($student->BDAY); ?></td>
                  </tr>
                  <tr>
                    <th>Birth Place</th>
                    <td><?php echo isset($student->BPLACE) ? htmlspecialchars($student->BPLACE) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Age</th>
                    <td><?php echo isset($student->AGE) ? htmlspecialchars($student->AGE) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Nationality</th>
                    <td><?php echo isset($student->NATIONALITY) ? htmlspecialchars($student->NATIONALITY) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Religion</th>
                    <td><?php echo isset($student->RELIGION) ? htmlspecialchars($student->RELIGION) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($student->STATUS); ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="contact">
                <table class="table table-bordered">
                  <tr>
                    <th style="width:30%">Contact Number</th>
                    <td><?php echo isset($student->CONTACT_NO) ? htmlspecialchars($student->CONTACT_NO) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td><?php echo isset($student->EMAIL) ? htmlspecialchars($student->EMAIL) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Home Address</th>
                    <td><?php echo isset($student->HOME_ADD) ? htmlspecialchars($student->HOME_ADD) : ''; ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->