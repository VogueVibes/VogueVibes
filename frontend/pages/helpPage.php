<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
?>
<style>
    /* We do */
.wedo {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}
.my-navbar{
    top:0px
}
.wedo_item {
    width: 50%;
}

.wedo_img {
    display: block;
    margin-top: -100px;
    max-width: 100%;
    height: auto; 
}
.section_text, .section_title, .section_suptitle, .accordion_title, .accordion_content {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); /* Adds shadow to text for better readability */
}
/* Container */
.container {
    width: 100%;
    max-width: 1230px;
    margin: 0 auto;
    padding: 0 15px;
}
body, html {
    position: relative;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-image: url("../img/workpieces/background.jpeg");
    background-repeat: no-repeat;
    background-size: cover;  // Changed from contain to cover
    overflow-x: hidden;
    /* overflow: hidden;  */
    
}


    /* Existing styles... */

    .containerone, .containertwo, .containerthree {
        position: absolute;
        z-index: -1; /* Set negative z-index to move it to the background */
        /* other styles remain unchanged */
    }

    /* More styles... */

    .container, .wedo, .section {
        position: relative;
        z-index: 1; /* Ensure these are higher than the background images */
    }
/* Section */
.section {
    padding: 80px 0;
}

.section_header {
    width: 100%;
    max-width: 950px;
    margin: 0 auto 50px;
    
    text-align: center;
}

.section_suptitle {
    font-size: 24px;
    /* color: #333; */
    color: black;
    font-family: 'Kaushan Script', cursive;
}

.section_title {
    
    font-size: 25px;
    color: black;
    font-weight: 700;
    text-transform: uppercase;
}

.section_title:after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: #f38181;
    margin: 30px auto;
}

.section_text {
    color: black;
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    font-style: regular;
}

/* Accordion */
.accordion_item {
    border: 1px solid black;
    margin-bottom: 10px;
}
/* Text enhancements for better visibility */
.section_text, .section_title, .section_suptitle, .accordion_title, .accordion_content {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); /* Adds shadow to text for better readability */
}

.section_header, .accordion_item {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 10px; /* Adds padding around text */
    margin-bottom: 10px; /* Adds space between sections */
}

.section_text, .accordion_content {
    font-size: 16px; /* Slightly larger font size for readability */
    font-weight: bold; /* Bold font for better visibility */
}

.accordion_title {
    color: black; /* Ensures text is visible against darker backgrounds */
}
.accordion_item.active
.accordion_content {
    display: block;
}

.accordion_item.active
.accordion_header {
    border-bottom-color: black;
}

.accordion_item.active
.accordion_header:after {
    transform: rotate(-45deg);
}

.accordion_header {
    padding: 15px 20px 15px 65px;
    border-bottom: 1px solid transparent;
    
    position: relative;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
}

.accordion_header:after {
    content: "";
    display: block;
    width: 16px;
    height: 16px;
    
    border-top: 2px solid #999;
    border-right: 2px solid #999;
    
    position: absolute;
    top: 50%;
    right: 20px;
    z-index: 1;
    
    transform: translateY(-50%) rotate(135deg);
}

.accordion_content {
    padding: 15px 20px;
    color: black;
    font-size: 15px;
    font-family: 'Roboto', sans-serif;
    font-style: italic;
    font-weight: 300;
    
    display: none;
}

.accordion_title {
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 550;
}

.accordion_icon {
    position: absolute;
    top: 50%;
    left: 20px;
    z-index: 1;
    
    transform: translateY(-50%); /* Выровнять по оси Y */
}

/* .containerOne {
    position: absolute;
    top: 10%;  
    left: 10%;
    background-image: url("../img/workpieces/LOGOL.png");
    background-repeat: no-repeat;
    background-size: contain;
    width: 20%;  
    height: 0;
    padding-top: 20%; 
} */

/* .containerTwo {
    position: absolute;
    top: 40%;  
    left: 60%;
    background-image: url("../img/workpieces/LOGOM.png");
    background-repeat: no-repeat;
    background-size: contain;
    width: 20%;  
    height: 0;
    padding-top: 20%; 
} */
/* .footer {
    background: rgb(221, 221, 221);
} */
</style>
<body>
    
