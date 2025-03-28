<?php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
// Get current post ID
$trip_id = get_the_ID();  
$current_destination_id = get_post_meta($trip_id, 'trip_destination', true);
// Get the tour type of the current trip
$current_tour_type = get_post_meta($trip_id, 'trip_tour_type', true);

// Get trip details
$trip_title = get_the_title($trip_id);
$trip_status = get_post_meta($trip_id, 'trip_status', true);
$trip_caption = get_post_meta($trip_id, 'trip_caption', true);
$trip_price = get_post_meta($trip_id, 'trip_price', true);
$trip_rating = get_post_meta($trip_id, 'trip_rating', true);
$trip_discount = get_post_meta($trip_id, 'trip_discount', true);
$trip_duration = get_post_meta($trip_id, 'trip_duration', true);
$trip_staus = get_post_meta($trip_id, 'trip_gallery', true);
$btn_txt =  get_post_meta($trip_id, 'see_btn_txt', true);
$btn_link =  get_post_meta($trip_id, 'see_btn_link', true);
$trip_gallery = get_post_meta($trip_id, 'trip_gallery', true);
$trip_gallery = get_post_meta($trip_id, 'trip_gallery', true);

// Ensure it's always an array
$trip_gallery = is_array($trip_gallery) ? $trip_gallery : (is_string($trip_gallery) ? explode(',', $trip_gallery) : []);

// Get image URLs
$trip_gallery_urls = array_values(array_filter(array_map('wp_get_attachment_url', $trip_gallery))); 



$gallery_json = !empty($trip_gallery_urls) ? json_encode($trip_gallery_urls) : '[]';
$trip_thumbnail = !empty($trip_gallery_urls) ? reset($trip_gallery_urls) : "no-image.jpg";

// Safely get thumbnails, ensuring indexes exist
$trip_thumbnail1 = $trip_gallery_urls[0] ?? null;
$trip_thumbnail2 = $trip_gallery_urls[1] ?? null;
$trip_thumbnail3 = $trip_gallery_urls[2] ?? null;
$trip_thumbnail4 = $trip_gallery_urls[3] ?? null;


?>


