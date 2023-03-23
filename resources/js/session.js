export const session ={
  push(status = true, message) {
    let rateSession = document.querySelector('.session-status');
    if (rateSession != undefined || rateSession != null) {
      rateSession.remove();
    }
    let div = document.createElement('div');
    div.setAttribute('class', 'rate-session session-status');
    status == true ? div.style.backgroundColor = 'rgb(187 247 208)' : div.style.backgroundColor = 'rgb(254 202 202)';
    div.innerHTML = message + `<button class='close black scale-50' onclick='this.parentNode.remove()'></button>`;
    document.querySelector('main').prepend(div);
  }
}