<section class="section">
        <div class="container">
        <div class="containerOne"></div>
    <div class="containerTwo"></div>
            <div class="section_header">
                <h3 class="section_suptitle">Vogue Vibes</h3>
                <h2 class="section_title">FAQs</h2>
                <div class="section_text">
                    <p>Welcome to our support page, a dedicated space for those who need immediate assistance. We understand that urgent questions require timely answers, and we are here to help. Whether you have a quick inquiry or a complex issue, our team is prepared to provide the guidance and support you need. Let us help you resolve your concerns swiftly and effectively.</p>
                </div>
            </div>   <!----- .section_header -----> 

            <div class="wedo">

                <div class="wedo_item">
                    <img class="wedo_img" src="../img/workpieces/question.png" alt="" width="800">
                </div>

                <div class="wedo_item">

                    <div class="accordion">

                        <div class="accordion_item">
                            <div class="accordion_header">
                                <img class="accordion_icon" src="images/photography.png" alt="">
                                <div class="accordion_title">How do I initiate a return or exchange</div>
                            </div>
                            <div class="accordion_content">
                            <h3>Additional Information:</h3>
    <ul>
        <li><strong>Shipping Costs:</strong> Return shipping is free for exchanges and for returns within certain conditions (e.g., faulty products, wrong items sent). For other returns, the cost of the return shipping will be deducted from your refund.</li>
        <li><strong>Processing Time:</strong> Please allow up to 2 weeks from the return shipment date for your return to be processed and 1-2 billing cycles for the refund to appear on your credit statement.</li>
        <li><strong>International Returns:</strong> For customers outside the domestic shipping area, please contact customer service for specific instructions.</li>
    </ul>
                        </div>
                        </div>
                        <div class="accordion_item active">
                            <div class="accordion_header">
                                <img class="accordion_icon" src="images/webdesign.png" alt="">
                                <div class="accordion_title">What are your brand’s commitments to ethical fashion?</div>
                            </div>
                            <div class="accordion_content">
                            <h3>Sustainable Materials</h3>
    <p>We prioritize the use of eco-friendly materials such as organic cotton, recycled polyester, and sustainably sourced wool to minimize our environmental impact.</p>

    <h3>Fair Labor Practices</h3>
    <p>We partner only with manufacturers who share our commitment to fair labor practices. This includes ensuring fair wages, safe working conditions, and reasonable working hours for all employees in our supply chain.</p>

    <h3>Reducing Carbon Footprint</h3>
    <p>We are actively working to reduce our carbon footprint through various initiatives, including optimizing our supply chain logistics, reducing packaging waste, and implementing energy-efficient practices in our production processes.</p></div>
                        </div>
                        <div class="accordion_item">
                            <div class="accordion_header">
                                <img class="accordion_icon" src="images/creativity.png" alt="">
                                <div class="accordion_title">How to Change My Password</div>
                            </div>
                            <div class="accordion_content">
                            <h2>How to Change Your Password</h2>
    <p>Changing your password regularly is a good practice to keep your account secure. Follow these steps to update your password:</p>
    
    <ol>
        <li><strong>Log In to Your Account</strong>: Access our website and sign in with your current username and password.</li>
        <li><strong>Access Account Settings</strong>: Navigate to the 'Account Settings' or 'My Account' section. You can usually find this in the upper right corner of the homepage or under a menu that may be labeled with your name or an avatar.</li>
        <li><strong>Select 'Change Password'</strong>: Look for a link or button labeled 'Change Password', 'Password', or similar, and click on it to begin the process.</li>
        <li><strong>Verify Your Identity</strong>: For your security, you may need to verify your identity. This could be by re-entering your current password or answering security questions.</li>
        <li><strong>Enter Your New Password</strong>: Type in your new password. Ensure it is strong and difficult to guess, using a combination of letters, numbers, and symbols.</li>
        <li><strong>Confirm Your New Password</strong>: Re-type your new password in the confirmation field to avoid any mistakes.</li>
        <li><strong>Save Changes</strong>: Click the 'Save', 'Update', or 'Confirm' button to apply your new password. A confirmation message should appear or an email may be sent to you confirming the change.</li>
        <li><strong>Log Out and Test Your New Password</strong>: Log out of your account and log back in with your new password to ensure it works correctly.</li>
        <li><strong>Update Your Password Elsewhere</strong>: If you have used similar passwords on other accounts, consider updating them for security reasons.</li>
    </ol>
    
    <p><strong>Tips for a Strong Password:</strong></p>
    <ul>
        <li><strong>Length:</strong> Your password should be at least 12 characters long.</li>
        <li><strong>Complexity:</strong> Include uppercase letters, lowercase letters, numbers, and symbols.</li>
        <li><strong>Uniqueness:</strong> Use a different password for each of your accounts.</li>
        <li><strong>Password Managers:</strong> Consider using a password manager to help manage and secure your passwords.</li>
    </ul>
</div>
                        </div>

                       

                    </div>  <!----- .accordion ----->

                </div>  <!----- .wedo_item -----> 

            </div>   <!----- .wedo -----> 

        </div>
    </section>  <!----- .wedo ----->
    <?php 
    // include "footer.php";
    ?>
         <script src="/vogueVibes/JS/script.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const acc = document.getElementsByClassName('accordion_item');
    for (let i = 0; i < acc.length; i++) {
        acc[i].addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
});

    </script>
</body>
