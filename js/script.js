// JavaScript function to toggle password visibility
function togglePasswordVisibility() {
    var passwordInput = document.getElementById('pwd');
    var passwordToggle = document.getElementById('password-toggle');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Hide icon
    } else {
      passwordInput.type = 'password';
      passwordToggle.innerHTML = '<i class="fas fa-eye"></i>'; // Show icon
    }
  }
  
  
  