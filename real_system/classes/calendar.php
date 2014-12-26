<?php
class booking_diary
{
    public $day, $month, $year, $selected_date, $first_day, $back, $back_month, $back_year, $forward, $forward_month, $forward_year, $bookings, $count, $days;

    //----------
    function make_calendar($selected_date, $first_day, $back, $forward, $day, $month, $year)
    {
        // Add a value to these public variables  
        $this->day           = $day;
        $this->month         = $month;
        $this->year          = $year;
        $this->selected_date = $selected_date;
        $this->first_day     = $first_day;
        $this->back          = $back;
        $this->back_month    = date("m", $back);
        $this->back_year     = date("Y", $back); // Minus one month back arrow
        $this->forward       = $forward;
        $this->forward_month = date("m", $forward);
        $this->forward_year  = date("Y", $forward); // Add one month forward arrow    
        // Make the booking array
        $this->start_booking($year, $month);
    }
    function start_booking($year, $month)
    {
        $period = $year.'-'.$month.'%';
        $this->db = new database();
        $this->db->initiate();
        $query = "SELECT * FROM booking WHERE date LIKE :period";
        $query_params = array(
            ':period' => $period
        );
        $this->db->DoQuery($query, $query_params);
        // $number_of_rows = $this->db->RowCount();
        $this->count = $this->db->RowCount();
        // $fetch_array    = $this->db->fetch();
        while ($rows = $this->db->fetch()){
            $this->bookings[] = array(
                "name" => $rows['username'],
                "date" => $rows['date'],
                "start" => $rows['time'],
                "comments" => $rows['comments']
            );
        }
        $this->create_days_arr($year, $month);
    } // Close function
    function create_days_arr($year, $month)
    {
        // Create an array of days in the month                 
        $num_days_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // Make array called $day with the correct number of days
        for ($i = 1; $i <= $num_days_month; $i++)
        {
            $d = mktime(0, 0, 0, $month, $i, $year);
            $this->days[] = array(
                "daynumber" => $i,
                "dayname" => date("l", $d)
            );
        }
        // Add blank elements to start of array if the first day of the month is not a Monday.
        for ($j = 1; $j <= $this->first_day; $j++)
        {
            array_unshift($this->days, '0');
        }
        // Add blank elements to end of array if required.
        $pad_end = 7 - (count($this->days) % 7);
        if ($pad_end < 7)
        {
            for ($j = 1; $j <= $pad_end; $j++)
            {
                array_push($this->days, '|');
            }
        } // Close if
        $this->make_table_top();
    } // Close function
    function make_table_top()
    {
        echo "<table border='0' cellpadding='0' cellspacing='0' id='calendar'>
            <tr id='week'>
            <td align='left'><a href='?month=" . date("m", $this->back) . "&amp;year=" . date("Y", $this->back) . "'>&laquo;</a></td>
            <td colspan='5' id='center_date'>" . date("F, Y", $this->selected_date) . "</td>    
            <td align='right'><a href='?month=" . date("m", $this->forward) . "&amp;year=" . date("Y", $this->forward) . "'>&raquo;</a></td>
        </tr>
        <tr>";
        
        $days = array("Mo","Tu","We","Th","Fr","Sa","Su");
        for($i=0; $i<7; $i++){
            echo '<th>'.$days[$i].'</th>';
        }

        $this->make_day_boxes($this->days, $this->bookings, $this->month, $this->year);
    } // Close function
    function make_day_boxes()
    {
        $this->db = new database();
        $this->db->initiate();
        $opentime = "SELECT value FROM metadata WHERE id = '4'";
        $this->db->DoQuery($opentime);
        $booking_slots_per_day = $this->db->fetch();

        $first_day_of_month = $this->year . "-" . $this->month . "-" . "01";
        $closed_days_query = "SELECT date FROM closed_days WHERE YEAR(date) = YEAR('$first_day_of_month') AND MONTH(date) = MONTH('$first_day_of_month')";
        $this->db->DoQuery($closed_days_query);
        $closed_days = $this->db->fetchAll();

        $i = 0;
        foreach ($this->days as $row)
        {
            $tag = '';
            if ($i % 7 == 0)
                echo "</tr><tr>"; // Use modulus to give us a <tr> after every seven <td> cells
            if (isset($row['daynumber']) && $row['daynumber'] != 0) // Padded days at the start of the month will have a 0 at the beginning
            {
                echo "<td width='21' valign='top' class='days'>";
                if ($this->count > 0)
                {
                    $day_count = 0;
                    foreach ($this->bookings as $booking_date)
                    {
                        if ($booking_date['date'] == $this->year . '-' . $this->month . '-' . sprintf("%02s", $row['daynumber']))
                        {
                            $day_count++;
                        } // Close if
                    } // Close foreach
                } // Close if $count

                // Work out which colour day box to show
                if ($row['dayname'] == 'Sunday')
                    $tag = 2; // It's a Sunday

                $this_day = $this->year ."-". $this->month ."-". $row['daynumber'];
                foreach ($closed_days as $item) {  // It's a closed day, set from the database.
                    if (strtotime($item['date']) == strtotime($this_day)){
                        $tag = 4;
                    }
                }

                if (mktime(0, 0, 0, $this->month, sprintf("%02s", $row['daynumber']) + 1, $this->year) < strtotime("now"))
                    $tag = 4; // Past Day / Unavailable 
                if ($day_count >= $booking_slots_per_day[0] && $tag == '')
                    $tag = 3; // Fully Booked
                if ($day_count > 0 && $tag == '')
                    $tag = 1; // Part booked day.
                echo $this->day_switch($tag, $row['daynumber']) . "<span>" . str_replace('|', '&nbsp;', $row['daynumber']) . "</span></td>";
            }
            else
            {   // Show NULL day.
                echo "<td width='21' valign='top' class='days'><div class='box' id='key_null'></div></td>";
            }
            $i++;
        } // Close foreach
        $this->make_key();
    } // Close function
    function day_switch($tag, $daynumber)
    {
        switch ($tag)
        {
            case (1): // Part booked day
                $txt = "<a href='calendar.php?month=" . $this->month . "&amp;year=" . $this->year . "&amp;day=" . sprintf("%02s", $daynumber) . '#selected_date'."'><div class='box' id='key_partbooked'></div></a>\r\n";
                break;
            case (2): // Sunday
                $txt = "<div class='box' id='key_sunday'></div>\r\n";
                break;
            case (3): // Fully booked day
                $txt = "<div class='box' id='key_fullybooked'></div>\r\n";
                break;
            case (4): // Past day / Unavailable
                $txt = "<div class='box' id='key_unavailable'></div></a>\r\n";
                break;
            default: // FREE
                $txt = "<a href='calendar.php?month=" . $this->month . "&amp;year=" . $this->year . "&amp;day=" . sprintf("%02s", $daynumber) . '#selected_date'."'><div class='box' id='key_available'></div>\r\n";
                break;
        }
        return $txt;
    } // Close function
    function make_key()
    {
        // This key is displayed below the calendar to show what the colours represent
        echo "</tr>
        </table>
        <table border='0' id='key'>
            <tr>
                <td id='key_fullybooked'></td>
                <td id='key_sunday'></td>
                <td id='key_partbooked'></td>
                <td id='key_available'></td>
                <td id='key_unavailable'></td>
            </tr>
            <tr>
                <td>Fully Booked</td>
                <td>Sunday</td>
                <td>Free (Partially)</td>
                <td>Free</td>
                <td>Not Available</td>
            </tr>                
        </table>";
        $this->make_booking_slots();
    } // Close function
    function make_booking_slots()
    {
        /*
        Variable $day has a default value of 0.  If a day has been clicked on, display it.
        If there is no date selected, show a msg.  Otherwise show the booking form.
        */
        if ($this->day == 0)
        {
            $this->select_day();
        }
        else
        {
            $this->create_form();
        }
    } // Close function  
    function select_day()
    {
        echo "<form id='calendar_form' method='post' action=''>";
        echo "<div class='status' id='selected_date'>Please select a day</div>";
    }
    function create_form()
    {
        // Create array of the booking times

            $this->db = new database();
            $this->db->initiate();
            $opentime = "SELECT value FROM metadata WHERE id = '1'";
            $this->db->DoQuery($opentime);
            $booking_start_time = $this->db->fetch();
            $closingtime = "SELECT value FROM metadata WHERE id = '2'";
            $this->db->DoQuery($closingtime);
            $booking_end_time = $this->db->fetch();
            $frequency = "SELECT value FROM metadata WHERE id = '3'";
            $this->db->DoQuery($frequency);
            $booking_frequency = $this->db->fetch();
        
        for ($i = strtotime($booking_start_time[0]); $i <= strtotime($booking_end_time[0]); $i = $i + $booking_frequency[0] * 60)
        {
            $slots[] = date("H:i:s", $i);
        }
        echo "\r\n\r\n<form id='calendar_form' method='post' action=''>";
        echo "<div class='left'>";
        echo "<div class='status' id='selected_date'>Selected Date is: ".date("D, d F Y", mktime(0, 0, 0, $this->month, $this->day)) . "</div>";
        $opt = "<select id='select' name='booking_time'><option value='selectvalue'>Please select a booking time</option>";
        if ($this->count >= 1)
        {
            foreach ($this->bookings as $row) {
                // Check for bookings and remove any previously booked slots                 
                foreach ($slots as $i => $r)
                {
                    if ($row['start'] == $r && $row['date'] == $this->year . '-' . $this->month . '-' . $this->day)
                    {
                        unset($slots[$i]);
                    }
                } // Close foreach
            } // Close foreach 
        } // If count bookings                   
        // Make select box from $slots array
        foreach ($slots as $booking_time)
        {
            $finish_time = strtotime($booking_time) + $booking_frequency[0] * 60; // Calculate finish time
            $opt .= "<option value='" . $booking_time . "'>" . $booking_time . " - " . date("H:i:s", $finish_time) . "</option>";
        }
        echo $opt . "</select><br>";
        // start service box from $slots array     
        echo "<select id='select' name='booking_service'>";
        echo "<option value='selectvalue'>Please select a Service</option>";
        $this->db = new database();
        $this->db->initiate();
        $query = "SELECT * FROM service";
        $this->db->DoQuery($query);
        $num = $this->db->fetchAll(PDO::FETCH_NUM);
        foreach ($num as $row)
        {
            $text = $row[1] . " - &pound;" . $row[2];
            echo '<option value="' . $row[0] . '">' . $text . '</option>';
        }
        ;
        echo '</select><br>';
        // end select box from $service array
        echo "<table id='booking'><textarea rows='3' cols='30' name='comments' placeholder='Any comments?'>";
        echo "</textarea>";
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');
        echo recaptcha_get_html($publickey, $error); 
        echo "<button type='submit'>Submit</button></table></form>";
    }
    function after_post($month, $day, $year)
    {
        include('assets/recaptcha_values.php');
        include_once('assets/recaptcha.php');
        $errors = array();
        if (isset($_POST['booking_time']) && $_POST['booking_time'] == 'selectvalue')
        {
            array_push($errors, "Please select a booking time");
        }
        if (isset($_POST['booking_service']) && $_POST['booking_service'] == 'selectvalue')
        {
            array_push($errors, "Please select a service");
        }
        if (strlen($_POST["recaptcha_response_field"]) == 0) {
            array_push($errors, "Please type in the captcha.");
        }
        if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if (!$resp->is_valid) {
                 array_push($errors, "The captcha is incorrect. Please try again.");
            }
        }

