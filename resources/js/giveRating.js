const GiveRating = {
  valuesRating: document.querySelectorAll('.container-rating_form'),
  select(el, rateValue, post_uuid) {

    this.valuesRating.forEach(el => el.classList.remove('selected-rate'));
    el.classList.add('selected-rate');
    Alpine.store('delay').delay(500, () => {
      fetch('/post/rate', {
        method: 'post',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'rateValue': rateValue,
          'postID': post_uuid,
        }),
      })
        .then(rsp => rsp.json())
        .then(rst => {
          // let rateSession = document.querySelector('.session-status');
          // if (rateSession != undefined || rateSession != null) {
          //   rateSession.remove();
          // }
          // let div = document.createElement('div');
          // div.setAttribute('class', 'rate-session session-status');
          // rst.status == true ? div.style.backgroundColor = 'rgb(187 247 208)' : div.style.backgroundColor = 'rgb(254 202 202)';
          // div.innerHTML = rst.message + `<button class='close black scale-50' onclick='this.parentNode.remove()'></button>`;
          // document.querySelector('main').prepend(div);
          Alpine.store('session').push(rst.status, rst.message);

          rst.status == true ? Alpine.store('setStarRating').run(document.querySelector('div[star-container]'), rst.postRate) : null;
        });
    });
  },
}

Alpine.store('giveRating', GiveRating);