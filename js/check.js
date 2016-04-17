window.onload = function(){
    var form = document.getElementById("form");
    
    var usernameObj = document.getElementById("username");
    var passwordObj = document.getElementById("password");
    var confirmObj = document.getElementById("confirm");
    var nameObj = document.getElementById("name");
    var brirthdayObj = document.getElementById("brirthday");
    var genderObj = document.getElementById("gender");
    var usernameRegex = /^[a-zA-Z_]\w{0,9}$/;       			
    var passwordRegex = /^\w{6,16}$/;               			
    var emailRegex = /^[\w-]+@([\w-]+\.)+[a-zA-Z]{2,3}$/;      	// Email
    
    function usernameCheck(){
    	var username = trim(usernameObj.value);
    	var usernameMsg = document.getElementById("usernameMsg");
    	var msg = "";
    	if(!username)
            msg = "Please fill out the username "
        else if(!usernameRegex.test(username))
            msg = "Wrong format";
        usernameMsg.innerHTML = msg;		
        usernameMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";	
        return !msg;
    }
    
    function passwordCheck(){
    	var password = passwordObj.value;
    	var passwordMsg = document.getElementById("passwordMsg");
    	var msg = "";
    	if(!password)
            msg = "Please set a password"
        else if(!passwordRegex.test(password))
            msg = "Wrong format, must be more than 8 digits";
        passwordMsg.innerHTML = msg;		
        passwordMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";	
        return !msg;
    }
    
    function confirmCheck(){
    	var confirm = confirmObj.value;
    	var password = passwordObj.value;
    	var confirmMsg = document.getElementById("confirmMsg");
    	var msg = "";
    	if(confirm != password)
            msg = "Should be the same as your password"
        confirmMsg.innerHTML = msg;		
        confirmMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";	
        return !msg;
    }
    
     function nameCheck(){
        var name = trim(nameObj.value);
        var nameMsg = document.getElementById("nameMsg");
        var msg = "";
        if(!name)
            msg = "Please fill out the name "
        nameMsg.innerHTML = msg;        
        nameMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";    
        return !msg;
    }

     function brirthdayCheck(){
        var brirthday = brirthdayObj.value;
        var brirthdayMsg = document.getElementById("brirthdayMsg");
        var msg = "";
        if(!brirthday)
            msg = "Please choose your brirthday"
        brirthdayMsg.innerHTML = msg;      
        brirthdayMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";  
        return !msg;
    }
   
    function genderCheck(){
    	var gender = genderObj.value;
    	var genderMsg = document.getElementById("genderMsg");
    	var msg = "";
    	if(!gender)
            msg = "Please choose your gender"
        genderMsg.innerHTML = msg;		
        genderMsg.parentNode.parentNode.style.color = msg == "" ? "black" : "red";	
        return !msg;
    }

    
    usernameObj.onblur = usernameCheck;
    passwordObj.onblur = passwordCheck;
    confirmObj.onblur = confirmCheck;
    nameObj.onblur = nameCheck;
    brirthdayObj.onchange = brirthdayCheck;
    genderObj.onchange = genderCheck;
    

    
    form.onsubmit = function(){
    	var bUsername = usernameCheck();
    	var bPassword = passwordCheck();
    	var bConfirm = confirmCheck();
        var bName = nameCheck();
        var bbrirthday = brirthdayCheck();
    	var bgender = genderCheck();
    	
    	return bUsername && bPassword && bConfirm && bName && bbrirthday && bgender ;
    }
}

function trim(s){
    return s.replace(/^\s+|\s+$/g, "");
}