<?php if ($trip_title) :?>
<section class="hero-section max-w-7xl px-0 md:px-4 lg:px-8 mx-auto pt-4 md:pt-6">
    <!-- Desktop -->
    <div class="hidden md:grid grid-cols-12 gap-4 h-[550px]">
        <!-- Left side - Main Image -->
        <div class="relative h-full col-span-4">
            <div class="absolute top-4 left-4 z-10">
                <span class="bg-[#FFB800] px-3 py-1 rounded-full text-sm font-medium"><?php echo esc_html($trip_status) ?></span>
            </div>
     
           
            <?php if (!empty($trip_thumbnail1)): ?>
                <img src="<?php echo esc_url($trip_thumbnail1); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover">
            <?php endif; ?>
        </div>

        <!-- Right side content -->
        <div class="flex flex-col justify-between h-full col-span-8">
            <!-- Header Content -->
            <div>
                <h1 style="font-family: 'Berkshire Swash', cursive;"
                    class="text-[32px] sm:text-[32px] lg:text-[64px] font-semibold mb-4 text-[<?= $_yellow ?>]">
                <?php echo esc_html($trip_title)?>
                </h1>
                <ul class="grid grid-cols-12 gap-2 md:gap-6 mb-8 ">
                    <li class="flex items-center justify-start gap-2 col-span-6 md:col-span-7">
                        <p class="w-[32px] h-[32px] rounded-full bg-[#FDFDFDB2] flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_243_2335)">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_243_2335)">
								<path
									d="M8 13C10.7614 13 13 10.7614 13 8C13 5.23858 10.7614 3 8 3C5.23858 3 3 5.23858 3 8C3 10.7614 5.23858 13 8 13Z"
									fill="<?= $_primary ?>" />
								<path
									d="M14.6667 8.49992C14.5341 8.49992 14.4069 8.44724 14.3131 8.35347C14.2193 8.25971 14.1667 8.13253 14.1667 7.99992C14.1669 7.64732 14.1368 7.29536 14.0767 6.94792C14.0655 6.88318 14.0672 6.81687 14.0817 6.75279C14.0961 6.6887 14.1231 6.62809 14.161 6.57442C14.1988 6.52075 14.2469 6.47506 14.3025 6.43998C14.358 6.40489 14.4199 6.38108 14.4847 6.36992C14.6154 6.34738 14.7498 6.3777 14.8582 6.45421C14.9118 6.4921 14.9575 6.54019 14.9926 6.59573C15.0277 6.65127 15.0515 6.71318 15.0627 6.77792C15.1317 7.18159 15.1665 7.59038 15.1667 7.99992C15.1667 8.13253 15.114 8.25971 15.0202 8.35347C14.9265 8.44724 14.7993 8.49992 14.6667 8.49992ZM14.2133 6.08059C14.1125 6.08088 14.014 6.05065 13.9307 5.99389C13.8474 5.93714 13.7833 5.8565 13.7467 5.76259C13.597 5.37977 13.4098 5.01265 13.188 4.66659C13.1525 4.61135 13.1282 4.54965 13.1166 4.48503C13.1049 4.4204 13.1061 4.35412 13.1201 4.28995C13.134 4.22579 13.1605 4.165 13.1979 4.11106C13.2354 4.05712 13.2831 4.01109 13.3383 3.97559C13.3936 3.94009 13.4553 3.91581 13.5199 3.90416C13.5845 3.8925 13.6508 3.89368 13.715 3.90764C13.7791 3.9216 13.8399 3.94806 13.8939 3.98552C13.9478 4.02297 13.9938 4.07068 14.0293 4.12592C14.288 4.52784 14.5057 4.95464 14.6793 5.39992C14.7275 5.52343 14.7246 5.66099 14.6713 5.78238C14.6181 5.90377 14.5188 5.99904 14.3953 6.04726C14.3372 6.06934 14.2755 6.08064 14.2133 6.08059ZM12.2933 3.39992C12.1754 3.39995 12.0613 3.35814 11.9713 3.28192C11.657 3.01656 11.3169 2.7834 10.956 2.58592C10.8397 2.52227 10.7534 2.41501 10.7161 2.28773C10.6789 2.16046 10.6937 2.0236 10.7573 1.90725C10.821 1.79091 10.9282 1.70462 11.0555 1.66736C11.1828 1.63011 11.3197 1.64494 11.436 1.70859C11.8554 1.93803 12.2507 2.20894 12.616 2.51725C12.6946 2.58331 12.7509 2.67195 12.7773 2.77112C12.8037 2.87029 12.799 2.97519 12.7638 3.07159C12.7286 3.16799 12.6645 3.2512 12.5803 3.30994C12.4962 3.36868 12.396 3.4001 12.2933 3.39992ZM9.96933 2.12925C9.91914 2.12914 9.86926 2.1215 9.82133 2.10659C9.23135 1.92473 8.61738 1.83259 8 1.83325C7.86739 1.83325 7.74022 1.78058 7.64645 1.68681C7.55268 1.59304 7.5 1.46586 7.5 1.33325C7.5 1.20065 7.55268 1.07347 7.64645 0.979701C7.74022 0.885933 7.86739 0.833254 8 0.833254C8.71776 0.832698 9.43153 0.940123 10.1173 1.15192C10.2314 1.18749 10.329 1.26274 10.3924 1.36403C10.4557 1.46533 10.4808 1.58597 10.4629 1.70412C10.445 1.82226 10.3854 1.93009 10.2948 2.00808C10.2043 2.08607 10.0888 2.12905 9.96933 2.12925Z"
									fill="<?= $_primary ?>" />
								<path
									d="M8.00065 15.1666C6.09993 15.1666 4.27706 14.4115 2.93305 13.0675C1.58904 11.7235 0.833984 9.90064 0.833984 7.99992C0.833984 6.0992 1.58904 4.27633 2.93305 2.93232C4.27706 1.58831 6.09993 0.833252 8.00065 0.833252C8.13326 0.833252 8.26044 0.88593 8.3542 0.979699C8.44797 1.07347 8.50065 1.20064 8.50065 1.33325C8.50065 1.46586 8.44797 1.59304 8.3542 1.68681C8.26044 1.78057 8.13326 1.83325 8.00065 1.83325C6.781 1.83325 5.58874 2.19492 4.57463 2.87252C3.56053 3.55012 2.77013 4.51323 2.30339 5.64004C1.83665 6.76685 1.71453 8.00676 1.95247 9.20298C2.19042 10.3992 2.77774 11.498 3.64016 12.3604C4.50258 13.2228 5.60138 13.8102 6.79759 14.0481C7.99381 14.286 9.23372 14.1639 10.3605 13.6972C11.4873 13.2304 12.4504 12.44 13.128 11.4259C13.8056 10.4118 14.1673 9.21957 14.1673 7.99992C14.1673 7.86731 14.22 7.74013 14.3138 7.64637C14.4075 7.5526 14.5347 7.49992 14.6673 7.49992C14.7999 7.49992 14.9271 7.5526 15.0209 7.64637C15.1146 7.74013 15.1673 7.86731 15.1673 7.99992C15.1652 9.89999 14.4095 11.7216 13.0659 13.0652C11.7224 14.4087 9.90072 15.1645 8.00065 15.1666Z"
									fill="<?= $_primary ?>" />
								<path
									d="M10.668 10.4998C10.56 10.4998 10.4549 10.4647 10.3686 10.3998L7.70195 8.39984C7.63985 8.35326 7.58945 8.29287 7.55474 8.22344C7.52003 8.15402 7.50195 8.07746 7.50195 7.99984V4.6665C7.50195 4.5339 7.55463 4.40672 7.6484 4.31295C7.74217 4.21918 7.86934 4.1665 8.00195 4.1665C8.13456 4.1665 8.26174 4.21918 8.35551 4.31295C8.44927 4.40672 8.50195 4.5339 8.50195 4.6665V7.74984L10.9686 9.59984C11.0526 9.66284 11.1147 9.75068 11.1459 9.85091C11.1772 9.95115 11.1761 10.0587 11.1429 10.1583C11.1096 10.2579 11.0458 10.3444 10.9606 10.4058C10.8753 10.4671 10.773 10.5 10.668 10.4998Z"
									fill="white" />
							</g>
							<defs>
								<clipPath id="clip0_243_2335">
									<rect width="16" height="16" fill="white" />
								</clipPath>
							</defs>
						</svg>                                </g>
                            </svg>
                        </p>
                        <p class="text-gray-100 text-sm font-light md:font-medium md:text-base">Duration: <strong><?php echo esc_html($trip_duration) ?> Day</strong>
                        </p>
                    </li>
                    <li class="flex items-center justify-start gap-2 col-span-6 md:col-span-5">
                        <p class="w-[32px] h-[32px] rounded-full bg-[#FDFDFDB2] flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M9.67077 3.40012L10.6127 2.48181C10.6798 2.41644 10.7272 2.33358 10.7497 2.24262C10.7721 2.15167 10.7687 2.05624 10.7397 1.96715C10.7107 1.87806 10.6573 1.79887 10.5857 1.73853C10.514 1.67819 10.4269 1.63911 10.3342 1.62573L9.03197 1.43655L8.44987 0.256804C8.40363 0.178575 8.3378 0.113749 8.25887 0.0687163C8.17993 0.0236838 8.09063 0 7.99975 0C7.90888 0 7.81957 0.0236838 7.74064 0.0687163C7.66171 0.113749 7.59588 0.178575 7.54963 0.256804L6.96754 1.43655L5.66535 1.62573C5.57267 1.63919 5.4856 1.67832 5.414 1.73869C5.3424 1.79906 5.28912 1.87827 5.26019 1.96734C5.23127 2.05642 5.22784 2.15181 5.25032 2.24273C5.27279 2.33365 5.32025 2.41647 5.38735 2.48181L6.32924 3.40012L6.10694 4.69729C6.09119 4.7895 6.10154 4.88429 6.13681 4.97093C6.17208 5.05758 6.23087 5.13264 6.30654 5.18765C6.38221 5.24265 6.47175 5.27541 6.56505 5.28222C6.65835 5.28903 6.7517 5.26963 6.83456 5.22619L7.99975 4.61399L9.16444 5.22619C9.24732 5.26976 9.34073 5.28928 9.43411 5.28254C9.5275 5.27579 9.61713 5.24306 9.69288 5.18803C9.76863 5.13301 9.82748 5.05789 9.86277 4.97116C9.89806 4.88444 9.90838 4.78957 9.89257 4.69729L9.67077 3.40012ZM16.0041 3.4508C15.9751 3.36182 15.9218 3.28272 15.8503 3.22242C15.7787 3.16212 15.6917 3.12304 15.5991 3.10957L14.2969 2.91989L13.7143 1.74014C13.6682 1.66179 13.6024 1.59684 13.5234 1.55172C13.4445 1.50659 13.3551 1.48285 13.2642 1.48285C13.1733 1.48285 13.0839 1.50659 13.005 1.55172C12.926 1.59684 12.8602 1.66179 12.8141 1.74014L12.232 2.91989L10.9298 3.10907C10.8371 3.12253 10.7501 3.16166 10.6784 3.22203C10.6068 3.2824 10.5536 3.36161 10.5246 3.45068C10.4957 3.53976 10.4923 3.63515 10.5148 3.72607C10.5372 3.81699 10.5847 3.89981 10.6518 3.96515L11.5942 4.88346L11.3714 6.18063C11.3555 6.27295 11.3657 6.36789 11.4009 6.45469C11.4362 6.54149 11.495 6.6167 11.5708 6.67179C11.6466 6.72688 11.7363 6.75967 11.8297 6.76642C11.9231 6.77318 12.0166 6.75365 12.0995 6.71003L13.2637 6.09783L14.4289 6.71003C14.5118 6.75365 14.6053 6.77318 14.6987 6.76642C14.7922 6.75967 14.8818 6.72688 14.9576 6.67179C15.0334 6.6167 15.0922 6.54149 15.1275 6.45469C15.1627 6.36789 15.1729 6.27295 15.157 6.18063L14.9347 4.88346L15.8766 3.96515C15.9437 3.89985 15.9912 3.81707 16.0138 3.72617C16.0363 3.63528 16.0329 3.53989 16.0041 3.4508ZM5.0692 3.10907L3.76752 2.91989L3.18542 1.74014C3.14401 1.65611 3.0799 1.58534 3.00035 1.53586C2.9208 1.48638 2.82899 1.46015 2.7353 1.46015C2.64162 1.46015 2.5498 1.48638 2.47025 1.53586C2.3907 1.58534 2.32659 1.65611 2.28518 1.74014L1.70308 2.91989L0.400395 3.10907C0.307711 3.12253 0.220644 3.16166 0.149043 3.22203C0.0774415 3.2824 0.024164 3.36161 -0.00476242 3.45068C-0.0336888 3.53976 -0.0371097 3.63515 -0.014638 3.72607C0.0078337 3.81699 0.0553011 3.89981 0.122394 3.96515L1.06479 4.88346L0.842487 6.18063C0.826742 6.27284 0.837088 6.36763 0.872358 6.45427C0.907627 6.54092 0.966415 6.61598 1.04209 6.67099C1.11776 6.72599 1.2073 6.75875 1.3006 6.76556C1.3939 6.77237 1.48725 6.75296 1.57011 6.70953L2.7353 6.09733L3.89949 6.70953C3.98238 6.75324 4.07585 6.77287 4.16932 6.7662C4.26278 6.75952 4.35252 6.72681 4.42835 6.67176C4.50418 6.61671 4.56309 6.54153 4.59839 6.45473C4.6337 6.36793 4.64399 6.27298 4.62811 6.18063L4.40581 4.88346L5.34821 3.96515C5.41516 3.89976 5.46249 3.81694 5.48485 3.72605C5.50721 3.63517 5.50371 3.53984 5.47474 3.45085C5.44577 3.36185 5.39249 3.28273 5.32092 3.22242C5.24934 3.16211 5.16233 3.12303 5.0697 3.10957L5.0692 3.10907ZM13.0178 7.50389H2.98169C2.58255 7.50429 2.19987 7.66303 1.91764 7.94526C1.6354 8.22749 1.47667 8.61017 1.47627 9.00931V13.0238C1.47667 13.4229 1.6354 13.8056 1.91764 14.0878C2.19987 14.3701 2.58255 14.5288 2.98169 14.5292H6.28659L7.64498 15.8876C7.73908 15.9816 7.86669 16.0345 7.99975 16.0345C8.13281 16.0345 8.26043 15.9816 8.35453 15.8876L9.71292 14.5292H13.0178C13.417 14.5288 13.7996 14.3701 14.0819 14.0878C14.3641 13.8056 14.5228 13.4229 14.5232 13.0238V9.00931C14.5228 8.61017 14.3641 8.22749 14.0819 7.94526C13.7996 7.66303 13.417 7.50429 13.0178 7.50389ZM12.0142 12.522H3.9853C3.85221 12.522 3.72458 12.4691 3.63047 12.375C3.53636 12.2809 3.48349 12.1532 3.48349 12.0202C3.48349 11.8871 3.53636 11.7594 3.63047 11.6653C3.72458 11.5712 3.85221 11.5183 3.9853 11.5183H12.0142C12.1473 11.5183 12.2749 11.5712 12.369 11.6653C12.4631 11.7594 12.516 11.8871 12.516 12.0202C12.516 12.1532 12.4631 12.2809 12.369 12.375C12.2749 12.4691 12.1473 12.522 12.0142 12.522ZM12.0142 10.5147H3.9853C3.85221 10.5147 3.72458 10.4619 3.63047 10.3678C3.53636 10.2736 3.48349 10.146 3.48349 10.0129C3.48349 9.87984 3.53636 9.7522 3.63047 9.65809C3.72458 9.56399 3.85221 9.51112 3.9853 9.51112H12.0142C12.1473 9.51112 12.2749 9.56399 12.369 9.65809C12.4631 9.7522 12.516 9.87984 12.516 10.0129C12.516 10.146 12.4631 10.2736 12.369 10.3678C12.2749 10.4619 12.1473 10.5147 12.0142 10.5147Z"
								fill="<?= $_primary ?>" />
						</svg>                            </svg>
                        </p>
                        <p class="text-gray-100 text-sm font-light md:font-medium md:text-base">Rating:
                            <strong><?php echo esc_html($trip_rating) ?></strong>
                        </p>
                    </li>
                </ul>
                <?php if (!empty($trip_discount)) ?>
                <strong class="max-w-[100px] font-semibold flex justify-center items-center rounded-[32px] bg-[#DFFE8E]">
                <?php echo esc_html($trip_discount) ?> %</strong>
              
                <div class=" grid grid-cols-12">
                
                    <div class="flex items-center gap-2 mt-4 text-white col-span-6  md:col-span-8 xl:col-span-6">
                        <span>Start from:</span>
                        <span class="text-[40px] md:text-[32px] xl:text-[32px] font-semibold"><?php echo esc_html($trip_price) ?>$</span>
                        <span>/ Person</span>
                    </div>
                    <a href = "<?php echo esc_html($btn_link) ?>" class=" text-center col-span-4 md:mb-4 sm:col-span-6  xl:col-span-4  mt-6 px-8 md:px-4 lg:px-8  py-3 bg-[#FBFEF3] text-[#05363D] font-semibold rounded-full hover:bg-[<?= $_yellow ?>] transition-colors">
                    <?php echo esc_html($btn_txt) ?>
                   </a>
                </div>
            </div>

            <!-- Bottom row of images -->
            <div class="grid grid-cols-12  gap-2 h-[250px]">
            <?php if (!empty($trip_thumbnail2)): ?>
                <img src="<?php echo esc_url($trip_thumbnail2); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover col-span-4">
            <?php endif; ?>

    
            <?php if (!empty($trip_thumbnail3)): ?>
                <img src="<?php echo esc_url($trip_thumbnail3); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover col-span-3">
            <?php endif; ?>


    
    <div class="relative modal-btn cursor-pointer col-span-5">
    <?php if (!empty($trip_thumbnail4)): ?>
                <img src="<?php echo esc_url($trip_thumbnail4); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover">
            <?php endif; ?>
  
            <?php if (count($trip_gallery_urls) > 4): ?>
        <div class="absolute bottom-2 right-2  bg-black/30  bg-white text-black text-sm font-medium px-3 py-1 rounded-full shadow-md">
            <span class="text-[#05363D] font-medium">See all <?php echo count($trip_gallery_urls ) ?> photos</span>
        </div>
        <?php endif; ?>
    </div>
