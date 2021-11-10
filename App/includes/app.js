function showPassword(topic){
    let input;
    if (topic === 'login'){
        input = document.getElementById("login_input_password");
        eye = document.getElementById("login_input_show");
    }else if (topic === 'singup'){
        input = document.getElementById("singup_input_password");
        eye = document.getElementById("singup_input_show");
    }else if (topic === 'old'){
        input = document.getElementById("old_input_password");
        eye = document.getElementById("old_password_show");
    }else if (topic === 'new'){
        input = document.getElementById("new_input_password");
        eye = document.getElementById("new_password_show");
    }else if (topic === 're'){
        input = document.getElementById("re_input_password");
        eye = document.getElementById("re_password_show");
    }else{
        input = document.getElementById("giftcards_codes");
        eye = document.getElementById("giftcards_codes_show");
    }
    if (input.type === "password"){
        input.type = "text";
        eye.innerHTML = '<i class="far fa-eye-slash"></i>';
    }else{
        input.type = "password";
        eye.innerHTML = '<i class="far fa-eye"></i>'
    }
}
function logout(){
    if (confirm("If you log out, you have to log in again for come back. Are you sure to want to log out?")){
        window.location.href = "db_control.php?topic=logout";
    }else {
        pass;
    }
}
function star(num){
    document.getElementById("total-star").value = num;
    for (var i = 1; i <= num; i++){
        star_number = document.getElementById('star-' + String(i));
        star_number.innerHTML = '<i class="fas fa-star"></i>'
        star_number.style.color = 'gold';
    }
    for (var i = num + 1; i <= 5; i++){
        star_number = document.getElementById('star-' + String(i))
        star_number.innerHTML = '<i class="far fa-star"></i>';
        star_number.style.color = 'black';
    }
}
function menuListControl(topic){
    if (topic === 'wishlist'){
        task = document.getElementById("menu-list-form");
        task.setAttribute("action", "db_control.php?topic=add_to_wishlist");
        task.submit();
    }
    else if (topic === 'cart'){
        task = document.getElementById("menu-list-form");
        task.setAttribute("action", "db_control.php?topic=add_to_cart");
        task.submit();
    }
    else{
        document.getElementById('details-1').innerHTML = "";
    }
}
function add_bookmarks(){
    let request = new XMLHttpRequest();
    request.open("GET", "db_control.php?topic=add_bookmarks", true);
    request.onload = function(){
        if (this.status >= 200 && this.status < 400){       
            let data = this.response;       
            if(data === 'Success'){         
                document.getElementById('bookmarks-btn').outerHTML  = `
                <button id="bookmarks-btn" class="btn button-text-hover btn-danger btn-lg" onclick="remove_bookmarks()">
                    <i class="fad fa-book-open"></i> Remove Bookmarks
                </button>`;
            }else{
                alert("error in data");
            }
        }else{
            alert("error in status");
        }
    }
    request.onerror = function(error){
        alert("enter into onerror");
    };
    request.send();
}
function remove_bookmarks(){
    let request = new XMLHttpRequest();
    request.open("GET", "db_control.php?topic=delete_bookmarks", true);
    request.onload = function(){
        if (this.status >= 200 && this.status < 400){       
            let data = this.response;       
            if(data === 'Success'){         
                document.getElementById('bookmarks-btn').outerHTML  = `
                <button id="bookmarks-btn" class="btn button-text-hover btn-success btn-lg" onclick="add_bookmarks()">
                    <i class="fad fa-bookmark"></i> Bookmark
                </button>`;
            }else{
                alert("error in data");
            }
        }else{
            alert("error in status");
        }
    }
    request.onerror = function(error){
        alert("enter into onerror");
};
    request.send();
}
function passwordChangeValidation(){
    let original = document.querySelectorAll("input[type=hidden]");
    let given = document.querySelectorAll("input[name=old_password]");
    if(given[0].value === original[0].value){
        let new_password = document.querySelectorAll("input[name=new_password]");
        let re_password = document.querySelectorAll("input[name=re_password]");
        if (re_password[0].value === new_password[0].value){
            document.getElementById("change-password-form").submit();
        }else{
            alert("Two input passsword are not matched!");
        }
    }else{
        alert("Incorrect older password!");
    }
}