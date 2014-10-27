<?php
class Email {
  var $subject;
  var $to;
  var $body;
  var $firstName;
  var $from;
  // A function which sets the recipient
  public function setRecipient($recipient)
  {
    $this->to = $recipient;
  }

  // A function which sets the first name
  public function setFirstName($namevar)
  {
    $this->firstName = $namevar;
  }
  
  // A function which sends the email
  public function send()
  {
    $headers = "From: $this->from" . "\r\n" .
               "Reply-To: $this->from" . "\r\n" .
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=iso-8859-1" . "\r\n";

    mail($this->to, $this->subject, $this->body, $headers);
  }

  // A function which sets the body, from and subject
  // to send an email about a status update for an order
  public function statusUpdate($number, $status)
  {
    $this->from       = "Star Dream Cakes <orders@ivanbrazza.biz>";

    $this->subject    = 'Your Order With Star Dream Cakes';

    $this->body       = '<html><body>';
    $this->body      .= '<p>Hi ' . $this->firstName . ',</p>';
    $this->body      .= '<p>Just to let you know that the status of your order ';
    $this->body      .=  $number . ' has been updated to ' . $status . '</p>';
    $this->body      .= '<p>To view your order, click on the link below:<br>';
    $this->body      .= '<a href="https://www.ivanbrazza.biz/your-orders/?order=' . $number;
    $this->body      .= '">https://www.ivanbrazza.biz/your-orders/?order=' . $number . '</a></p>';
    $this->body      .= '<p>If you have any problems, please don\'t hesistate to call.</p>';
    $this->body      .= '<p>Thanks,</p>';
    $this->body      .= '<p>Fran</p>';
  }

  // A function which sets the body, from and subject
  // to send an email containing the order placed
  public function order($orderDetails)
  {
    $this->from       = "Star Dream Cakes <orders@ivanbrazza.biz>";

    $this->subject    = 'Your Order With Star Dream Cakes';
  
    $this->body       = '<html><body>';
    $this->body      .= '<p>Hi ' . $this->firstName . ',</p>';
    $this->body      .= '<p>Here is the order you\'ve requested:</p>';
    $this->body      .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $this->body      .= '<tr><th>Order Number</td><td>' . $orderDetails['order_number'] . '</td></tr>';
    $this->body      .= '<tr><th>Date Order Placed</th><td>' . $orderDetails['order_placed'] . '</td></tr>';
    $this->body      .= '<tr><th>Required Date</th><td>' . $orderDetails['datetime'] . '</td></tr>';
    $this->body      .= '<tr><th>Date of Celebration</th><td>' . $orderDetails['celebration_date'] . '</td></tr>';
    $this->body      .= '<tr><th>Comments</th><td>' . $orderDetails['comments'] . '</td></tr>';
    $this->body      .= '<tr><th>Filling</th><td>' . $orderDetails['filling_name'] . '</td></tr>';
    $this->body      .= '<tr><th>Decoration</th><td>' . $orderDetails['decor_name'] . '</td></tr>';
    $this->body      .= '<tr><th>Cake Type</th><td>' . $orderDetails['cake_type'] . '</td></tr>';
    $this->body      .= '<tr><th>Cake Size</th><td>' . $orderDetails['cake_size'] . '</td></tr>';
    $this->body      .= '<tr><th>Delivery Type</th><td>' . $orderDetails['delivery_type'] . '</td></tr>';
    $this->body      .= '</table>';
    $this->body      .= '<p>If you have any problems, please don\'t hesitate to call.</p>';
    $this->body      .= '<p>Thanks,</p>';
    $this->body      .= '<p>Fran</p>';
    $this->body      .= '</body></html>';
  }

  // A function which sets the body, from and subject
  // to send a verification email
  public function verification($code)
  {
    $this->from       = "Star Dream Cakes <noreply@ivanbrazza.biz>";

    $this->subject    = "Register Your Email";

    $this->body       = '<html><body>';
    $this->body      .= '<p>Hi ' . $this->firstName . ',</p>';
    $this->body      .= '<p>Thank you for registering with Star Dream Cakes. Please click the link below to verify your account:</p>';
    $this->body      .= '<a href="http://www.ivanbrazza.biz/verify-email/?email=' . $this->to . '&code=' . $code . '">http://www.ivanbrazza.biz/verify-email/?email=' . $this->to . '&code=' . $code . '</a>';
    $this->body      .= '<br />';
    $this->body      .= '<p>Thank you,<br />';
    $this->body      .= 'Star Dream Cakes</p>';
    $this->body      .= '</body></html>';
  }
}
