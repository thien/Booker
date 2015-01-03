<?php
class booker {
    public $day, $month, $year, $selected_date, $first_day, $back, $forward, $bookings, $count, $days;
    function make_calendar($selected_date, $first_day, $back, $forward, $day, $month, $year) {
        $this->db = new database();
        $this->db->initiate();
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->selected_date = $selected_date;
        $this->first_day = $first_day;
        $this->back = $back;
        $this->forward = $forward;
        $this->start_booking($year, $month);
    }
    function after_post($month, $day, $year) {
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');
        $errors = array();
        if (isset($_POST['booking_time']) && $_POST['booking_time'] == 'selectvalue') {
            array_push($errors, "Please select a booking time");
        }
        if (isset($_POST['booking_service']) && $_POST['booking_service'] == 'selectvalue') {
            array_push($errors, "Please select a service");
        }
        if (strlen($_POST["recaptcha_response_field"]) == 0) {
            array_push($errors, "Please type in the captcha.");
        }
        if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if (!$resp->is_valid) {
                array_push($errors, "The captcha is incorrect. Please try again.");
            }
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='error'>" . $error . "</div>";
            }
        } else {
            $this->db = new database();
            $this->db->initiate();
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
        $query2  = "SELECT email FROM users WHERE id = '$user_id'";
        $this->db->DoQuery($query2);
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
        $period = $year.'-'.$month.'%';
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
    function make_day_boxes() {
        $opentime = "SELECT value FROM metadata WHERE id = '4'";
        $this->db->DoQuery($opentime);
        $booking_slots_per_day = $this->db->fetch();
        $first_day_of_month    = $this->year . "-" . $this->month . "-" . "01";
        $closed_days_query     = "SELECT date FROM closed_days WHERE YEAR(date) = YEAR('$first_day_of_month') AND MONTH(date) = MONTH('$first_day_of_month')";
        $this->db->DoQuery($closed_days_query);
        $closed_days = $this->db->fetchAll();
        $i           = 0;
        foreach ($this->days as $row) {
            $tag = '';
            if ($i % 7 == 0) {
                echo "</tr><tr>"; // Use modulus to give us a <tr> after every seven <td> cells
            }
            if (isset($row['daynumber']) && $row['daynumber'] != 0) { // Padded days at the start of the month will have a 0 at the beginning
                echo "<td width='21' valign='top' class='days'>";
                if ($this->count > 0) {
                    $day_count = 0;
                    foreach ($this->prior_bookings as $booking_date) {
                        if ($booking_date['date'] == $this->year . '-' . $this->month . '-' . sprintf("%02s", $row['daynumber'])) {
                            $day_count++;
                        }
                    }
                }
                $this_day = $this->year . "-" . $this->month . "-" . $row['daynumber'];
                foreach ($closed_days as $item) { // It's a closed day, set from the database.
                    if (strtotime($item['date']) == strtotime($this_day)) {
                        $tag = 4;
                    }
                }
                // Work out which colour day box to show
                if ($row['dayname'] == 'Sunday') {
                    $tag = 2; // It's a Sunday
                }
                if (mktime(0, 0, 0, $this->month, sprintf("%02s", $row['daynumber']) + 1, $this->year) < strtotime("now")) {
                    $tag = 4; // Past Day / Unavailable 
                }
                if ($day_count >= $booking_slots_per_day[0] && $tag == '') {
                    $tag = 3; // Fully Booked
                }
                if ($day_count > 0 && $tag == '') {
                    $tag = 1; // Part booked day.
                }
                echo $this->day_switch($tag, $row['daynumber']) . "<span>" . str_replace('|', '&nbsp;', $row['daynumber']) . "</span></td>";
            } else { // Show NULL day.
                echo "<td width='21' valign='top' class='days'><div class='box' id='key_null'></div></td>";
            }
            $i++;
        }
        echo "</tr>
        </table>";
        $this->make_key();
        $this->make_booking_slots();
    }
    function day_switch($tag, $daynumber) {
        switch ($tag) {
            case (1): // Part booked day
                $text = "<a href='calendar.php?month=" . $this->month . "&amp;year=" . $this->year . "&amp;day=" . sprintf("%02s", $daynumber) . '#selected_date' . "'><div class='box' id='key_partbooked'></div></a>";
                break;
            case (2): // Sunday
                $text = "<div class='box' id='key_sunday'></div>";
                break;
            case (3): // Fully booked day
                $text = "<div class='box' id='key_fullybooked'></div>";
                break;
            case (4): // Past day / Unavailable
                $text = "<div class='box' id='key_unavailable'></div></a>";
                break;
            default: // FREE
                $text = "<a href='calendar.php?month=" . $this->month . "&amp;year=" . $this->year . "&amp;day=" . sprintf("%02s", $daynumber) . '#selected_date' . "'><div class='box' id='key_available'></div>";
                break;
        }
        return $text;
    }
    function make_key() {
        // This key is displayed below the calendar to show what the colours represent
        echo "<table border='0' id='key'>
            <tr>
                <td id='key_fullybooked'>Fully Booked</td>
                <td id='key_sunday'>Sunday</td>
                <td id='key_partbooked'>Free (Partially)</td>
                <td id='key_available'>Free</td>
                <td id='key_unavailable'>Not Available</td>
            </tr>   
        </table>";
    }
    function make_booking_slots() {
        if ($this->day == 0) //default day = 0; done so to show that date is not chosen.
            {
            $this->select_day(); //no date selected.
        } else {
            $this->create_form(); //Shows form.
        }
    }
    function select_day() {
        echo "<form id='calendar_form' method='post' action=''>";
        echo "<div class='status' id='selected_date'>Please select a day</div>";
    }
    function make_table_top() {
        echo "<table border='0' cellpadding='0' cellspacing='0' id='calendar'>
            <tr id='week'>
            <td align='left'><a href='?month=" . date("m", $this->back) . "&amp;year=" . date("Y", $this->back) . "'>&laquo;</a></td>
            <td colspan='5' id='center_date'>" . date("F, Y", $this->selected_date) . "</td>    
            <td align='right'><a href='?month=" . date("m", $this->forward) . "&amp;year=" . date("Y", $this->forward) . "'>&raquo;</a></td>
            </tr>
        <tr>";
        $days = array(
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa",
            "Su"
        );
        for ($i = 0; $i < 7; $i++) {
            echo '<th>' . $days[$i] . '</th>';
        }
        if (empty($this->prior_bookings)) {
            $this->make_day_boxes($this->days, $this->month, $this->year);
        } else {
            $this->make_day_boxes($this->days, $this->prior_bookings, $this->month, $this->year);
        }
    }
    function create_form() {
        // Create array of the booking times
        $this->db->DoQuery("SELECT value FROM metadata WHERE id = '1'");
        $booking_start_time = $this->db->fetch();
        $this->db->DoQuery("SELECT value FROM metadata WHERE id = '2'");
        $booking_end_time = $this->db->fetch();
        $this->db->DoQuery("SELECT value FROM metadata WHERE id = '3'");
        $booking_frequency = $this->db->fetch();
        $this->db->DoQuery("SELECT * FROM service");
        $services = $this->db->fetchAll();
        for ($i = strtotime($booking_start_time[0]); $i <= strtotime($booking_end_time[0]); $i = $i + $booking_frequency[0] * 60) {
            $slots[] = date("H:i:s", $i);
        }
        echo "<form id='calendar_form' method='post' action=''>";
        echo "<div class='left'>";
        echo "<div class='status' id='selected_date'>Selected Date is: " . date("D, d F Y", mktime(0, 0, 0, $this->month, $this->day, $this->year)) . "</div>";
        $option = "<select id='select' name='booking_time'><option value='selectvalue'>Please select a booking time</option>";
        if ($this->count >= 1) {
            foreach ($this->prior_bookings as $row) {
                // Check for bookings and remove any previously booked slots                 
                foreach ($slots as $i => $r) {
                    if ($row['start'] == $r && $row['date'] == $this->year . '-' . $this->month . '-' . $this->day) {
                        unset($slots[$i]);
                    }
                }
            }
        } // If count bookings                   
        // Make select box from $slots array
        foreach ($slots as $booking_time) {
            $finish_time = strtotime($booking_time) + $booking_frequency[0] * 60; // Calculate finish time
            $option .= "<option value='" . $booking_time . "'>" . $booking_time . " - " . date("H:i:s", $finish_time) . "</option>";
        }
        echo $option . "</select><br>";
        echo "<select id='select' name='booking_service'>";
        echo "<option value='selectvalue'>Please select a Service</option>";
        foreach ($services as $row) {
            $text = $row[1] . " - &pound;" . $row[2];
            echo '<option value="' . $row[0] . '">' . $text . '</option>';
        }
        echo '</select><br>';
        echo "<textarea rows='3' cols='30' name='comments' placeholder='Any comments?'></textarea>";
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');
        echo recaptcha_get_html($publickey, $error);
        echo "<button type='submit'>Submit</button></form>";
    }
       function create_days_arr($year, $month) {
        // Creates array of days in the month.                 
        $num_days_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // Make array called $day with the correct number of days
        for ($i = 1; $i <= $num_days_month; $i++) {
            $d            = mktime(0, 0, 0, $month, $i, $year);
            $this->days[] = array(
                "daynumber" => $i,
                "dayname" => date("l", $d)
            );
        }
        // Add blank elements to start of array if the first day of the month is not a Monday.
        for ($j = 1; $j <= $this->first_day; $j++) {
            array_unshift($this->days, '0');
        }
        // Add blank elements to end of array if required.
        $pad_end = 7 - (count($this->days) % 7);
        if ($pad_end < 7) {
            for ($j = 1; $j <= $pad_end; $j++) {
                array_push($this->days, '|');
            }
        }
        $this->make_table_top();
    }
}
?>