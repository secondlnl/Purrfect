function lclose() {
    console.log(document.getElementsByClassName("cookie"));

  document.getElementsByClassName("cookie")[0].setAttribute("style", "display: none !important;");
}
function clicked() {
  setCookie("cookieok", "ok", 30);
  console.log(document.getElementsByClassName("cookie"));
  document
    .getElementsByClassName("cookie")[0]
    .setAttribute("style", "display: none !important;");
}
function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  let user = getCookie("cookieok");
  if (user != "") {
    document
      .getElementsByClassName("cookie")[0]
      .setAttribute("style", "display: none !important;");
  } else {
    document
      .getElementsByClassName("cookie")[0]
      .setAttribute("style", "display: inital !important;");
  }
}
