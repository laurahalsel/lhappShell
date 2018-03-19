
//Globals
// whoever is logged in
var currentUser = null;

// look at header.html, class of login/logoff
$(document).ready(function() {
    toggleLoginLogoffItems(false);
});

$("#signup").on("click", function() {
    $("#signupNavItem").click();
});


function toggleLoginLogoffItems(loggedin) {
    if(loggedin == true){
        $('.loggedOn').show();
        $('.loggedOff').hide();
    } else {// login = false 
        $('.loggedOn').hide();
        $('.loggedOff').show();
    }
}

$('#logoutNavItem').on("click", function() {
    currentUser = null;
    toggleLoginLogoffItems(false);
    $("#homeNavItem").click();
});


$('#signUpButton').on('click', function() {
    if($('#signUpPassword').val() != $('#signUpConfirmPassword').val()) {
        alert("passwords must match");
         // evt.preventDefault();
        return ;
    }

    $.ajax({
        url: 'signup.php',
        type: 'POST',
        data:	{
                    username:   $("#signUpUsername").val(), 
                    name:       $("#signUpName").val(),
                    email:      $("#signUpEmail").val(),
                    password:   $("#signUpPassword").val()
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user; // set the currentUser to the global variable
                            $("#signUpUsername").val(""); 
                            $("#signUpName").val("");
                            $("#signUpEmail").val("");
                            $("#signUpPassword").val("");
                            $("#signUpConfirmPassword").val("");
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                            $("#displayName").text("Hello, " + currentUser[0].username);
                            $("#displayName").text("Hello, " + currentUser[0].email);
                            $("#homeNavItem").click();
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});

$('#loginButton').on('click', function() {

    $.ajax({
        url: 'login.php',
        type: 'POST',
        data:	{
                    username:   $("#loginUsername").val(), 
                    password:   $("#loginPassword").val(),
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user[0]; // set the currentUser to the global variable
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                            $("#loginPassword").val("");
                            $("#loginUsername").val(""); 
                            $("#displayName").text("Hello, " + currentUser.username);
                            $("#manageUsername").val(currentUser.username);
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});

$('#updateButton').on('click', function() {

    $.ajax({
        url: 'manageAccount.php',
        type: 'POST',
        data:	{
                    id:  $("#manageID").val(),
                    username:  $("#manageUsername").val(),  
                    name:   $("#manageName").val(),  
                    email:   $("#manageEmail").val()
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user[0]; // set the currentUser to the global variable
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                            $("#displayName").text("Hello, " + currentUser.username);
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});

$("#manageAccountNavItem").on("click", function() {
    $("#manageID").val(currentUser.id);
    $("#manageUsername").val(currentUser.username);
    $("#manageName").val(currentUser.name);
    $("#manageEmail").val(currentUser.email);
}); 

$("#changePasswordModal").on("click", function() {
    $("#usernameInput").val(currentUser.username);
    $("#oldPassword").val("");
    $("#newPassword").val("");
    $("#confirmNewPassword").val("");
}); 

$('#saveChangesButton').on('click', function() {
    if($('#newPassword').val() != $('#confirmNewPassword').val()) {
        alert("Passwords must match!");
         // evt.preventDefault();
        return ;
    }

    $.ajax({
        url: 'changePassword.php',
        type: 'POST',
        data:	{
                    username: $("#usernameInput").val(),
                    id: $("#changePasswordID").val(),
                    oldPassword: $("#oldPassword").val(),
                    password: $("#newPassword").val()
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user[0]; // set the currentUser to the global variable
                            toggleLoginLogoffItems(true);
                            $("#oldPassword").val("");
                            $("#newPassword").val("");
                            $("#confirmNewPassword").val("");
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});
    
function generateRandomToken(n) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    var dayte = new dayte();
    var dayInMillseconds = dayte.getTime();

    for(var i=0; i < n; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));

        return dayInMillseconds + text;
    }
}

function setCookie(cookieName, cookievalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));

	var expires = "expires=" + d.toGMTString();
	document.cookie = cookieName+ "=" + cookievalue+ "; " + expires;
}

function getCookie(cookieName) {
	
	if(document.cookie) {
		var cookiesArray = document.cookie.split("; ");
		for(var i = 0; i < cookiesArray.length; i++) {
			if(cookiesArray[i].split("=")[0] == cookieName) {
				 return unescape(cookiesArray[i].split("=")[1]);
			}
		}	
	
	}
}