</div>

        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="md:hidden">
  
    <h1 style="font-family: 'Berkshire Swash', cursive;"
                    class="text-[32px] md:text-[64px] font-semibold mt-0 ms-4 mb-4 text-[<?= $_yellow ?>]">
                    <?php echo esc_html($trip_title)?>
                </h1>
        <div class="grid grid-cols-2 gap-2 h-[320px]">
            <div class="col-span-1">
            <?php if (!empty($trip_thumbnail1)): ?>
                <img src="<?php echo esc_url($trip_thumbnail1); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover">
            <?php endif; ?>
     
            </div>
            <div class="grid col-span-1 gap-2 h-full">
           

                     <?php if (!empty($trip_thumbnail2)): ?>
                <img src="<?php echo esc_url($trip_thumbnail2); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-[155px] object-cover">
            <?php endif; ?>
                     
                <div class="relative modal-btn cursor-pointer h-[155px]">
                <?php if (count($trip_gallery_urls) > 3): ?>
                    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 h-[34px]   bg-white text-black text-sm font-medium px-2 min-w-[100px] py-1 rounded-full shadow-md flex items-center justify-center">
                        <span class="text-[#05363D] font-medium">+<?php echo count($trip_gallery_urls) ?> Photos</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($trip_thumbnail3)): ?>
                <img src="<?php echo esc_url($trip_thumbnail3); ?>" 
                     alt="<?php echo esc_attr($trip_title); ?>" 
                     class="w-full h-full object-cover">
            <?php endif; ?>


                </div>
            </div>
        </div>

        <div>
             
                <ul class=" mt-4 ms-4">
                    <li class="flex items-center justify-start gap-2  mb-3">
                        <p class="w-[32px] h-[32px] rounded-full bg-[#FDFDFDB2] flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_243_2335)">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_243_2335)">
								<path
									d="M8 13C10.7614 13 13 10.7614 13 8C13 5.23858 10.7614 3 8 3C5.23858 3 3 5.23858 3 8C3 10.7614 5.23858 13 8 13Z"
									fill="<?= $_primary ?>" />
								<path
									d="M14.6667 8.49992C14.5341 8.49992 14.4069 8.44724 14.3131 8.35347C14.2193 8.25971 14.1667 8.13253 14.1667 7.99992C14.1669 7.64732 14.1368 7.29536 14.0767 6.94792C14.0655 6.88318 14.0672 6.81687 14.0817 6.75279C14.0961 6.6887 14.1231 6.62809 14.161 6.57442C14.1988 6.52075 14.2469 6.47506 14.3025 6.43998C14.358 6.40489 14.4199 6.38108 14.4847 6.36992C14.6154 6.34738 14.7498 6.3777 14.8582 6.45421C14.9118 6.4921 14.9575 6.54019 14.9926 6.59573C15.0277 6.65127 15.0515 6.71318 15.0627 6.77792C15.1317 7.18159 15.1665 7.59038 15.1667 7.99992C15.1667 8.13253 15.114 8.25971 15.0202 8.35347C14.9265 8.44724 14.7993 8.49992 14.6667 8.49992ZM14.2133 6.08059C14.1125 6.08088 14.014 6.05065 13.9307 5.99389C13.8474 5.93714 13.7833 5.8565 13.7467 5.76259C13.597 5.37977 13.4098 5.01265 13.188 4.66659C13.1525 4.61135 13.1282 4.54965 13.1166 4.48503C13.1049 4.4204 13.1061 4.35412 13.1201 4.28995C13.134 4.22579 13.1605 4.165 13.1979 4.11106C13.2354 4.05712 13.2831 4.01109 13.3383 3.97559C13.3936 3.94009 13.4553 3.91581 13.5199 3.90416C13.5845 3.8925 13.6508 3.89368 13.715 3.90764C13.7791 3.9216 13.8399 3.94806 13.8939 3.98552C13.9478 4.02297 13.9938 4.07068 14.0293 4.12592C14.288 4.52784 14.5057 4.95464 14.6793 5.39992C14.7275 5.52343 14.7246 5.66099 14.6713 5.78238C14.6181 5.90377 14.5188 5.99904 14.3953 6.04726C14.3372 6.06934 14.2755 6.08064 14.2133 6.08059ZM12.2933 3.39992C12.1754 3.39995 12.0613 3.35814 11.9713 3.28192C11.657 3.01656 11.3169 2.7834 10.956 2.58592C10.8397 2.52227 10.7534 2.41501 10.7161 2.28773C10.6789 2.16046 10.6937 2.0236 10.7573 1.90725C10.821 1.79091 10.9282 1.70462 11.0555 1.66736C11.1828 1.63011 11.3197 1.64494 11.436 1.70859C11.8554 1.93803 12.2507 2.20894 12.616 2.51725C12.6946 2.58331 12.7509 2.67195 12.7773 2.77112C12.8037 2.87029 12.799 2.97519 12.7638 3.07159C12.7286 3.16799 12.6645 3.2512 12.5803 3.30994C12.4962 3.36868 12.396 3.4001 12.2933 3.39992ZM9.96933 2.12925C9.91914 2.12914 9.86926 2.1215 9.82133 2.10659C9.23135 1.92473 8.61738 1.83259 8 1.83325C7.86739 1.83325 7.74022 1.78058 7.64645 1.68681C7.55268 1.59304 7.5 1.46586 7.5 1.33325C7.5 1.20065 7.55268 1.07347 7.64645 0.979701C7.74022 0.885933 7.86739 0.833254 8 0.833254C8.71776 0.832698 9.43153 0.940123 10.1173 1.15192C10.2314 1.18749 10.329 1.26274 10.3924 1.36403C10.4557 1.46533 10.4808 1.58597 10.4629 1.70412C10.445 1.82226 10.3854 1.93009 10.2948 2.00808C10.2043 2.08607 10.0888 2.12905 9.96933 2.12925Z"
									fill="<?= $_primary ?>" />
								<path
									d="M8.00065 15.1666C6.09993 15.1666 4.27706 14.4115 2.93305 13.0675C1.58904 11.7235 0.833984 9.90064 0.833984 7.99992C0.833984 6.0992 1.58904 4.27633 2.93305 2.93232C4.27706 1.58831 6.09993 0.833252 8.00065 0.833252C8.13326 0.833252 8.26044 0.88593 8.3542 0.979699C8.44797 1.07347 8.50065 1.20064 8.50065 1.33325C8.50065 1.46586 8.44797 1.59304 8.3542 1.68681C8.26044 1.78057 8.13326 1.83325 8.00065 1.83325C6.781 1.83325 5.58874 2.19492 4.57463 2.87252C3.56053 3.55012 2.77013 4.51323 2.30339 5.64004C1.83665 6.76685 1.71453 8.00676 1.95247 9.20298C2.19042 10.3992 2.77774 11.498 3.64016 12.3604C4.50258 13.2228 5.60138 13.8102 6.79759 14.0481C7.99381 14.286 9.23372 14.1639 10.3605 13.6972C11.4873 13.2304 12.4504 12.44 13.128 11.4259C13.8056 10.4118 14.1673 9.21957 14.1673 7.99992C14.1673 7.86731 14.22 7.74013 14.3138 7.64637C14.4075 7.5526 14.5347 7.49992 14.6673 7.49992C14.7999 7.49992 14.9271 7.5526 15.0209 7.64637C15.1146 7.74013 15.1673 7.86731 15.1673 7.99992C15.1652 9.89999 14.4095 11.7216 13.0659 13.0652C11.7224 14.4087 9.90072 15.1645 8.00065 15.1666Z"
									fill="<?= $_primary ?>" />
								<path
									d="M10.668 10.4998C10.56 10.4998 10.4549 10.4647 10.3686 10.3998L7.70195 8.39984C7.63985 8.35326 7.58945 8.29287 7.55474 8.22344C7.52003 8.15402 7.50195 8.07746 7.50195 7.99984V4.6665C7.50195 4.5339 7.55463 4.40672 7.6484 4.31295C7.74217 4.21918 7.86934 4.1665 8.00195 4.1665C8.13456 4.1665 8.26174 4.21918 8.35551 4.31295C8.44927 4.40672 8.50195 4.5339 8.50195 4.6665V7.74984L10.9686 9.59984C11.0526 9.66284 11.1147 9.75068 11.1459 9.85091C11.1772 9.95115 11.1761 10.0587 11.1429 10.1583C11.1096 10.2579 11.0458 10.3444 10.9606 10.4058C10.8753 10.4671 10.773 10.5 10.668 10.4998Z"
									fill="white" />
							</g>
							<defs>
								<clipPath id="clip0_243_2335">
									<rect width="16" height="16" fill="white" />
								</clipPath>
							</defs>
						</svg>                                </g>
                            </svg>
                        </p>
                        <p class="text-[#05363D] text-md font-light md:font-medium md:text-base">Duration :<strong>
                        <?php echo esc_html($trip_duration) ?> Day</strong>
                        </p>
                    </li>
                    <li class="flex items-center justify-start gap-2 ">
                        <p class="w-[32px] h-[32px] rounded-full bg-[#FDFDFDB2] flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M9.67077 3.40012L10.6127 2.48181C10.6798 2.41644 10.7272 2.33358 10.7497 2.24262C10.7721 2.15167 10.7687 2.05624 10.7397 1.96715C10.7107 1.87806 10.6573 1.79887 10.5857 1.73853C10.514 1.67819 10.4269 1.63911 10.3342 1.62573L9.03197 1.43655L8.44987 0.256804C8.40363 0.178575 8.3378 0.113749 8.25887 0.0687163C8.17993 0.0236838 8.09063 0 7.99975 0C7.90888 0 7.81957 0.0236838 7.74064 0.0687163C7.66171 0.113749 7.59588 0.178575 7.54963 0.256804L6.96754 1.43655L5.66535 1.62573C5.57267 1.63919 5.4856 1.67832 5.414 1.73869C5.3424 1.79906 5.28912 1.87827 5.26019 1.96734C5.23127 2.05642 5.22784 2.15181 5.25032 2.24273C5.27279 2.33365 5.32025 2.41647 5.38735 2.48181L6.32924 3.40012L6.10694 4.69729C6.09119 4.7895 6.10154 4.88429 6.13681 4.97093C6.17208 5.05758 6.23087 5.13264 6.30654 5.18765C6.38221 5.24265 6.47175 5.27541 6.56505 5.28222C6.65835 5.28903 6.7517 5.26963 6.83456 5.22619L7.99975 4.61399L9.16444 5.22619C9.24732 5.26976 9.34073 5.28928 9.43411 5.28254C9.5275 5.27579 9.61713 5.24306 9.69288 5.18803C9.76863 5.13301 9.82748 5.05789 9.86277 4.97116C9.89806 4.88444 9.90838 4.78957 9.89257 4.69729L9.67077 3.40012ZM16.0041 3.4508C15.9751 3.36182 15.9218 3.28272 15.8503 3.22242C15.7787 3.16212 15.6917 3.12304 15.5991 3.10957L14.2969 2.91989L13.7143 1.74014C13.6682 1.66179 13.6024 1.59684 13.5234 1.55172C13.4445 1.50659 13.3551 1.48285 13.2642 1.48285C13.1733 1.48285 13.0839 1.50659 13.005 1.55172C12.926 1.59684 12.8602 1.66179 12.8141 1.74014L12.232 2.91989L10.9298 3.10907C10.8371 3.12253 10.7501 3.16166 10.6784 3.22203C10.6068 3.2824 10.5536 3.36161 10.5246 3.45068C10.4957 3.53976 10.4923 3.63515 10.5148 3.72607C10.5372 3.81699 10.5847 3.89981 10.6518 3.96515L11.5942 4.88346L11.3714 6.18063C11.3555 6.27295 11.3657 6.36789 11.4009 6.45469C11.4362 6.54149 11.495 6.6167 11.5708 6.67179C11.6466 6.72688 11.7363 6.75967 11.8297 6.76642C11.9231 6.77318 12.0166 6.75365 12.0995 6.71003L13.2637 6.09783L14.4289 6.71003C14.5118 6.75365 14.6053 6.77318 14.6987 6.76642C14.7922 6.75967 14.8818 6.72688 14.9576 6.67179C15.0334 6.6167 15.0922 6.54149 15.1275 6.45469C15.1627 6.36789 15.1729 6.27295 15.157 6.18063L14.9347 4.88346L15.8766 3.96515C15.9437 3.89985 15.9912 3.81707 16.0138 3.72617C16.0363 3.63528 16.0329 3.53989 16.0041 3.4508ZM5.0692 3.10907L3.76752 2.91989L3.18542 1.74014C3.14401 1.65611 3.0799 1.58534 3.00035 1.53586C2.9208 1.48638 2.82899 1.46015 2.7353 1.46015C2.64162 1.46015 2.5498 1.48638 2.47025 1.53586C2.3907 1.58534 2.32659 1.65611 2.28518 1.74014L1.70308 2.91989L0.400395 3.10907C0.307711 3.12253 0.220644 3.16166 0.149043 3.22203C0.0774415 3.2824 0.024164 3.36161 -0.00476242 3.45068C-0.0336888 3.53976 -0.0371097 3.63515 -0.014638 3.72607C0.0078337 3.81699 0.0553011 3.89981 0.122394 3.96515L1.06479 4.88346L0.842487 6.18063C0.826742 6.27284 0.837088 6.36763 0.872358 6.45427C0.907627 6.54092 0.966415 6.61598 1.04209 6.67099C1.11776 6.72599 1.2073 6.75875 1.3006 6.76556C1.3939 6.77237 1.48725 6.75296 1.57011 6.70953L2.7353 6.09733L3.89949 6.70953C3.98238 6.75324 4.07585 6.77287 4.16932 6.7662C4.26278 6.75952 4.35252 6.72681 4.42835 6.67176C4.50418 6.61671 4.56309 6.54153 4.59839 6.45473C4.6337 6.36793 4.64399 6.27298 4.62811 6.18063L4.40581 4.88346L5.34821 3.96515C5.41516 3.89976 5.46249 3.81694 5.48485 3.72605C5.50721 3.63517 5.50371 3.53984 5.47474 3.45085C5.44577 3.36185 5.39249 3.28273 5.32092 3.22242C5.24934 3.16211 5.16233 3.12303 5.0697 3.10957L5.0692 3.10907ZM13.0178 7.50389H2.98169C2.58255 7.50429 2.19987 7.66303 1.91764 7.94526C1.6354 8.22749 1.47667 8.61017 1.47627 9.00931V13.0238C1.47667 13.4229 1.6354 13.8056 1.91764 14.0878C2.19987 14.3701 2.58255 14.5288 2.98169 14.5292H6.28659L7.64498 15.8876C7.73908 15.9816 7.86669 16.0345 7.99975 16.0345C8.13281 16.0345 8.26043 15.9816 8.35453 15.8876L9.71292 14.5292H13.0178C13.417 14.5288 13.7996 14.3701 14.0819 14.0878C14.3641 13.8056 14.5228 13.4229 14.5232 13.0238V9.00931C14.5228 8.61017 14.3641 8.22749 14.0819 7.94526C13.7996 7.66303 13.417 7.50429 13.0178 7.50389ZM12.0142 12.522H3.9853C3.85221 12.522 3.72458 12.4691 3.63047 12.375C3.53636 12.2809 3.48349 12.1532 3.48349 12.0202C3.48349 11.8871 3.53636 11.7594 3.63047 11.6653C3.72458 11.5712 3.85221 11.5183 3.9853 11.5183H12.0142C12.1473 11.5183 12.2749 11.5712 12.369 11.6653C12.4631 11.7594 12.516 11.8871 12.516 12.0202C12.516 12.1532 12.4631 12.2809 12.369 12.375C12.2749 12.4691 12.1473 12.522 12.0142 12.522ZM12.0142 10.5147H3.9853C3.85221 10.5147 3.72458 10.4619 3.63047 10.3678C3.53636 10.2736 3.48349 10.146 3.48349 10.0129C3.48349 9.87984 3.53636 9.7522 3.63047 9.65809C3.72458 9.56399 3.85221 9.51112 3.9853 9.51112H12.0142C12.1473 9.51112 12.2749 9.56399 12.369 9.65809C12.4631 9.7522 12.516 9.87984 12.516 10.0129C12.516 10.146 12.4631 10.2736 12.369 10.3678C12.2749 10.4619 12.1473 10.5147 12.0142 10.5147Z"
								fill="<?= $_primary ?>" />
						</svg>                            </svg>
                        </p>
                        <p class="text-[#05363D] text-md font-light md:font-medium md:text-base">Rating :
                            <strong><?php echo esc_html($trip_rating) ?></strong>
                        </p>
                    </li>
                </ul>
                <div class="ms-4 ">
                <?php if (!empty($trip_discount)) ?>
                <strong class="max-w-[100px] font-semibold flex justify-center items-center rounded-[32px] bg-[#DFFE8E] mt-4">
                 
                <?php echo esc_html($trip_discount) ?> %
            </strong>
              
               
                    <div class="flex items-center gap-2 mt-4 text-[#05363D] ">
                        <span class="text-[18px] font-semibold">Start from:</span>
                        <span class="text-[40px] font-semibold"><?php echo esc_html($trip_price) ?>$</span>
                        <span class="text-[18px] font-semibold">/ Person</span>
                    </div>
                    <a href = "<?php echo esc_html($btn_link) ?>" class=" text-center mt-4 mb-8 px-8 py-3 bg-[#FBFEF3] text-[#05363D] font-semibold rounded-full hover:bg-[<?= $_yellow ?>] transition-colors">
                    <?php echo esc_html($btn_txt) ?>
                    </a>
                </div>
            </div>
    </div>
