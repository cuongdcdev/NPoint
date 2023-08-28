<?php
/*
 * Template Name: User Registration
 * Description: Custom template for user registration.
 */

add_shortcode("npoint-user-register-form", function () {

    // Display the registration form
    get_header();
    ob_start();

?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <div class="">
                <div class="row justify-content-center">
                    <div class="">
                        <div class="registration-form">
                            <h2 class="" id="form-header-title">Login</h2>

                            <form id="registration-form" class="form-outline" onsubmit="return false">
                                <div class="mb-3 form-outline">
                                    <label for="username" class="form-label">Phone number or Username</label>
                                    <input type="text" required name="username" id="username" maxlength=40 class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required name="password" id="password" class="form-control">
                                </div>

                                <div class="mb-3" id="wrap-web3-wallet" style="display: none;">
                                    <label for="wallet" class="form-label">Your Web3 wallet</label>
                                    <input type="wallet" name="wallet" readonly disabled="50" id="webwallet" class="form-control" value="<?php echo isset($_POST['wallet']) ? $_POST['wallet'] : ''; ?>">
                                </div>

                                <div class="mb-3">
                                    <button id="btn-login-register" type="submit" class="btn btn-outline-primary btn-rounded px-5">Login</button>
                                    <!-- <br/>  <a  href="#" class="" >Click here for register!</a> -->
                                    <p class="mt-3"><a id="toggleLoginRegister" class="">Dont have an account? Click here for register!</a></p>
                                </div>
                            </form>

                            <h5 class=""> Or Login with NEAR </h5>
                            <?php echo do_shortcode("[nsub_login]"); ?>
                        </div>
                    </div>
                </div>


            </div>

        </main>
    </div>

    <script>
        (($) => {
            $(document).ready(function() {
                console.log("dom ready!");
                window.npointCurrentMode = "login";

                $("#username").on("change", function() {
                    var u = $(this).val().replace(/[^a-z0-9]/gi, '');
                    $("#webwallet").val(u + ".testnet");
                });

                async function npointRegisterNewAccount() {
                    if (!nsubObject.isSignedIn) {
                        console.log("Register account ~~~~");
                        var uwallet = $("#webwallet").val();
                        // var accountExsit = await window.nSubContract.getAccountBalance( uwallet );

                        while (uwallet && await window.nSubContract.getAccountBalance(uwallet)) {
                            uwallet = uwallet.substr(0, uwallet.length - ".testnet".length) + Math.ceil((Math.random() * (999 - 100) + 100)) + ".testnet";
                            console.log("wallet exist, generated a new one: " + uwallet);
                        }
                        $("#webwallet").val(uwallet);

                        if (uwallet) {
                            $.ajax({
                                method: "POST",
                                url: nsubObject.ajaxUrl,
                                data: {
                                    action: "nsub_register_new_account",
                                    nonce: nsubObject.nonce,
                                    wallet: uwallet,
                                    username: $("#username").val(),
                                    password: $("#password").val(),
                                    nonce: nsubObject.nonce
                                },
                                success: function(data) {
                                    if (data.status == "success") {
                                        //auto login user 
                                        // npointLoginUser(); (already created & logged in )
                                        window.location.href = window.location.href;
                                    } else {
                                        alert("Error:" + data.message);
                                    }
                                    console.log("response data", data);
                                    toggleLoadingBtn();

                                },
                                error: function(err) {
                                    console.log("register errr", err.getMessage());
                                }
                            });
                        }
                    }
                } //npointRegisterNewAccount

                //npoint login user 
                async function npointLoginUser() {
                    $.ajax({
                        method: "POST",
                        url: nsubObject.ajaxUrl,
                        data: {
                            action: "nsub_login_with_password",
                            username: $("#username").val(),
                            password: $("#password").val(),
                            nonce: nsubObject.nonce
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                var rurl = window.location.href;
                                if (window.location.href.indexOf("wp-login") > 0 || window.location.href.indexOf("wp-admin") > 0) {
                                    rurl = window.location.origin;
                                }
                                window.location.replace(rurl);
                            }else{
                                alert("Error: " + data.message);
                            }
                            toggleLoadingBtn();
                        }
                    });
                }
                //end npoint login user 


                $("#btn-login-register").on("click", function() {
                    toggleLoadingBtn();
                    if (window.npointCurrentMode == "register") {
                        if ($("#username").val() && $("#password").val() && $("#webwallet").val()) {
                            npointRegisterNewAccount();
                        } else {
                            alert("please fill all your username and password! ");
                            toggleLoadingBtn();
                        }
                    } else {
                        if ($("#username").val() && $("#password").val()) {
                            npointLoginUser();
                        } else {
                            alert("please fill all your username and password! ");
                            toggleLoadingBtn();
                        }
                    }

                });

                $("#toggleLoginRegister").on("click", function() {
                    if (window.npointCurrentMode == "register") {
                        window.npointCurrentMode = "login";
                        $("#form-header-title").text("Login");
                        $("#btn-login-register").text("Login");
                        $(this).text("Dont have an account? Click here to register new one!");
                        $("#wrap-web3-wallet").hide();

                    } else {
                        window.npointCurrentMode = "register";
                        $("#form-header-title").text("Register");
                        $("#btn-login-register").text("Register");
                        $("#wrap-web3-wallet").show();
                        $(this).text("Already has an account? Click here to login");

                    }
                })

                function toggleLoadingBtn(){
                    
                    if ( $("#btn-login-register").find( "#spinner-loading" ).length > 0 ){
                        $("#btn-login-register").find( "#spinner-loading" ).remove();
                        $("#btn-login-register").prop("disabled" , false);
                    }else{
                        $("#btn-login-register").append( '<span id="spinner-loading" class="pl-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' );
                        $("#btn-login-register").prop("disabled" , true);
                    }
                    
                }


            }); //dom ready



        })(jQuery);
    </script>

    <style>
#main{
    margin-top:0px !important;
}

    </style>
<?php
    get_footer();
    return ob_get_clean();
});
