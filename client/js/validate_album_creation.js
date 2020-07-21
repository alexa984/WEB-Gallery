document
  .getElementById("album-creation-form")
  .addEventListener("submit", (event) => {
    // don't submit the form
    event.preventDefault();

    let formValid = checkform();

    // Submit only if no errors were found
    if (formValid) {
      document.getElementById("album-creation-form").submit();
    }
  });

function checkform() {
  if (document.getElementsByName("start-date")[0].value == "") {
    alert("Choose start date");
    document.getElementsByName("start-date")[0].focus();
    return false;
  }
  if (document.getElementsByName("end-date")[0].value == "") {
    alert("Choose start date");
    document.getElementsByName("end-date")[0].focus();
    return false;
  }
  if (
    document.getElementsByName("end-date")[0].value <
    document.getElementsByName("start-date")[0].value
  ) {
    alert("Choose valid start and end date");
    document.getElementsByName("start-date")[0].focus();
    document.getElementsByName("end-date")[0].focus();
    return false;
  }
  if (document.getElementsByName("album-name")[0].value == "") {
    alert("Enter album name");
    document.getElementsByName("album-name")[0].focus();
    return false;
  }
  return true;
}
