<?php

// HIPANAO SOLUTIONS
// Doctor Dashboard - same small-box / layout style as the admin
// dashboard (home.php), rendered through the same theme/template.php,
// but the content itself is clinic-focused (Patients, Doctors, Visits)
// instead of the school-records boxes the admin dashboard shows.

global $mydb;

function doctor_safe_count($table, $where = '') {
	global $mydb;
	if (!$mydb->tableExists($table)) { return 0; }
	$mydb->setQuery("SELECT * FROM `".$table."`".$where);
	return $mydb->num_rows();
}

$totalPatients   = doctor_safe_count('tblpatients');
$totalDoctors    = doctor_safe_count('tbldoctors', " WHERE STATUS = 'Active'");
$visitsToday     = (new Visit())->countToday();
$totalVisits     = doctor_safe_count('tblvisits');

$doctorName    = isset($_SESSION['DISPLAYNAME']) ? $_SESSION['DISPLAYNAME'] : 'Doctor';
$doctorProfile = (new DoctorProfile())->profile_for_uid(isset($_SESSION['UID']) ? $_SESSION['UID'] : 0);

// A few of today's/most recent visits, for the "Recent Visits" panel below.
$recentVisits = array();
if ($mydb->tableExists('tblvisits')) {
	$mydb->setQuery("SELECT v.VISIT_DATE, v.CHIEF_COMPLAINT, v.DIAGNOSIS,
			p.PATIENT_ID, p.FNAME, p.LNAME
		FROM `tblvisits` v
		LEFT JOIN `tblpatients` p ON p.PATIENT_ID = v.PATIENT_ID
		ORDER BY v.VISIT_ID DESC
		LIMIT 5");
	$recentVisits = $mydb->loadResultList();
}
?>

<section class="content">

      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-12">
            <div class="alert alert-info">
              Welcome back, Dr. <?php echo htmlspecialchars($doctorName); ?>.
              <?php if ($doctorProfile && $doctorProfile->SPECIALIZATION != ''): ?>
                (<?php echo htmlspecialchars($doctorProfile->SPECIALIZATION); ?>)
              <?php endif; ?>
              Here's today's clinic overview.
            </div>
          </div>
        </div>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $totalPatients; ?></h3>
                <p>Total Patients</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-injured"></i>
              </div>
              <a href="<?php echo WEB_ROOT; ?>module/patient/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $visitsToday; ?></h3>
                <p>Visits Today</p>
              </div>
              <div class="icon">
                <i class="fa fa-notes-medical"></i>
              </div>
              <a href="<?php echo WEB_ROOT; ?>module/patient/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $totalVisits; ?></h3>
                <p>Total Visit Records</p>
              </div>
              <div class="icon">
                <i class="fa fa-clipboard-list"></i>
              </div>
              <a href="<?php echo WEB_ROOT; ?>module/patient/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $totalDoctors; ?></h3>
                <p>Active Doctors</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-md"></i>
              </div>
              <a href="<?php echo WEB_ROOT; ?>module/doctor/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h3 class="card-title">Recent Visits</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Patient</th>
                      <th>Chief Complaint</th>
                      <th>Diagnosis</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if (count($recentVisits) == 0) { ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">No visit records yet.</td></tr>
                  <?php } else { foreach ($recentVisits as $rv) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($rv->VISIT_DATE); ?></td>
                      <td><?php echo htmlspecialchars($rv->FNAME.' '.$rv->LNAME); ?></td>
                      <td><?php echo htmlspecialchars($rv->CHIEF_COMPLAINT); ?></td>
                      <td><?php echo htmlspecialchars($rv->DIAGNOSIS); ?></td>
                      <td><a href="<?php echo WEB_ROOT; ?>module/patient/index.php?view=view&id=<?php echo $rv->PATIENT_ID; ?>">View patient</a></td>
                    </tr>
                  <?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

    </div>

    </section>
