console.log("nsub_ajax ready,loading~");
// console.log(nSubContract);

window.initNSub = async function () {
    window.$ = jQuery;
    window.walletConn = nSubContract.wallet;
    const urlParams = new URLSearchParams(window.location.search);
    const txhash = urlParams.get("transactionHashes");

    console.log("[initNSub] wallet conn", walletConn);

    //HANDLE LOGIN LOGOUT 
    // if (!window.isSignedIn && walletConn.walletSelector.isSignedIn()) {
    if( !window.wpUserSignedIn && walletConn.walletSelector.isSignedIn() ){
        loginWithNear();
    }

    function loginWithNear() {
        console.log("Loginingggg with NEAR~~~~");
        $.ajax({
            method: "POST",
            url: nsubObject.ajaxUrl,
            data: {
                action: "login_with_near",
                nonce: nsubObject.nonce,
                wallet: walletConn.accountId
            },
            success: function (data) {
                var rurl = window.location.href;
                if (window.location.href.indexOf("wp-login") > 0 || window.location.href.indexOf("wp-admin") > 0) {
                    rurl = window.location.origin;
                }
                window.location.href = rurl;
                console.log("login with NEAR success!", data);
            },
            error: function (err) {
                console.log("errr");
            }
        });
    }//login with NEAR 

    $(".nsub-logout-btn").on("click", function (e) {
        e.preventDefault();
        logoutWithNear();
    });

    function logoutWithNear() {

        var walletConn = nSubContract.wallet;
        // if (!window.isSignedIn || !confirm("Confirm logout?") ) return;
        if ( !confirm("Confirm logout?") ) return;
        $.ajax({
            method: "POST",
            url: nsubObject.ajaxUrl,
            data: {
                action: "logout_with_near",
                nonce: nsubObject.nonce,
            },
            success: function (data) {
                if (data.status == "success") {
                    if (walletConn.walletSelector.isSignedIn()) {
                        walletConn.signOut();
                    }

                    window.location.replace(window.location.origin + window.location.pathname);
                } else {
                    console.log("Errr logout", data);
                }
            }
        });

    }//logout with NEAR 

    $(".nsub-login-btn").on("click", (e) => {
        e.preventDefault();
        walletConn.signIn();
    });

    if (window.isSignedIn) {
        signedInFlow();
    } else {
        signedOutFlow();
    }

    $("#wp-admin-bar-logout").on("click", function (e) {
        e.preventDefault();
        // var logouturl = $(this).find("a").attr("href");
        logoutWithNear();
    });

    // Display the signed-out-flow container
    function signedOutFlow() {
        $('#signed-in-flow').hide();
        $('#signed-out-flow').show();
    }

    // Displaying the signed in flow container and fill in account-specific data
    function signedInFlow() {
        $('#signed-out-flow').hide();
        $('#signed-in-flow').show();
    }
    //END HANDLE LOGIN LOGOUT 



}// init Nsub
