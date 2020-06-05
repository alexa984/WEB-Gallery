var validateConfirmPassword = function () {
  const pwdField = document.querySelector('#register input[name="password"]');
  const pwdConfirm = document.querySelector(
    '#register input[name="password-cnf"]'
  );

  if (pwdField.value !== pwdConfirm.value) {
    console.log(pwdField.value, pwdConfirm.value);
    pwdField.style.border = "1px solid red";
    pwdConfirm.style.border = "1px solid red";
    document.getElementById("message").style.color = "red";
    document.getElementById("message").innerHTML = "Passwords not matching";
  } else {
    pwdField.style.border = "1px solid #333";
    pwdConfirm.style.border = "1px solid #333";
    document.getElementById("message").innerHTML = "";
  }
};
