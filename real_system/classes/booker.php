<?php
class booker {
    public $day, $month, $year, $selected_date, $first_day, $back, $forward;
    function database() {
        $this->db = new database();
        $this->db->initiate();
    }
    function QuickFetch($query) {
        $this->db->DoQuery($query);
        $fetch_value = $this->db->fetch();
        return $fetch_value[0];
    }
    function minutes($time) {
        $time = explode(':', $time);
        return (($time[0] * 3600) + ($time[1] * 60)) / 60;
    }
    function make_calendar($selected_date, $first_day, $back, $forward, $day, $month, $year) {
        $this->database();
        $this->day                = $day;
        $this->month              = $month;
        $this->year               = $year;
        $this->selected_date      = $selected_date;
       $this->first_day          = $first_day;
        $this->back               = $back;
        $this->forward            = $forward;
        $this->booking_start_time = $this->QuickFetch("SELECT value FROM metadata WHERE id = '1'");
        $this->booking_end_time   = $this->QuickFetch("SELECT value FROM metadata WHERE id = '2'");
        $this->booking_frequency  = $this->QuickFetch("SELECT value FROM metadata WHERE id = '3'");
        $this->start_booking($year, $month);
    }
    function post($month, $day, $year) {
        //error lists
        $errors = array();
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');

        if (isset($_POST['booking_time']) && $_POST['booking_time'] == 'selectvalue') {
            array_push($errors, "Please select a booking time.");
        }
        if (strlen($_POST['comments']) >= 140) { // In the event the html limit is bypassed
            array_push($errors, "You have exceeded the character limit for the comments. Please shorten it!");
        }
        if (isset($_POST['booking_service']) && $_POST['booking_service'] == 'selectvalue') {
            array_push($errors, "Please select a service.");
        }
        if (strlen($_POST["recaptcha_response_field"]) == 0) {
            array_push($errors, "Please type in the captcha.");
        }
        if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if (!$resp->is_valid) {
               array_push($errors, "The captcha is incorrect. Please try again!");
            }
        }
        if (!empty($errors)) {
            display_errors($errors); //no errors, continue with saving into the database.
        } else {
            $this->database(); //declared again as post will go to this function instead of loading the calendar.
            $booking_date    = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
            $booking_time    = $_POST['booking_time'];
            $booking_service = $_POST['booking_service'];
            $query           = "INSERT INTO booking (date, time, user_id, comments, confirmedbystaff, service_id, staff_id) VALUES (:booking_date, :booking_time, :user_id, :comments, :confirmed, :service_id, :staff_id)";
            $query_params    = array(
                ':booking_date' => $booking_date,
                ':booking_time' => $booking_time,
                ':service_id' => $booking_service,
                ':user_id' => $_COOKIE['userdata']['user_id'],
                ':comments' => $_POST['comments'],
                ':confirmed' => 0,
                ':staff_id' => 1
            );
            $this->db->DoQuery($query, $query_params);
            $this->confirmation($booking_date, $booking_time, $booking_service, $_COOKIE['userdata']['user_id']);
        }
    }
    function confirmation($date, $time, $serviceid, $user_id) {
        include('functions/email.php');
        $query = "SELECT type FROM service WHERE id = '$serviceid'";
        $this->db->DoQuery($query);
        $service = $this->db->fetch();
        $query   = "SELECT email FROM users WHERE id = '$user_id'";
        $this->db->DoQuery($query);
        $email = $this->db->fetch();
        $extra = array(
            ':bookingday' => $date,
            ':bookingtime' => $time,
            ':bookingservice' => $service[0]
        );
        email($email['email'], $user_id, $_COOKIE['userdata']['forename'], "appointment", $extra);
        echo "<meta http-equiv='refresh' content='0; url=confirmation.php?type=appointment'/>";
    }
    function start_booking($year, $month) {
        $period = $year . '-' . $month . '%';
        $query  = "SELECT * FROM booking WHERE date LIKE '$period'";
        $this->db->DoQuery($query);
        $this->count = $this->db->RowCount();
        while ($rows = $this->db->fetch()) {
            $this->prior_bookings[] = array(
                "date" => $rows['date'],
                "start" => $rows['time']
            );
        }
        $this->create_days_arr($year, $month);
    }
    function create_days_arr($year, $month) { // Creates array of days in the month.       
        $num_days_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Make array called $day with the correct number of days
        for ($i = 1; $i <= $num_days_month; $i++) {
            $d            = mktime(0, 0, 0, $month, $i, $year);
            $this->days[] = array(
                "daynumber" => $i,
                "dayname" => date("l", $d)
            );
        }
        for ($j = 1; $j <= $this->first_day; $j++) { // Add blank elements to start of array if the first day of the month is not a Monday.
            array_unshift($this->days, '0');
        }
        $padding_end = 7 - (count($this->days) % 7); // Add blank elements to end of array if required.
        if ($padding_end < 7) {
            for ($j = 1; $j <= $padding_end; $j++) {
                array_push($this->days, NULL);
            }
        }
        $this->start_calendar();
    }
    function create_days_table() {
        $day_capacity = ((minutes($this->booking_end_time) + 30) - minutes($this->booking_start_time)) / $this->booking_frequency;
        $fdom = $this->year . "-" . $this->month . "-" . "01"; //day 01 of the month
        $closed_days_query = "SELECT date FROM closed_days WHERE YEAR(date) = YEAR('$fdom') AND MONTH(date) = MONTH('$fdom')";
        $this->db->DoQuery($closed_days_query);
        $closed_days = $this->db->fetchAll();
        $i = 0;
        foreach ($this->days as $row) {
            $box = '';
            if ($i % 7 == 0) {
                echo "</tr><tr>";
            } // Modulus used to give <tr> after every seven <td> cells
            if (isset($row['daynumber']) && $row['daynumber'] != 0) { // Padded days at the start of the month will have a 0 at the beginning
                echo "<td class='days'>";
                if ($this->count > 0) {
                    $bookings_on_day = 0;
                    foreach ($this->prior_bookings as $booking_date) {
                        if ($booking_date['date'] == $this->year.'-'.$this->month.'-'.sprintf("%02s", $row['daynumber'])) {
                            $bookings_on_day++;
                        }
                    }
                }
                $this_day = $this->year."-".$this->month."-".$row['daynumber'];
                foreach ($closed_days as $item) { // It's a closed day, set from the database.
                    if (strtotime($item['date']) == strtotime($this_day)) {
                        $box = 2;
                    }
                }
                if (mktime(0, 0, 0, $this->month, sprintf("%02s", $row['daynumber']) + 1, $this->year) < strtotime("now")) {
                    $box = 2; // Past Day / Unavailable 
                }
                if ($row['dayname'] == 'Sunday') {
                    $box = 2; // It's a Sunday
                }
                if ($bookings_on_day >= $day_capacity && $box == '') {
                    $box = 3; // Fully Booked
                }
                if ($bookings_on_day > 0 && $box == '') {
                    $box = 1; // Part booked day.
                }
                echo $this->day_switch($box, $row['daynumber']) . "</td>";
            } else { // Show NULL day.
                echo "<td class='days'><div class='box' id='key_null'></div></td>";
            }
            $i++;
        }
        echo "</tr></table>";
        $this->make_booking_slots();
    }
    function day_switch($box, $daynumber) {
        $date_number = "<p>" . str_replace(NULL, ' ', $daynumber) . "</p>";
        $link        = "<a href='calendar.php?month=" . $this->month . "&year=" . $this->year . "&day=" . sprintf("%02s", $daynumber) . '#selected_date' . "'>";
        switch ($box) {
            case (1):
                $text = $link . "<div class='box' id='key_partbooked'>" . $date_number . "</div></a>";
                break;
            case (3):
                $text = "<div class='box' id='key_fullybooked'>" . $date_number . "</div>";
                break;
            case (2):
                $text = "<div class='box' id='key_unavailable'>" . $date_number . "</div>";
                break;
            default:
                $text = $link . "<div class='box' id='key_available'>" . $date_number . "</div></a>";
                break;
        }
        return $text;
    }

    function make_booking_slots() {
        if ($this->day == 0) { //default day = 0; done so to show that date is not chosen.
        echo "<form id='calendar_form' method='post' action=''>";
        echo "<div class='status' id='selected_date'>Please select a day.</div>";
        } else {
            $this->create_form();
        }
    }
    function start_calendar() {
        echo "<table cellpadding='0' id='calendar'>
            <div id='week'>";
        echo "<div class='buttons' align='left'>";
        if ($this->selected_date > strtotime('-6 months')) {
            echo "<a href='?month=" . date("m", $this->back) . "&amp;year=" . date("Y", $this->back) . "'>";
        } else {
            echo "<a class='invisible'>";
        };
        echo "&#8592;</a></div>";
        echo "<div id='center_date'>" . date("F, Y", $this->selected_date) . "<b class='keyguide'>
               <i>?</i>
               <ul class='keylist'>
               <h3>Key</h3>
                            <li id='key_fullybooked'>Fully Booked</li>
                            <li id='key_partbooked'>Free (Partially)</li>
                            <li id='key_available'>Free</li>
                            <li id='key_unavailable'>Not Available</li>
                        </ul>
            </div></b>";
        echo "<div class='buttons' align='right'>";
        if ($this->selected_date < strtotime('+6 months')) {
            echo "<a href='?month=" . date("m", $this->forward) . "&amp;year=" . date("Y", $this->forward) . "'>";
        } else {
            echo "<a class='invisible'>";
        };
        echo "&#8594;</a></div>";
        echo "</div>
        <tr>";
        $days = array("Mo","Tu","We","Th","Fr","Sa","Su");
        for ($i = 0; $i < 7; $i++) {
            echo '<th>' . $days[$i] . '</th>';
        }
        if (empty($this->prior_bookings)) {
            $this->create_days_table($this->days, $this->month, $this->year);
        } else {
            $this->create_days_table($this->days, $this->prior_bookings, $this->month, $this->year);
        }
    }
    function create_form() {
        $this->db->DoQuery("SELECT * FROM service");
        $services = $this->db->fetchAll();
        for ($i = strtotime($this->booking_start_time); $i <= strtotime($this->booking_end_time); $i = $i + $this->booking_frequency * 60) {
            $booking_times[] = date("H:i:s", $i);
        }
        echo "<form id='calendar_form' method='post' action=''>";
        echo "<div id='left'>";
        echo "<div class='status' id='selected_date'>Selected Date is: " . date("D, d F Y", mktime(0, 0, 0, $this->month, $this->day, $this->year)) . "</div>";
        $option = "<select id='select' name='booking_time'><option value='selectvalue'>Please select a booking time</option>";
        if ($this->count >= 1) {
            foreach ($this->prior_bookings as $row) { // Check for bookings and remove any previously booked slots                 
                foreach ($booking_times as $i => $r) {
                    if ($row['start'] == $r && $row['date'] == $this->year . '-' . $this->month . '-' . $this->day) {
                        unset($booking_times[$i]);
                    }
                }
            }
        }
        foreach ($booking_times as $booking_time) {
            $finish_time = strtotime($booking_time) + $this->booking_frequency * 60; // Calculate finish time
            $option .= "<option value='" . $booking_time . "'>" . $booking_time . " - " . date("H:i:s", $finish_time) . "</option>";
        }
        echo $option . "</select>";
        echo "<select id='select' name='booking_service'>";
        echo "<option value='selectvalue'>Please select a Service</option>";
        foreach ($services as $row) {
            $text = $row[1] . " - &pound;" . $row[2];
            echo '<option value="' . $row[0] . '">' . $text . '</option>';
        }
        echo '</select>';
        echo "<textarea rows='3' cols='30' maxlength='140' name='comments' placeholder='Any comments? (140 Character Limit!)'></textarea>";
        echo "</div><div id='right'>";
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');
        echo recaptcha_get_html($publickey, $error);
        echo "<button type='submit'>Submit</button></div></form>";
    }
    
}
?>