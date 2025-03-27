<?php
// بدء جلسة في بداية الملف
session_start();

// single-tour.php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";

// الحصول على معرف الصفحة الحالية
$trip_id = get_the_ID();
$trip_title = get_the_title($trip_id);

// معالجة إرسال الفورم - التحقق أنه لم يتم إرساله بالفعل في هذه الجلسة
if (isset($_POST['submit_inquiry']) && !isset($_SESSION['inquiry_sent'])) {
    // استدعاء مكتبة PHPMailer
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
        require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
        require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
    }
    
    // تنظيف البيانات المستلمة
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $country = sanitize_text_field($_POST['country']);
    $date = sanitize_text_field($_POST['date']);
    $children = intval($_POST['children']);
    $adults = intval($_POST['adults']);
    $message = sanitize_textarea_field($_POST['message']);
    
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
        $mail->Subject = 'New Inquiry: ' . $trip_title;
        
        // بناء محتوى البريد
        $body = "
        <h2>New Tour Inquiry</h2>
        <p><strong>Tour:</strong> {$trip_title}</p>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Country:</strong> {$country}</p>
        <p><strong>Date:</strong> {$date}</p>
        <p><strong>Number of Children:</strong> {$children}</p>
        <p><strong>Number of Adults:</strong> {$adults}</p>
        <p><strong>Message:</strong> {$message}</p>
        ";
        
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
        
        $mail->send();
        
        // تعيين متغير مؤقت لمنع إعادة الإرسال عند تحديث الصفحة
        $_SESSION['inquiry_sent'] = true;
        
        // إظهار رسالة النجاح دون إعادة توجيه
        $success_message = "Your Inquiry Sent, Will Contact With you soon";
        
        // استخدام JavaScript لتغيير URL الصفحة بدون إعادة تحميلها (لمنع إعادة الإرسال عند التحديث)
        echo '<script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>';
        
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $error_message = "Error: " . $mail->ErrorInfo;
    }
}

// مسح متغير الجلسة بعد تحديث الصفحة للسماح بإرسال آخر
if (isset($_SESSION['inquiry_sent']) && !isset($_POST['submit_inquiry'])) {
    unset($_SESSION['inquiry_sent']);
}
?>

<div class="w-full mx-auto shadow-lg rounded-lg p-6 bg-[#F9FBF9]">
    <h2 class="text-2xl text-[<?= $_primary ?>] font-bold mb-6 text-center">Inquiry Form</h2>
    
    <?php if (isset($success_message)): ?>
    <div class="p-3 mb-4 bg-green-100 text-green-800 rounded-lg">
        <?php echo $success_message; ?>
    </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
    <div class="p-3 mb-4 bg-red-100 text-red-800 rounded-lg">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>

    <form method="post">
        <!-- إضافة حقل مخفي لتخزين عنوان الرحلة -->
        <input type="hidden" name="trip_title" value="<?php echo esc_attr($trip_title); ?>">
        
        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="name">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/user.svg" alt="user icon" />
                <span>Your Name</span>
            </label>
            <input type="text" id="name" name="name" style="width:100% !important"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="example" required>
        </div>

        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="email">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/email.svg" alt="email icon" />
                <span>Email</span>
            </label>
            <input type="email" id="email" name="email" style="width:100% !important"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="example@gmail.com" required>
        </div>

        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="phone">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/phone.svg" alt="phone icon" />
                <span>Phone Number</span>
            </label>
            <div class="relative w-full">
                <input type="tel" id="phone" name="phone" style="width:100% !important"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="+20 3746739200" required>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="country">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/country.svg" alt="country icon" />
                <span>Country</span>
            </label>
            <input id="country" name="country" style="width:100% !important"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        
        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="date">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/date.svg" alt="date icon" />
                <span>Date</span>
            </label>
            <input type="date" id="date" name="date" style="width:100% !important"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <div class="mb-4 flex justify-between items-start">
            <label class="flex justify-start gap-1 items-start text-sm mb-1" for="children">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/children.svg" alt="children icon" />
                <p class="flex flex-col">
                    <span>Number of Children</span>
                    <span class="text-gray-500">( 2 - 11 years )</span>
                </p>
            </label>
            <div class="flex items-center bg-white rounded-lg p-2 shadow-md border-gray-100 border-2 w-[50%]">
                <button type="button" class="rounded-l-lg px-3" onclick="changeQuantity('children', -1)">-</button>
                <input type="number" id="children" name="children" class="w-16 text-center" value="0" readonly>
                <button type="button" class="rounded-r-lg px-3" onclick="changeQuantity('children', 1)">+</button>
            </div>
        </div>
        
        <div class="mb-4 flex justify-between items-start">
            <label class="flex justify-start gap-1 items-start text-sm mb-1" for="adults">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/adults.svg" alt="adults icon" />
                <p class="flex flex-col">
                    <span>Number of Adults</span>
                    <span class="text-gray-500">( +12 years )</span>
                </p>
            </label>

            <div class="flex items-center bg-white rounded-lg p-2 shadow-md border-gray-100 border-2 w-[50%]">
                <button type="button" class="rounded-l-lg px-3" onclick="changeQuantity('adults', -1)">-</button>
                <input type="number" id="adults" name="adults" class="w-16 text-center" value="0" readonly>
                <button type="button" class="rounded-r-lg px-3" onclick="changeQuantity('adults', 1)">+</button>
            </div>
        </div>

        <div class="mb-4">
            <label class="flex justify-start gap-1 items-center text-sm mb-1" for="message">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/message.svg" alt="message icon" />
                <span>Message</span>
            </label>
            <textarea id="message" name="message" style="width:100% !important"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                rows="4" placeholder="Tell us about your requirements about the trip"></textarea>
        </div>

        <button type="submit" name="submit_inquiry"
            class="w-full bg-[<?= $_yellow ?>] text-[<?= $_primary ?>] font-semibold rounded-2xl py-2 transition duration-200">Submit
            Inquiry</button>
    </form>
</div>

<style>
    .iti--allow-dropdown{
      width:100% !important;
    }
</style>

<script src="https://cdn.tailwindcss.com"></script>

<script>
    function changeQuantity(type, delta) {
        const input = document.getElementById(type);
        let currentValue = parseInt(input.value);
        currentValue = Math.max(0, currentValue + delta); 
        input.value = currentValue;
    }
</script>