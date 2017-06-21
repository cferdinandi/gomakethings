/**
 * Get the value of a cookie
 * https://gist.github.com/wpsmith/6cf23551dd140fb72ae7
 */
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}