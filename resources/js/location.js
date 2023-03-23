export const modal_location_search = {
  name: 'modal_location_search',
  modal: document.getElementById('location-search'),
  modalContainerId: 'location-search',
  inputText: document.getElementById('location-input'),
  isRender: true,
  open(e) {
    // this.modal.parentElement.setAttribute('active', 'location');
    // return Alpine.store('search').keyupHandler(e, Alpine.store('modal_location_search'));
    // alert(this.inputText.value);
    return Alpine.store('search').open(e, Alpine.store('modal_location_search'));
  },
  close() {
    // this.modal.parentElement.setAttribute('active', 'none');
    // return Alpine.store('search').keyupHandler(null, Alpine.store('modal_location_search'));
    return Alpine.store('search').close(null, Alpine.store('modal_location_search'));
  },
  // keyupHandler(e) {
  //   return Alpine.store('search').keyupHandler(e, Alpine.store('modal_location_search'));
  // },
  // keydownHandler(e) {
  //   return Alpine.store('search').keydownHandler(e, Alpine.store('modal_location_search'));
  // },
  init() {
    if (localStorage.getItem('location_selected')) {
      this.changeView(localStorage.getItem('location_selected'));
    }

    // document.querySelector("p[for=location]")
    if (sessionStorage.getItem('auth_username')) {
      // fetch('/address/pull?username=' . sessionStorage.getItem('auth_username'))
      // .then(rsp => console.log(rsp));
      fetch('/address/pull?username=' + sessionStorage.getItem('auth_username'))
        .then(rsp => rsp.json())
        .then(rst => {
          // console.log(rst);
          if(rst.status == 200){
            localStorage.setItem('location_selected', rst.address);
            this.changeView(rst.address);
          }
        });
    }
  },
  fetch: {
    url: '/address/search',
    configuration: {
      method: 'get',
      body: null
    },
    getBody: function () { return this.fetch.configuration.body = JSON.stringify({ 'name': this.inputText.value }) },
  },
  renderList(results = null, recent = false) {

    if (!this.isRender) {
      return;
    }

    if (results == null) {
      return;
    }

    // di remove dulu semua hasil pencarian sebelumnya
    document.querySelectorAll('#location-search > div > a').forEach(list => list.remove());

    // add recent text
    if (recent) {
      let recent = document.createElement('a');
      recent.href = 'javascript:void';
      recent.classList.add('list-post-container');
      recent.innerText = 'Recent:';
      recent.style.color = 'white';
      recent.style.fontSize = '0.75rem';
      recent.tabIndex = "1";
      this.inputText.after(recent);
    }

    // add address list,
    if (results.addresses.length > 0) {
      let container = document.querySelector(`#${this.modalContainerId} div`);
      results.addresses.forEach(address => {
        let parent1, parent2, parent3
        let list = document.createElement('a');
        list.href = 'javascript:void(0)';
        list.setAttribute('onclick', "event.preventDefault(); Alpine.store('modal_location_search').pushEnter(event)");
        list.classList.add('list-post-container');
        list.innerText = `${address.name}${(parent1 = address.parent) ? (', ' + parent1.name) : parent1 = ''}${parent1 != '' ? ((parent2 = address.parent.parent) ? (', ' + parent2.name) : parent2 = '') : ''}${parent2 != '' ? ((parent3 = address.parent.parent.parent) ? (', ' + parent3.name) : parent3 = '') : ''}`;
        list.style.color = 'white';
        container.appendChild(list);
      });
    } else {
      // rendering post
      let container = document.querySelector(`#${this.modalContainerId} div`);
      let noaddress = document.createElement('a');
      noaddress.classList.add('list-post-container');
      noaddress.href = `javascript:void(0)`;
      noaddress.innerHTML = `<div style="width:100%;margin-top:1rem;margin-bottom:0.5rem;text-align:left;color:white">No Address Found.</div>`
      container.appendChild(noaddress);
    }
  },
  pushEnter(e) {
    // console.log(window.e = e);
    if (e.target.tagName != 'A') {
      return;
    }
    this.inputText.value = e.target.text;
    localStorage.setItem(this.modalContainerId, e.target.text);
    this.isRender = false;
    setTimeout(() => {
      this.isRender = true;
    }, 1000);

    this.changeView(e.target.text);
    localStorage.setItem('location_selected', e.target.text);
    this.close();
    if (sessionStorage.getItem('auth_username')) {
      this.setUserLocationInDB(e.target.text);
    }
  },
  changeView(message) {
    let p = document.querySelector('nav p[for=location]');
    p.firstChild.firstChild.innerHTML = message;
    p.firstChild.setAttribute('class', 'pin_drop');
  },
  setUserLocationInDB(location) {
    location = location.split(',')[0];

    let configuration = {
      method: 'post',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        'name': location,
      }),
    }
    // return console.log(configuration);
    fetch('/address/push', configuration)
      .then(rsp => console.log(rsp));
  }
}