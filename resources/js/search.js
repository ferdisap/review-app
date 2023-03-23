const search = {
  open(e, context = Alpine.store('modal_post_search')) {
    context.modal.classList.remove('hidden');

    context.keyupHandler = this.keyupHandler.bind(context);
    context.modal.addEventListener('keyup', context.keyupHandler);

    context.keydownHandler = this.keydownHandler.bind(context);
    context.modal.addEventListener('keydown', context.keydownHandler);

    context.inputText.value = "";
    context.inputText.focus();
    e.preventDefault();
    context.renderList(JSON.parse(localStorage.getItem(context.name)), true);
    context.isOpen = true;
    document.querySelector('#modal').setAttribute('active', context.modalContainerId);
  },
  close(e = null, context = Alpine.store('modal_post_search')) {
    // console.log('close', window.e = e, context);
    // berfungsi agar orang bisa klik pakai logo search
    if (e){
      if (e.target.classList.contains('search') || e.target.parentElement.parentElement.getAttribute('for') == 'location') {
        return;
      }
    }
    context.modal.classList.add('hidden');
    context.modal.removeEventListener('keyup', context.keyupHandler);
    context.modal.removeEventListener('keydown', context.keydownHandler);
    context.isOpen = false;
    document.querySelector('#modal').setAttribute('active', 'none');
  },
  init() {
    document.addEventListener('keydown', (e) => {
      switch (e.key) {
        case "/":
          if (document.querySelector('#modal[active]').getAttribute('active') == 'none') {
            this.open(e, Alpine.store('modal_post_search'));
          }
          break;
        default:
          break;
      }
    });
  },
  keydownHandler(e) {
    // console.log(this.isOpen);
    // console.log(window.e = e);
    switch (e.key) {
      case "ArrowDown":
        this.isOpen ? e.preventDefault() : null;
        if (e.target.nextElementSibling == null) {
          this.inputText.focus();
          break;
        }
        if (e.target.nextElementSibling.tabIndex > 0) {
          e.target.nextElementSibling.nextElementSibling.focus();
          break;
        }
        e.target.nextElementSibling.focus();
        break;

      case "ArrowUp":
        this.isOpen ? e.preventDefault() : null;
        if (e.target.tagName == 'INPUT') {
          e.target.parentElement.lastChild.focus();
          break;
        }
        if (e.target.previousElementSibling.tabIndex > 0) {
          e.target.previousElementSibling.previousElementSibling.focus();
          break;
        }
        e.target.previousElementSibling.focus();
        break;

      case "Escape":
        // console.log('escape', e, e.target);
        Alpine.store('search').close(e, this);
        break;

      case "/":
        e.preventDefault();
        this.inputText.focus();
        break;

        //sudah dilakukan dengan onclick pada setiap elementnya
      // case "Enter":
        // this.pushEnter ? this.pushEnter(e) : null
        // break; 

      default:
        break;
    }
  },
  keyupHandler(e) {
    if (!e){
      // console.log('foo');
      return;
    }
    // console.log('keyupH', this);
    if (e.key == 'ArrowUp' || e.key == 'ArrowDown' || e.key == 'Escape' || e.key == 'Tab' || e.target.value == '') {
      return;
    }

    this.fetch.getBody.bind(this)();

    let url;
    let configuration;
    if (this.fetch.configuration.method == 'get'){
      url = this.fetch.url + '?';
      let suffix = JSON.parse(this.fetch.configuration.body)
      // return console.log('suffix',window.suffix = suffix);
      suffix = Object.entries(suffix);
      suffix.forEach(el => {
        url = url + el[0] + '=' + el[1] + '&';
      });
    } else {
      url = this.fetch.url;
      configuration = this.fetch.configuration;
    }

    Alpine.store('delay').delay(500, () => {
      fetch(url, configuration)
        .then(rsp => rsp.json())
        .then(rst => {
          // if (rst.results.length == 0) {
          //   this.renderList(null);
          //   return;
          // }
          // localStorage.setItem('post_searched_result', JSON.stringify(rst.results));
          // console.log(this.name);
          localStorage.setItem(this.name, JSON.stringify(rst));

          // membuat list post berdasarkan hasil pencarian, max 4
          // console.log('rst.results', rst.results);
          // this.renderList(rst.results);
          this.renderList(rst);
        });
    });
  },
}


const modal_post_search = {
  name: 'modal_post_search',
  modal: document.getElementById('modal-search'),
  modalContainerId: 'modal-search',
  inputText: document.getElementById('search-input'),
  isOpen: false,
  fetch: {
    url: '/post/search', 
    configuration: {
      method: 'post',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body:null
    },
    getBody: function() {return this.fetch.configuration.body = JSON.stringify({'key': this.inputText.value})},
  } ,
  renderList(results = null, recent = false) {

    if (results == null){
      return;
    }
    // return console.log('results', results);

    // di remove dulu semua hasil pencarian sebelumnya
    document.querySelectorAll('#modal-search > div > a').forEach(list => list.remove());

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

    // add no post,
    if (results.posts.length <= 0) {
      let nopost = document.createElement('a');
      nopost.href = 'javascript:void';
      nopost.classList.add('list-post-container');
      nopost.innerText = 'No Post Result:';
      nopost.style.color = 'white';
      this.inputText.after(nopost);
    } else {
      // rendering post
      let container = document.querySelector(`#${this.modalContainerId} div`);
      for (let i = 0; i < results.posts.length; i++) {
        let ratingValue = (results.posts[i].ratingValue ?? 0) / 2 // results.posts[i].ratingValue/2
        let star1 = ratingValue - 10 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 10 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star2 = ratingValue - 20 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 20 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star3 = ratingValue - 30 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 30 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star4 = ratingValue - 40 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 40 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star5 = ratingValue - 50 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 50 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        var str = `<div><div><div><img loading="lazy" src="/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg" alt="" class="scale-11 transition-05"></div><div><h6 class="md:text-md lg:text-lg">${results.posts[i].title}</h6><p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">${results.posts[i].simpleDescription}</p></div><div><div><div>${star1}${star2}${star3}${star4}${star5}</div><p class="text-dsm">${ratingValue * 2}</p></div></div></div></div>`;
        let list = document.createElement('a');
        list.classList.add('list-post-container');
        list.href = `/post/show/${results.posts[i].uuid}`;
        list.innerHTML = str;
        container.appendChild(list);
      }
      let more = document.createElement('a');
      more.classList.add('list-post-container');
      more.href = `/search/index`;
      more.innerHTML = `<div style="width:100%;margin-top:1rem;margin-bottom:0.5rem;text-align:center;color:white"onMouseOver="this.style.color='#0089ff'"; onmouseout="this.style.color='white'">See more post result</div>`
      container.appendChild(more);
    }
  }
}

export { search, modal_post_search };