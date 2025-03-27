<?php
// تضمين ملف WordPress
require_once dirname(__FILE__) . '/../../../wp-load.php';

// إعداد headers لإرجاع JSON
header('Content-Type: application/json');

// التحقق من أن الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}

// استدعاء مكتبة PHPMailer
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
    require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
    require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
}

// تنظيف وجمع البيانات
$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
$phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
$country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
$message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

// التحقق من البيانات المطلوبة
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please fill in all required fields'
    ]);
    exit;
}

// إنشاء كائن البريد
$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

try {
    // إعدادات SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mahmoudgalal55555@gmail.com';
    $mail->Password = 'hozvrrsnlpckfjwt'; // كلمة مرور التطبيق
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    
    // المرسل والمستقبل
    $mail->setFrom('mahmoudgalal55555@gmail.com', 'Luxor Private Tour');
    $mail->addAddress('info@LuxorPrivateTour.com', 'Luxor Private Tour');
    $mail->addReplyTo($email, $name);
    
    // محتوى الرسالة
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    
    // بناء محتوى البريد
    $body = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Phone:</strong> {$phone}</p>
    <p><strong>Country:</strong> {$country}</p>
    <p><strong>Message:</strong> {$message}</p>
    ";
    
    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);
    
    $mail->send();
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Your message has been sent successfully. We will contact you soon!'
    ]);
    
} catch (\Exception $e) {
    error_log('Mailer Error: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to send email. Error: ' . $mail->ErrorInfo
    ]);
}