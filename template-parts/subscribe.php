<section class="subscribe-section py-24 mb-12">
    <?php
    // معالجة نموذج الاشتراك
    if (isset($_POST['subscribe_email'])) { // هنا رجعنا للاسم الأصلي
        // استدعاء مكتبة PHPMailer
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
            require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
            require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
        }

        // تنظيف البريد الإلكتروني
        $email = sanitize_email($_POST['subscribe_email']);

        // التحقق من صحة البريد الإلكتروني
        if (!empty($email) && is_email($email)) {
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
                $mail->addReplyTo($email);
                
                // محتوى الرسالة
                $mail->isHTML(true);
                $mail->Subject = 'New Newsletter Subscription';
                
                // بناء محتوى البريد
                $body = "
                <h2>New Newsletter Subscription</h2>
                <p><strong>Email:</strong> {$email}</p>
                <p>This user has subscribed to your newsletter.</p>
                ";
                
                $mail->Body = $body;
                $mail->AltBody = strip_tags($body);
                
                $mail->send();
                
                $subscribe_success = "Thank you for subscribing to our newsletter!";
            } catch (\Exception $e) {
                $subscribe_error = "Failed to process your subscription. Please try again later.";
                error_log('Mailer Error: ' . $e->getMessage()); // سجل الخطأ في سجل الووردبريس
            }
        } else {
            $subscribe_error = "Please enter a valid email address.";
        }
    }
    ?>

    <!-- Background Planes -->
    <div class="plane-icon plane-left">
        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/subs.svg" alt="Decorative plane" width="200" height="120">
    </div>
    <div class="plane-icon plane-right">
        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/subs1.svg" alt="Decorative plane"  width="200" height="120">
    </div>

    <div class="container mx-auto px-4 text-center">
        <h2 class="subscribe-title text-4xl font-semibold mb-4">Subscribe Now</h2>
        <p class="text-white text-lg mb-8">Enter your e-mail to Subscribe and get exclusive deals & offer</p>
        
        <!-- Subscribe Form -->
        <div class="max-w-xl mx-auto subscribe-form-custom"> <!-- غيرنا الكلاس هنا -->
            <?php if (isset($subscribe_success)): ?>
                <div class="mt-4 mb-4 rounded-lg p-3 text-center text-sm bg-green-100 text-green-700">
                    <?php echo $subscribe_success; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($subscribe_error)): ?>
                <div class="mt-4 mb-4 rounded-lg p-3 text-center text-sm bg-red-100 text-red-700">
                    <?php echo $subscribe_error; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="relative flex" id="subscribe-custom-form">
                <div class="input-wrapper">
                    <i class="fas fa-envelope email-icon"></i>
                    <input 
                        type="email" 
                        name="subscribe_email" 
                        placeholder="E-mail" 
                        class="subscribe-input text-gray-700 focus:outline-none"
                        required
                    >
                </div>
                <button 
                    type="submit" 
                    class="absolute right-0 bg-[#C8E677] text-[#06414A] font-medium px-8 py-2 rounded-full hover:bg-[#b3ff1a] transition-colors mr-2 mt-1"
                >
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>

<style>
    .subscribe-section {
        background-color: #276C76;
        position: relative;
        overflow: hidden;
    }
    
    .plane-icon {
        opacity: 0.7;
        position: absolute;
    }
    
    .plane-left {
        left: 13%;
        top: 50%;
    }
    
    .plane-right {
        right: 10%;
        top: 10%;
    }
    
    /* تم تغيير معرف الفورم هنا أيضًا */
    .subscribe-form-custom .input-wrapper {
        position: relative;
        width: 100%;
    }
    
    .subscribe-form-custom .input-wrapper input {
        width:100% !important;
    }
    
    .email-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
    
    .subscribe-input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 9999px;
    }
    
    @media (max-width: 768px) {
        .subscribe-form-custom {
            width: 90%;
        }
        .plane-left {
            left: 1%;
            top: 70%;
        }
        
        .plane-right {
            right: 1%;
            top: 0%;
        }
    }
    
    .subscribe-title {
        color: #C5FF4A;
        font-family: "Berkshire Swash", serif;
        font-size: 48px !important;
        font-weight: 400 !important;
        line-height: 76.8px !important;
        text-align: center !important;
        z-index: 2;
    }

    .subscribe-section p {
        font-size: 24px !important;
        font-weight: 400 !important;
        line-height: 38.4px !important;
        z-index: 3;
    }

    @media (max-width: 768px) {
        .subscribe-section h2 {
            font-size: 36px !important;
            line-height: 57.6px !important;
        }

        .subscribe-section p {
            font-size: 14px !important;
            line-height: 22.4p !important;
        }
    }
</style>