        if (!empty($errors))
        {
            foreach ($errors as $error){
                echo "<div class='error'>" .  $error . "</div>";
            }
        }
        else {
            $this->db = new database();
            $this->db->initiate();
            $booking_date    = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
            $booking_time    = $_POST['booking_time'];
            $booking_service = $_POST['booking_service'];
            $query           = "INSERT INTO booking (date, time, username, comments, confirmedbystaff, service_id, staff_id) VALUES (:booking_date, :booking_time, :username, :comments, :confirmed, :service_id, :staff_id)";
            $query_params    = array(
                ':booking_date' => $booking_date,
                ':booking_time' => $booking_time,
                ':service_id' => $booking_service,
                ':username' => $_COOKIE['userdata']['username'],
                ':comments' => $_POST['comments'],
                ':confirmed' => 0,
                ':staff_id' => 1
            );
            $this->db->DoQuery($query, $query_params);
            $this->confirmation($booking_date, $booking_time, $booking_service, $_COOKIE['userdata']['username']);
        } // Close else
    } // Close function  
    function confirmation($date, $time, $serviceid, $username)
    {
            include('functions/email.php');
            $this->db = new database();
            $this->db->initiate();

            $query = "SELECT type FROM service WHERE id = '$serviceid'";
            $this->db->DoQuery($query);
            $service = $this->db->fetch();

            $query2 = "SELECT email FROM users WHERE username = '$username'";
            $this->db->DoQuery($query2);
            $email = $this->db->fetch();

            $extra = array(
                ':bookingday' => $date,
                ':bookingtime' => $time,
                ':bookingservice' => $service[0]
            );

            $customer_email = $email['email'];
            $forename = $_COOKIE['userdata']['forename'];
            $type = "appointment";

        email($customer_email, $username, $forename, $type, $extra);
        echo "<meta http-equiv='refresh' content='0; url=confirmation.php?type=appointment'/>";
    } // Close function  
}
?>