$('#login-button').click(function () {
    var login = $("#inputLogin").val();
    var password = $("#inputPassword").val();
    $.post('login.php', {
        action: 'login',
        login: login,
        password: password
    })
        .then(function (value) {
            var loginSuccessful = JSON.parse(value).login;
            if (loginSuccessful) {
                alert("Login successful");
                window.location.href = 'shop.html';
            }
            else {
                alert("Wrong login or password");
            }
        })
        .catch(function (reason) {
            console.log("Error: " + reason);
        })
});
