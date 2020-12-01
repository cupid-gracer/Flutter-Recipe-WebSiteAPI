/**Single sign on */
var config = {
    apiKey: apiKey,
    authDomain: authDomain,
    databaseURL: databaseURL,
    storageBucket:storageBucket,
};

firebase.initializeApp(config);

var auth = new firebase.auth();
var currentUser = firebase.auth().currentUser;
firebase.auth().onAuthStateChanged(function (user) {
    currentUser = user;
});

firebase.auth().getRedirectResult().then(function (result) {
    if (result.credential) {
        var user = result.user.providerData[0];
        socialLogin(user);
    }
}).catch(function (error) {
    $('.catch-message').addClass("error-message").text(error.message);
});

/**Facebook */
var facebookProvider = new firebase.auth.FacebookAuthProvider();
facebookProvider.setCustomParameters({ prompt: 'select_account' });

function facebookSignin(e) {
    var className = "";
    if($(e).hasClass('modal-google-login')){
        className="modal-google-login";
    }
    $("#email").val("");
    $("#password").val("");
    $('.catch-message').removeClass("error-message").empty();
    firebase.auth().signInWithPopup(facebookProvider)
        .then(function (result) {
            var user = result.user.providerData[0];
            socialLogin(user, className);
        }).catch(function (error) {
            if (error.code == "auth/account-exists-with-different-credential") {
                auth.currentUser.linkWithRedirect(facebookProvider);
            } else {
                $('.catch-message').addClass("error-message").text(error.message);
            }
        });
}

/**Google sign in  */
var googleProvider = new firebase.auth.GoogleAuthProvider();
googleProvider.setCustomParameters({ prompt: 'select_account' });


function googleSignin(e) {
    var className;
    if($(e).hasClass('modal-google-login')){
        className="modal-google-login";
    }
    $("#email").val("");
    $("#password").val("");
    $('.catch-message').removeClass("error-message").empty();
    firebase.auth().signInWithPopup(googleProvider)
        .then(function (result) {
            var user = result.user.providerData[0];
            socialLogin(user, className);
        }).catch(function (error) {
            if (error.code == "auth/account-exists-with-different-credential") {
                auth.currentUser.linkWithRedirect(googleProvider);
            } else {
                $('.catch-message').addClass("error-message").text(error.message);
            }
        });
}

function socialLogin(user, className = '') {
    $.ajax({
        type: 'post',
        url: base_url + "social-login",
        data: { email: user.email, firstname: user.displayName, phone: user.phoneNumber, profile_image: user.photoURL },
        beforeSend :function(){
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();
            var res = jQuery.parseJSON(data)
            if (res.status) {
                if (className && className == "modal-google-login") {
                    window.location.reload();
                } else {
                    window.location.href = base_url;
                }
            } else {
                $('.catch-message').addClass("error-message").text(res.message);
            }
        }
    });
}