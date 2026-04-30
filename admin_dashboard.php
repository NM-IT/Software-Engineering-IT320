<?php
include "config.php";

$eventMessage = "";


if (isset($_POST['create_event'])) {
    $event_name = $_POST['event_name'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $description = $_POST['description'];

    // مؤقتًا نستخدم أول أدمن موجود في جدول admin
    $created_by = 1;
    $adminQuery = mysqli_query($conn, "SELECT admin_id FROM admin LIMIT 1");
    if ($adminQuery && mysqli_num_rows($adminQuery) > 0) {
        $adminRow = mysqli_fetch_assoc($adminQuery);
        $created_by = $adminRow['admin_id'];
    }

    if (!empty($event_name) && !empty($location) && !empty($event_date) && !empty($description)) {
        $sql = "INSERT INTO `event` (event_name, event_date, location, description, created_by)
                VALUES ('$event_name', '$event_date', '$location', '$description', '$created_by')";

        if (mysqli_query($conn, $sql)) {
            $eventMessage = "Event created successfully.";
        } else {
            $eventMessage = "Error: " . mysqli_error($conn);
        }
    } else {
        $eventMessage = "Please fill all required event fields.";
    }
}
$zoneMessage = "";
if (isset($_POST['delete_zone'])) {
    $zone_id = $_POST['zone_id'];

    if (!empty($zone_id)) {
        $deleteSql = "DELETE FROM `zone` WHERE zone_id = '$zone_id'";

        if (mysqli_query($conn, $deleteSql)) {
            $zoneMessage = "Zone deleted successfully.";
        } else {
            $zoneMessage = "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['add_zone'])) {
    $zone_name = $_POST['zone_name'];
    $zone_capacity = $_POST['zone_capacity'];
    $crowd_level = $_POST['crowd_level'];

    // مؤقتًا نربط الزون بآخر Event موجود
    $event_id = 1;
    $eventQuery = mysqli_query($conn, "SELECT event_id FROM `event` ORDER BY event_id DESC LIMIT 1");
    if ($eventQuery && mysqli_num_rows($eventQuery) > 0) {
        $eventRow = mysqli_fetch_assoc($eventQuery);
        $event_id = $eventRow['event_id'];
    }

    if (!empty($zone_name) && !empty($zone_capacity) && !empty($crowd_level)) {
        $zoneSql = "INSERT INTO `zone` (zone_name, zone_capacity, crowd_level, event_id)
                    VALUES ('$zone_name', '$zone_capacity', '$crowd_level', '$event_id')";

        if (mysqli_query($conn, $zoneSql)) {
            $zoneMessage = "Zone added successfully.";
        } else {
            $zoneMessage = "Error: " . mysqli_error($conn);
        }
    } else {
        $zoneMessage = "Please fill all required zone fields.";
    }
}

if (isset($_POST['update_zone'])) {
    $zone_id = $_POST['zone_id'];
    $zone_name = $_POST['update_zone_name'];
    $zone_capacity = $_POST['update_zone_capacity'];
    $crowd_level = $_POST['update_crowd_level'];

    if (!empty($zone_id) && !empty($zone_name) && !empty($zone_capacity) && !empty($crowd_level)) {
        $updateZoneSql = "UPDATE `zone`
                          SET zone_name = '$zone_name',
                              zone_capacity = '$zone_capacity',
                              crowd_level = '$crowd_level'
                          WHERE zone_id = '$zone_id'";

        if (mysqli_query($conn, $updateZoneSql)) {
            $zoneMessage = "Zone updated successfully.";
        } else {
            $zoneMessage = "Error: " . mysqli_error($conn);
        }
    } else {
        $zoneMessage = "Please fill all fields before updating the zone.";
    }
}

$slotMessage = "";

if (isset($_POST['add_timeslot'])) {
    $slot_start = $_POST['slot_start'];
    $slot_end = $_POST['slot_end'];
    $slot_date = $_POST['slot_date'];

    // مؤقتًا نربط الـ time slot بآخر Event موجود
    $event_id = 1;
    $eventQuery = mysqli_query($conn, "SELECT event_id FROM `event` ORDER BY event_id DESC LIMIT 1");
    if ($eventQuery && mysqli_num_rows($eventQuery) > 0) {
        $eventRow = mysqli_fetch_assoc($eventQuery);
        $event_id = $eventRow['event_id'];
    }

    if (!empty($slot_start) && !empty($slot_end) && !empty($slot_date)) {
        $slotSql = "INSERT INTO `timeslot` (start_time, end_time, slot_date, event_id)
                    VALUES ('$slot_start', '$slot_end', '$slot_date', '$event_id')";

        if (mysqli_query($conn, $slotSql)) {
            $slotMessage = "Time slot added successfully.";
        } else {
            $slotMessage = "Error: " . mysqli_error($conn);
        }
    } else {
        $slotMessage = "Please fill all required time slot fields.";
    }
}
if (isset($_POST['update_timeslot'])) {
   $timeslot_id = $_POST['timeslot_id'];
$slot_start = $_POST['update_slot_start'];
$slot_end = $_POST['update_slot_end'];
$slot_date = $_POST['update_slot_date'];

    if (!empty($timeslot_id) && !empty($slot_start) && !empty($slot_end) && !empty($slot_date)) {
        $updateSlotSql = "UPDATE `timeslot`
                          SET start_time = '$slot_start',
                              end_time = '$slot_end',
                              slot_date = '$slot_date'
                          WHERE timeslot_id = '$timeslot_id'";

        if (mysqli_query($conn, $updateSlotSql)) {
            $slotMessage = "Time slot updated successfully.";
        } else {
            $slotMessage = "Error: " . mysqli_error($conn);
        }
    } else {
        $slotMessage = "Please fill all fields before updating the time slot.";
    }
}

$assignmentMessage = "";

if (isset($_POST['update_assignment_db'])) {
    $ticket_number = $_POST['ticket_number'];
    $gate_id = $_POST['gate_id'];
    $zone_id = $_POST['zone_id'];
    $timeslot_id = $_POST['timeslot_id'];
    $pickup_point = $_POST['pickup_point'];
    $guidance_instructions = $_POST['guidance_instructions'];

    if (!empty($ticket_number) && !empty($gate_id) && !empty($zone_id) && !empty($timeslot_id) && !empty($pickup_point) && !empty($guidance_instructions)) {

        $ticketQuery = mysqli_query($conn, "SELECT ticket_id FROM `ticket` WHERE ticket_number = '$ticket_number' LIMIT 1");

        if ($ticketQuery && mysqli_num_rows($ticketQuery) > 0) {
            $ticketRow = mysqli_fetch_assoc($ticketQuery);
            $ticket_id = $ticketRow['ticket_id'];

            $updateAssignmentSql = "UPDATE `visitorassignment`
                                    SET gate_id = '$gate_id',
                                        zone_id = '$zone_id',
                                        timeslot_id = '$timeslot_id',
                                        pickup_point = '$pickup_point',
                                        guidance_instructions = '$guidance_instructions'
                                    WHERE ticket_id = '$ticket_id'";

            if (mysqli_query($conn, $updateAssignmentSql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $assignmentMessage = "Visitor assignment updated successfully.";
                } else {
                    $assignmentMessage = "No assignment found for this ticket.";
                }
            } else {
                $assignmentMessage = "Error: " . mysqli_error($conn);
            }
        } else {
            $assignmentMessage = "Invalid ticket number.";
        }
    } else {
        $assignmentMessage = "Please fill all assignment fields.";
    }
}
$notificationMessage = "";

if (isset($_POST['send_notification_db'])) {
    $visitor_id = $_POST['visitor_id'];
    $title = $_POST['notification_title'];
    $message = $_POST['notification_message'];

    if (!empty($visitor_id) && !empty($title) && !empty($message)) {
        $visitorQuery = mysqli_query($conn, "SELECT visitor_id FROM `visitor` WHERE visitor_id = '$visitor_id' LIMIT 1");

        if ($visitorQuery && mysqli_num_rows($visitorQuery) > 0) {
            $notificationSql = "INSERT INTO `notification` (title, message, is_read, visitor_id)
                                VALUES ('$title', '$message', 0, '$visitor_id')";

            if (mysqli_query($conn, $notificationSql)) {
                $notificationMessage = "Notification sent successfully.";
            } else {
                $notificationMessage = "Error: " . mysqli_error($conn);
            }
        } else {
            $notificationMessage = "Invalid visitor ID.";
        }
    } else {
        $notificationMessage = "Please fill all notification fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Darbic Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;font-family:Segoe UI,Tahoma,sans-serif;background:#fef2f6;color:#2f2f2f}
    body{min-height:100vh}

.header{
    background:#6b0f1a; 
    color:white;
    padding:15px;
    display:flex;
    justify-content:space-between;
}

.main-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 70px;
  background:#fef2f6;
}

.logo {
  height: 150px;
}

.Darbic-name {
  font-family: "Playfair Display", serif;
  font-size: 42px;
  letter-spacing: 4px;
  color: #8f0f1f;
}
   


/* ===== Sign Out Button ===== */
.signout-btn {
  background-color:  #8f0f1f;
  color: #ffffff;
  border: none;
  padding: 10px 28px;
  border-radius: 50px;
  cursor: pointer;
  font-size:20px
}

.signout-btn:hover {
  background-color: #8f0f1f;
}


    

    .page-title h2{margin:0;font-size:28px}
    .page-title span{opacity:.9;font-size:14px}

    .layout{display:flex;min-height:calc(100vh - 210px)}

    .sidebar{
      width:240px;
      background:#fff;
      box-shadow:0 10px 30px rgba(0,0,0,.05);
      border-top-right-radius:20px;
      border-bottom-right-radius:20px;
      padding-top:20px;
    }

    .sidebar a{
      display:block;
      padding:16px 22px;
      color:#444;
      font-weight:500;
      text-decoration:none;
      cursor:pointer;
      border-left:4px solid transparent;
      transition:.25s;
    }

    .sidebar a:hover,
    .sidebar a.active{
      background:#f9e7ed;
      color:#7A1023;
      border-left-color:#7A1023;
    }

    .content{flex:1;padding:28px 30px 40px}
    .section{display:none;animation:fade .35s ease}
    .section.active{display:block}

    @keyframes fade{
      from{opacity:0;transform:translateY(10px)}
      to{opacity:1;transform:translateY(0)}
    }

    .section-heading{margin:0 0 20px;color:#7A1023;font-size:28px}
    .section-sub{margin:0 0 24px;color:#7c5360}

    .card,
    .stat-card,
    .timeline-item,
    .record-table-wrap,
    .chart-card,
    .message-preview{
      background:#fff;
      border-radius:16px;
      box-shadow:0 8px 25px rgba(0,0,0,.06);
    }

    .card{padding:22px;margin-bottom:20px}

    .stats{
      display:grid;
      grid-template-columns:repeat(4,1fr);
      gap:18px;
      margin-bottom:24px;
    }

    .stat-card{
      padding:18px;
      display:flex;
      gap:14px;
      align-items:center;
      transition:.25s;
    }
    .stat-card:hover{transform:translateY(-4px)}
    .icon{
      width:54px;height:54px;border-radius:14px;
      display:flex;align-items:center;justify-content:center;
      background:#f3d6dc;font-size:24px;
    }
    .stat-number{font-size:24px;font-weight:700;color:#8f0f1f;margin-bottom:4px}
    .stat-label{font-size:13px;color:#666}

    .grid-2{display:grid;grid-template-columns:1.2fr 1fr;gap:20px}
    .grid-2-equal{display:grid;grid-template-columns:1fr 1fr;gap:20px}

    .time-slot-grid{
      display:grid;
      grid-template-columns:repeat(4,1fr);
      gap:14px;
      margin-top:16px;
    }

    .slot{
      border:1px solid #ead2d8;
      border-radius:14px;
      padding:16px;
      background:#fffafb;
      transition:.25s;
    }
    .slot:hover{border-color:#8f0f1f;transform:translateY(-3px)}
    .slot strong{display:block;color:#7A1023;font-size:17px;margin-bottom:6px}
    .slot span{color:#666;font-size:14px}
    .slot .pill{
      display:inline-block;
      margin-top:12px;
      padding:6px 12px;
      border-radius:999px;
      background:#f3d6dc;
      color:#7A1023;
      font-size:12px;
      font-weight:700;
    }

    .timeline{display:flex;flex-direction:column;gap:14px}
    .timeline-item{padding:18px;border-left:6px solid #8f0f1f}
    .timeline-top{display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:8px}
    .timeline-top strong{color:#7A1023;font-size:18px}
    .timeline-top span{color:#666;font-size:14px}
    .timeline-item p{margin:0;color:#555;line-height:1.6}

    .chart-card{padding:20px;height:380px}
    .chart-card h3{margin:0 0 14px;color:#7A1023}
    .chart-holder{position:relative;height:300px}

    table{width:100%;border-collapse:collapse}
    th,td{padding:14px 12px;text-align:left;border-bottom:1px solid #f1e3e7}
    th{color:#7A1023;background:#fcf5f7;font-size:14px}
    td{font-size:14px;color:#444}
    tr:hover td{background:#fff9fa}

    .toolbar{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:18px}
    input,select,textarea{
      width:100%;padding:12px 14px;border-radius:12px;border:1px solid #dbc8ce;
      font-size:15px;outline:none;background:#fff;
    }
    input:focus,select:focus,textarea:focus{border-color:#8f0f1f;box-shadow:0 0 0 3px rgba(143,15,31,.08)}
    textarea{min-height:150px;resize:vertical}

    .form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
    .form-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:18px}
    .btn{
      border:none;cursor:pointer;border-radius:12px;padding:13px 20px;font-size:15px;font-weight:700;
      transition:.25s;
    }
    .btn-primary{background:linear-gradient(135deg,#7A1023,#9B1C31);color:#fff;box-shadow:0 8px 18px rgba(122,16,35,.28)}
    .btn-secondary{background:#f3d6dc;color:#7A1023}
    .btn:hover{transform:translateY(-2px)}

    .result-box{
      margin-top:18px;
      padding:18px;
      border-radius:14px;
      background:#fff8fa;
      border:1px solid #eed7dd;
      display:none;
    }
    .result-box.show{display:block}
    .result-row{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:14px}
    .mini-card{background:#fff;padding:16px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,.05)}
    .mini-card h4{margin:0 0 8px;color:#7A1023;font-size:14px}
    .mini-card p{margin:0;font-size:18px;font-weight:700;color:#333}

    .message-preview{padding:20px}
    .message-preview h3{margin-top:0;color:#7A1023}
    .tag{
      display:inline-block;padding:6px 10px;border-radius:999px;background:#f3d6dc;color:#7A1023;font-size:12px;font-weight:700;margin-bottom:10px
    }

    .main-footer{background:#6b0f1a;color:#f5f5f5;padding:45px 70px 20px}
    .footer-content{display:flex;align-items:center;gap:40px;flex-wrap:wrap}
    .footer-logo{height:110px;border-radius:16px}
    .contact-info p{margin:4px 0;font-size:14px}
    .footer-bottom{margin-top:22px;padding-top:12px;border-top:1px solid rgba(255,255,255,.35);text-align:center;font-size:13px}

    @media (max-width:1100px){
      .stats,.time-slot-grid,.form-grid,.result-row{grid-template-columns:repeat(2,1fr)}
      .grid-2,.grid-2-equal{grid-template-columns:1fr}
      .main-header,.page-title,.main-footer{padding-left:28px;padding-right:28px}
    }

    @media (max-width:800px){
      .layout{flex-direction:column}
      .sidebar{width:100%;margin:0;border-radius:0;height:auto}
      .content{padding:22px}
      .stats,.time-slot-grid,.form-grid,.result-row{grid-template-columns:1fr}
      .brand-text h1{font-size:28px}
      .logo{height:78px}
      .main-header{padding:18px 20px}
      .page-title{padding:16px 20px}
    }
  </style>
</head>
  
<body>
 
<header class="main-header">
  <img src="images/darbic-logo.jpg" alt="Darbic Logo" class="logo">
  <h1 class="Darbic-name">DARBIC</h1>
  <button class="signout-btn" type="button" onclick="window.location.href='index.html'">Sign Out</button>
</header>

<header class="header">
  <h2>Darbic Admin</h2>
</header>

  <div class="layout">
    <aside class="sidebar">
      <a class="active" onclick="showSection('arrival', this)"> Arrival Schedule</a>
      <a onclick="showSection('distribution', this)"> Crowd Distribution</a>
      <a onclick="showSection('update', this)">Update Assignment</a>
      <a onclick="showSection('notifications', this)"> Send Notifications</a>
      <a onclick="showSection('records', this)">Visitor Records</a>
      <a onclick="showSection('createEvent', this)">Create Event</a>
    </aside>

    <main class="content">
      <section id="arrival" class="section active">
        <div class="stats">
          <div class="stat-card"><div class="icon">🕒</div><div><div class="stat-number">12</div><div class="stat-label">Today's Time Slots</div></div></div>
          <div class="stat-card"><div class="icon">🎫</div><div><div class="stat-number">1,248</div><div class="stat-label">Scheduled Visitors</div></div></div>
          <div class="stat-card"><div class="icon">🚪</div><div><div class="stat-number">18</div><div class="stat-label">Active Gates</div></div></div>
          <div class="stat-card"><div class="icon">⚡</div><div><div class="stat-number">86%</div><div class="stat-label">On-Time Rate</div></div></div>
        </div>

        <h3 class="section-heading"> Arrival Schedule</h3>
  

        <div class="card">
          <form method="POST" action="">
  <div class="card">
    <h3 style="margin-top:0;color:#7A1023">Manage Time Slots</h3>

    <div class="form-grid">
      <div>
        <label>Slot Date</label>
        <input type="date" id="slotDate" name="slot_date" required>
      </div>

      <div>
        <label>Start Time</label>
        <input type="time" id="slotStart" name="slot_start" required>
      </div>

      <div>
        <label>End Time</label>
        <input type="time" id="slotEnd" name="slot_end" required>
      </div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit" name="add_timeslot">Add Time Slot</button>
    </div>

    <?php if($slotMessage != '') { ?>
      <div class="result-box show">
        <strong style="color:#7A1023"><?php echo $slotMessage; ?></strong>
      </div>
    <?php } ?>
  </div>
</form>
<div class="card">
  <h3 style="margin-top:0;color:#7A1023">Modify Time Slot</h3>

  <form method="POST" action="">
    <div class="form-grid">
      <div>
        <label>Select Time Slot</label>
        <select name="timeslot_id" required>
          <?php
            $selectSlotsQuery = "SELECT timeslot_id, start_time, end_time, slot_date FROM `timeslot` ORDER BY timeslot_id DESC";
            $selectSlotsResult = mysqli_query($conn, $selectSlotsQuery);

            if ($selectSlotsResult && mysqli_num_rows($selectSlotsResult) > 0) {
                while ($selectSlotRow = mysqli_fetch_assoc($selectSlotsResult)) {
          ?>
                  <option value="<?php echo $selectSlotRow['timeslot_id']; ?>">
                    <?php echo $selectSlotRow['slot_date']; ?> |
                    <?php echo $selectSlotRow['start_time']; ?> -
                    <?php echo $selectSlotRow['end_time']; ?>
                  </option>
          <?php
                }
            }
          ?>
        </select>
      </div>

      <div>
        <label>New Slot Date</label>
        <input type="date" name="update_slot_date" required>
      </div>

      <div>
        <label>New Start Time</label>
        <input type="time" name="update_slot_start" required>
      </div>

      <div>
        <label>New End Time</label>
        <input type="time" name="update_slot_end" required>
      </div>
    </div>

    <div class="form-actions">
      <button class="btn btn-secondary" type="submit" name="update_timeslot">Update Time Slot</button>
    </div>
  </form>
</div>
  

          <h3 style="margin-top:0;color:#7A1023">Time Slot UI</h3>
         <div class="time-slot-grid">
  <?php
    $slotsQuery = "SELECT start_time, end_time, slot_date FROM `timeslot` ORDER BY timeslot_id DESC";
    $slotsResult = mysqli_query($conn, $slotsQuery);

    if ($slotsResult && mysqli_num_rows($slotsResult) > 0) {
        while ($slotRow = mysqli_fetch_assoc($slotsResult)) {
  ?>
          <div class="slot">
            <strong><?php echo $slotRow['start_time']; ?> - <?php echo $slotRow['end_time']; ?></strong>
            <span><?php echo $slotRow['slot_date']; ?></span>
            <div class="pill">Saved in database</div>
          </div>
  <?php
        }
    } else {
  ?>
        <div class="slot">
          <strong>No time slots found</strong>
          <span>Add a time slot to display it here.</span>
        </div>
  <?php
    }
  ?>
</div>
        </div>

        <div class="card">
          <h3 style="margin-top:0;color:#7A1023">Timeline Layout</h3>
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-top"><strong>4:45 PM — Gate Preparation</strong><span>Operations Team</span></div>
              <p>Security verification starts, shuttle queue opens, and staff confirm that all entrance checkpoints are ready.</p>
            </div>
            <div class="timeline-item">
              <div class="timeline-top"><strong>5:30 PM — Peak Arrival Wave</strong><span>VIP + Standard Visitors</span></div>
              <p>Expected increase in arrivals at A3 and B1. Crowd control officers should monitor flow and redirect overflow when needed.</p>
            </div>
            <div class="timeline-item">
              <div class="timeline-top"><strong>6:15 PM — Redistribution Window</strong><span>Admin Adjustment</span></div>
              <p>Move selected late visitors from busy gates to lower-traffic gates based on real-time capacity.</p>
            </div>
          </div>
        </div>
      </section>

      <section id="distribution" class="section">
        <h3 class="section-heading"> Crowd Distribution</h3>


        <div class="grid-2">
          <div class="chart-card">
            <h3>Crowd Distribution Chart</h3>
            <div class="chart-holder"><canvas id="crowdChart"></canvas></div>
          </div>
          <div class="card">
            <h3 style="margin-top:0;color:#7A1023">Quick Notes</h3>
            <p style="line-height:1.8;color:#555">North Zone currently has the highest load. South Zone remains stable, while VIP traffic is controlled and below risk level. Use this panel for live monitoring during the event.</p>
            <div class="tag">Balanced Routing Suggested</div>
            <p style="margin:0;color:#666">Recommendation: redirect new arrivals from North Zone to East Gate when occupancy rises above 80%.</p>
          </div>
        </div>

        <div class="record-table-wrap" style="margin-top:20px;padding:20px">
            
            <form method="POST" action="">
          <div class="card">
  <h3 style="margin-top:0;color:#7A1023">Manage Zones</h3>

  <div class="form-grid">
    <div>
      <label>Zone Name</label>
     <input type="text" id="zoneName" name="zone_name" placeholder="Enter zone name" required>
    </div>

    

    <div>
      <label>Capacity</label>
      <input type="number" id="zoneCapacity" name="zone_capacity" placeholder="Zone capacity" required>
    </div>

    <div>
      <label>Status</label>
     <select id="zoneStatus" name="crowd_level" required>
        <option>Low</option>
        <option>Moderate</option>
        <option>High</option>
        <option>Controlled</option>
      </select>
    </div>
  </div>

  <div class="form-actions">
    <button class="btn btn-primary" type="submit" name="add_zone">Add Zone</button>
  </div>
  
  <?php if($zoneMessage != '') { ?>
  <div class="result-box show">
    <strong style="color:#7A1023"><?php echo $zoneMessage; ?></strong>
  </div>
<?php } ?>
</div>
   </form>
       
            <div class="card">
  <h3 style="margin-top:0;color:#7A1023">Modify Zone</h3>

  <form method="POST" action="">
    <div class="form-grid">
      <div>
        <label>Select Zone</label>
        <select name="zone_id" required>
          <?php
            $selectZonesQuery = "SELECT zone_id, zone_name, zone_capacity, crowd_level FROM `zone` ORDER BY zone_id DESC";
            $selectZonesResult = mysqli_query($conn, $selectZonesQuery);

            if ($selectZonesResult && mysqli_num_rows($selectZonesResult) > 0) {
                while ($selectZoneRow = mysqli_fetch_assoc($selectZonesResult)) {
          ?>
                  <option value="<?php echo $selectZoneRow['zone_id']; ?>">
                    <?php echo $selectZoneRow['zone_name']; ?> |
                    Capacity: <?php echo $selectZoneRow['zone_capacity']; ?> |
                    <?php echo $selectZoneRow['crowd_level']; ?>
                  </option>
          <?php
                }
            }
          ?>
        </select>
      </div>

      <div>
        <label>New Zone Name</label>
        <input type="text" name="update_zone_name" placeholder="Enter new zone name" required>
      </div>

      <div>
        <label>New Capacity</label>
        <input type="number" name="update_zone_capacity" placeholder="Enter new capacity" required>
      </div>

      <div>
        <label>New Status</label>
        <select name="update_crowd_level" required>
          <option>Low</option>
          <option>Moderate</option>
          <option>High</option>
          <option>Controlled</option>
        </select>
      </div>
    </div>

    <div class="form-actions">
      <button class="btn btn-secondary" type="submit" name="update_zone">Update Zone</button>
    </div>
  </form>
</div>
            
          <h3 style="margin-top:0;color:#7A1023">Zone Capacity Table</h3>
          <table>
            <thead>
              <tr>
                <th>Zone</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
          <tbody id="zonesTableBody">
  <?php
    $zonesQuery = "SELECT zone_id, zone_name, zone_capacity, crowd_level FROM `zone` ORDER BY zone_id DESC";
    $zonesResult = mysqli_query($conn, $zonesQuery);

    if ($zonesResult && mysqli_num_rows($zonesResult) > 0) {
        while ($zoneRow = mysqli_fetch_assoc($zonesResult)) {
  ?>
          <tr>
  <td><?php echo $zoneRow['zone_name']; ?></td>
  <td><?php echo $zoneRow['zone_capacity']; ?></td>
  <td><?php echo $zoneRow['crowd_level']; ?></td>
  <td>
  <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this zone?');">
    <input type="hidden" name="zone_id" value="<?php echo $zoneRow['zone_id']; ?>">
    <button class="btn btn-secondary" type="submit" name="delete_zone">Delete</button>
  </form>
</td>
</tr>
  <?php
        }
    } else {
  ?>
        <tr>
          <td colspan="4">No zones found.</td>
        </tr>
  <?php
    }
  ?>
</tbody>
          </table>
        </div>
      </section>

      <section id="update" class="section">
        <h3 class="section-heading"> Update Visitor Assignment</h3>
        <p class="section-sub">Search by ticket and change gate or arrival time.</p>

        <div class="card">
  <form method="POST" action="">
    <div class="form-grid">

      <div>
        <label>Ticket Number</label>
        <input type="text" name="ticket_number" placeholder="Enter ticket number, e.g. T100" required>
      </div>

      <div>
        <label>New Gate</label>
        <select name="gate_id" required>
          <?php
            $gateQuery = "SELECT gate_id, gate_name FROM `gate` ORDER BY gate_id ASC";
            $gateResult = mysqli_query($conn, $gateQuery);

            if ($gateResult && mysqli_num_rows($gateResult) > 0) {
                while ($gateRow = mysqli_fetch_assoc($gateResult)) {
          ?>
                  <option value="<?php echo $gateRow['gate_id']; ?>">
                    <?php echo $gateRow['gate_name']; ?>
                  </option>
          <?php
                }
            }
          ?>
        </select>
      </div>

      <div>
        <label>New Zone</label>
        <select name="zone_id" required>
          <?php
            $zoneSelectQuery = "SELECT zone_id, zone_name FROM `zone` ORDER BY zone_id ASC";
            $zoneSelectResult = mysqli_query($conn, $zoneSelectQuery);

            if ($zoneSelectResult && mysqli_num_rows($zoneSelectResult) > 0) {
                while ($zoneSelectRow = mysqli_fetch_assoc($zoneSelectResult)) {
          ?>
                  <option value="<?php echo $zoneSelectRow['zone_id']; ?>">
                    <?php echo $zoneSelectRow['zone_name']; ?>
                  </option>
          <?php
                }
            }
          ?>
        </select>
      </div>

      <div>
        <label>New Time Slot</label>
        <select name="timeslot_id" required>
          <?php
            $timeSelectQuery = "SELECT timeslot_id, slot_date, start_time, end_time FROM `timeslot` ORDER BY timeslot_id ASC";
            $timeSelectResult = mysqli_query($conn, $timeSelectQuery);

            if ($timeSelectResult && mysqli_num_rows($timeSelectResult) > 0) {
                while ($timeSelectRow = mysqli_fetch_assoc($timeSelectResult)) {
          ?>
                  <option value="<?php echo $timeSelectRow['timeslot_id']; ?>">
                    <?php echo $timeSelectRow['slot_date']; ?> |
                    <?php echo $timeSelectRow['start_time']; ?> -
                    <?php echo $timeSelectRow['end_time']; ?>
                  </option>
          <?php
                }
            }
          ?>
        </select>
      </div>

      <div>
        <label>Pickup Point</label>
        <input type="text" name="pickup_point" placeholder="North Parking / VIP Lounge / South Stop" required>
      </div>

    </div>

    <div style="margin-top:16px">
      <label>Guidance Instructions</label>
      <textarea name="guidance_instructions" placeholder="Write guidance instructions for the visitor..." required></textarea>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit" name="update_assignment_db">Update Assignment</button>
    </div>

    <?php if($assignmentMessage != '') { ?>
      <div class="result-box show">
        <strong style="color:#7A1023"><?php echo $assignmentMessage; ?></strong>
      </div>
    <?php } ?>
  </form>
</div>
      </section>

      <section id="notifications" class="section">
        <h3 class="section-heading"> Send Notifications</h3>
      

       <div class="grid-2-equal">
  <div class="card">
    <form method="POST" action="">
      <div class="form-grid">
        <div>
          <label>Visitor ID</label>
          <input type="number" name="visitor_id" placeholder="Enter visitor ID, e.g. 1" required>
        </div>

        <div>
          <label>Notification Title</label>
          <input type="text" name="notification_title" placeholder="Schedule Update / Gate Change / Reminder" required>
        </div>
      </div>

      <div style="margin-top:16px">
        <label>Notification Message</label>
        <textarea name="notification_message" placeholder="Write your notification here..." required>Your assigned gate has been updated. Please check your new arrival details before heading to the venue.</textarea>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit" name="send_notification_db">Send Notification</button>
      </div>

      <?php if($notificationMessage != '') { ?>
        <div class="result-box show">
          <strong style="color:#7A1023"><?php echo $notificationMessage; ?></strong>
        </div>
      <?php } ?>
    </form>
  </div>

  <div class="message-preview">
    <h3>Notification Preview</h3>
    <div class="tag">In-System Notification</div>
    <p style="line-height:1.8;color:#555">
      This notification will be saved in the database and linked to the selected visitor account.
    </p>
    <p style="margin-top:24px;color:#7A1023;font-weight:700">
      Stored in notification table
    </p>
  </div>
</div>
      </section>

      <section id="records" class="section">
        <h3 class="section-heading"> Visitor Records</h3>
      

        <div class="record-table-wrap" style="padding:20px">
          <table>
            <thead>
              <tr>
                <th>Ticket ID</th>
                <th>Visitor Name</th>
                <th>Assigned Gate</th>
                <th>Arrival Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>VIP-204</td><td>Reema alsaud</td><td>A3</td><td>5:30 PM</td><td>Checked In</td></tr>
              <tr><td>A-318</td><td>dhay alanazi,</td><td>A1</td><td>5:00 PM</td><td>On Route</td></tr>
              <tr><td>B-110</td><td>fatmah almohsen</td><td>B1</td><td>6:00 PM</td><td>Scheduled</td></tr>
              <tr><td>C-529</td><td>dhay alanazi</td><td>C2</td><td>6:30 PM</td><td>Delayed</td></tr>
              <tr><td>VIP-301</td><td>Ahmed Adel</td><td>A3</td><td>5:30 PM</td><td>Scheduled</td></tr>
            </tbody>
          </table>
        </div>
      </section>

      <section id="createEvent" class="section">
  <h3 class="section-heading">Create Event</h3>
  <p class="section-sub">create new events.</p>

  <form method="POST" action="">
  <div class="card">
    <div class="form-grid">

      <div>
        <label>Event Name</label>
       <input type="text" id="eventName" name="event_name" placeholder="Enter event name" required>
      </div>

      <div>
        <label>Location</label>
        <input type="text" id="eventLocation" name="location" placeholder="Enter location" required>
      </div>

      <div>
        <label>Date</label>
        <input type="date" id="eventDate" name="event_date" required>
      </div>

     

    </div>

    <div style="margin-top:16px">
      <label>Description</label>
      <textarea id="eventDesc" name="description" placeholder="Enter event details..." required></textarea>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit" name="create_event">Create Event</button>
      <button class="btn btn-secondary" type="button" onclick="clearEvent()">Clear</button>
    </div>

   <?php if($eventMessage != '') { ?>
  <div id="eventResult" class="result-box show">
    <strong style="color:#7A1023"><?php echo $eventMessage; ?></strong>
  </div>
<?php } ?>
    <div class="record-table-wrap" style="margin-top:20px;padding:20px">
  <h3 style="margin-top:0;color:#7A1023">Created Events</h3>
  <table>
    <thead>
      <tr>
        <th>Event Name</th>
        <th>Location</th>
        <th>Date</th>
      </tr>
    </thead>
   <tbody id="eventsTableBody">
  <?php
    $eventsQuery = "SELECT event_name, location, event_date, description FROM `event` ORDER BY event_id DESC";
    $eventsResult = mysqli_query($conn, $eventsQuery);

    if ($eventsResult && mysqli_num_rows($eventsResult) > 0) {
        while ($eventRow = mysqli_fetch_assoc($eventsResult)) {
  ?>
          <tr>
            <td><?php echo $eventRow['event_name']; ?></td>
            <td><?php echo $eventRow['location']; ?></td>
            <td><?php echo $eventRow['event_date']; ?></td>
          </tr>
  <?php
        }
    } else {
  ?>
        <tr>
          <td colspan="3">No events found.</td>
        </tr>
  <?php
    }
  ?>
</tbody>
  </table>
</div>

  </div>
   
      </form>
</section>
    </main>
  </div>

  <footer class="main-footer">
    <div class="footer-content">
      <img src="images/darbic-logo.jpg" alt="Darbic Logo" class="footer-logo">
      <div class="contact-info">
        <p>Email: info@Darbic.com</p>
        <p>Phone: +966 50 000 0000</p>
        <p>Riyadh, Saudi Arabia</p>
      </div>
    </div>
    <div class="footer-bottom">&copy; 2026 Darbic. All rights reserved.</div>
  </footer>

  <script>
    
  function showSection(id, el){
  document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
  document.getElementById(id).classList.add('active');

  document.querySelectorAll('.sidebar a').forEach(link => link.classList.remove('active'));
  if(el){
    el.classList.add('active');
  }

  localStorage.setItem('activeAdminSection', id);
}

window.addEventListener('load', function(){
  const savedSection = localStorage.getItem('activeAdminSection');

  if(savedSection && document.getElementById(savedSection)){
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(savedSection).classList.add('active');

    document.querySelectorAll('.sidebar a').forEach(link => {
      link.classList.remove('active');

      if(link.getAttribute('onclick') && link.getAttribute('onclick').includes(savedSection)){
        link.classList.add('active');
      }
    });
  }
});

  function clearEvent(){
  document.querySelectorAll('#createEvent input, #createEvent textarea')
    .forEach(el => el.value = "");

  const eventResult = document.getElementById("eventResult");
  if(eventResult){
    eventResult.classList.remove("show");
  }
}



    
    
  const chartCanvas = document.getElementById('crowdChart');

  if(chartCanvas && typeof Chart !== "undefined"){
    const crowdChart = new Chart(chartCanvas, {
      type: 'bar',
      data: {
        labels: ['North Zone', 'South Zone', 'East Zone', 'VIP'],
        datasets: [{
          label: 'Visitors',
          data: [420, 310, 225, 90],
          backgroundColor: ['#7A1023', '#9B1C31', '#c4455d', '#e6a9b6'],
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(143,15,31,0.08)' } },
          x: { grid: { display: false } }
        }
      }
    });
  }
</script>

</body>
</html>
