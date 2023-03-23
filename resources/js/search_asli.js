export const search = {
  modal: document.getElementById('modal-search'),
  inputText: document.getElementById('search-input'),
  isOpen: false,
  open(e) {
    
    this.modal.classList.remove('hidden');
    this.keyupHandler = this.keyupHandler.bind(this);
    this.modal.addEventListener('keyup', this.keyupHandler);
    this.inputText.value = "";
    this.inputText.focus();
    e.preventDefault();
    this.renderList(JSON.parse(localStorage.getItem('post_searched_result')), true);
    this.isOpen = true;
  },
  close(etarget = null) {
    // berfungsi agar orang bisa klik pakai logo search
    if (etarget != null && etarget.classList.contains('search')) {
      return;
    }
    this.modal.classList.add('hidden');
    this.modal.removeEventListener('keyup', this.keyupHandler);
    this.isOpen = false; 
  },
  init() {
    document.addEventListener('keydown', (e) => {
      switch (e.key) {
        case "/":
          // console.log('/');
          if (this.modal.classList.contains('hidden')) {
            this.open(e);
          } else {
            if (e.target.nodeName != "INPUT") {
              e.preventDefault();
              this.inputText.focus();
            }
          }
          break;

        case "ArrowDown":
          this.isOpen ? e.preventDefault() : null;
          if (e.target.nextElementSibling == null){
            this.inputText.focus();
            break;
          }
          if (e.target.nextElementSibling.tabIndex > 0){
            e.target.nextElementSibling.nextElementSibling.focus();
            break;
          }
          e.target.nextElementSibling.focus();
          break;

        case "ArrowUp":      
          this.isOpen ? e.preventDefault() : null;
          if (e.target.id == 'search-input'){
            e.target.parentElement.lastChild.focus();
            break;
          }
          if (e.target.previousElementSibling.tabIndex > 0){
            e.target.previousElementSibling.previousElementSibling.focus();
            break;
          }
          e.target.previousElementSibling.focus();
          break;

        case "Escape":
          this.close();
          break;

        default:
          break;
      }
    });
  },
  keyupHandler(e) {
    console.log('foo');
    if (e.key == 'ArrowUp' || e.key == 'ArrowDown' || e.key == 'Escape' || e.key == 'Tab' || e.target.value == '') {
      return;
    }
    Alpine.store('delay').delay(500, () => {
      fetch('/post/search', {
        method: 'post',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'key': this.inputText.value,
        }),
      })
        .then(rsp => rsp.json())
        .then(rst => {
          console.log(rst);
          if (rst.posts.length == 0) {
            this.renderList(null);
            return;
          }
          localStorage.setItem('post_searched_result', JSON.stringify(rst.posts));          

          // membuat list post berdasarkan hasil pencarian, max 4
          this.renderList(rst.posts);
        });
    });
  },

  renderList(posts, recent = false) {

    // di remove dulu semua hasil pencarian sebelumnya
    document.querySelectorAll('#modal-search > div > a').forEach(list => list.remove());

    // add recent text
    if (recent){
      let recent = document.createElement('a');
      recent.href = 'javascript:void';
      recent.classList.add('list-post-container');
      recent.innerText = 'Recent:';
      recent.style.color = 'white';
      recent.style.fontSize = '0.75rem';
      recent.tabIndex="1";
      this.inputText.after(recent);
    }

    // add no post,
    if (posts == null){     
      let nopost = document.createElement('a');
      nopost.href = 'javascript:void';
      nopost.classList.add('list-post-container');
      nopost.innerText = 'No Post Result:';
      nopost.style.color = 'white';
      this.inputText.after(nopost);
    } else {
      // rendering post
      let container = document.querySelector('#modal-search div');
      for (let i = 0; i < posts.length; i++) {
        let ratingValue = (posts[i].ratingValue ?? 0) / 2 // posts[i].ratingValue/2
        let star1 = ratingValue - 10 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 10 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star2 = ratingValue - 20 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 20 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star3 = ratingValue - 30 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 30 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star4 = ratingValue - 40 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 40 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        let star5 = ratingValue - 50 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 50 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
        var str = `<div><div><div><img loading="lazy" src="/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg" alt="" class="scale-11 transition-05"></div><div><h6 class="md:text-md lg:text-lg">${posts[i].title}</h6><p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">${posts[i].simpleDescription}</p></div><div><div><div>${star1}${star2}${star3}${star4}${star5}</div><p class="text-dsm">${ratingValue * 2}</p></div></div></div></div>`;
        let list = document.createElement('a');
        list.classList.add('list-post-container');
        list.href = `/post/show/${posts[i].uuid}`;
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