</section>

<!-- Modal -->
<div id="image-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[9999]">
    <div class="bg-white p-6 rounded-md w-11/12 sm:w-8/12 md:w-6/12">
        <button id="close-modal" class="mb-4 text-gray-500 hover:text-gray-700">
            <i class="fas fa-close fa-2x text-[<?= $_primary ?>]"></i>
        </button>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <?php foreach ($trip_gallery_urls as $img_url) : ?>
        <div class="relative">
            <div class="overlay"></div>
            <img src="<?php echo esc_url($img_url); ?>" alt="Image" class="w-full h-36 md:h-48 object-cover rounded-md">
        </div>
    <?php endforeach; ?>
</div>

    </div>
</div>
<?php endif ?>

<style>
.hero-section {
    background: linear-gradient(180deg, #276C76 0%, #BAD0B4 70%, #FFFFFF 100%);
}

.overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease;
}

.overlay:hover {
    background-color: rgba(0, 0, 0, 0);
}

.rounded-lg {
    transition: transform 0.3s ease;
}

.rounded-lg:hover {
    transform: scale(1.02);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("image-modal");
    const modalBtns = document.querySelectorAll(".modal-btn");
    const closeModal = document.getElementById("close-modal");

    modalBtns.forEach(modalBtn => {
        modalBtn.addEventListener("click", () => {
            modal.classList.remove("hidden");
        });
    });

    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
});
</script>