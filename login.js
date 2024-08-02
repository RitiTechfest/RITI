$('#form').submit(function(event) {
    event.preventDefault();
    
    var username = $('#username').val();
    var password = $('#password').val();
  
    // Check credentials
    if (username === "admin" && password === "riti9") {
      // Redirect to main page
      window.location.href = "adminpage.html";
    } else {
      alert("Invalid username or password");
    }
  });
  