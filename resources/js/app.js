// import './bootstrap';
// import './inputValue.js'


import Alpine from 'alpinejs';

window.Alpine = Alpine;

// function showTT(event, id){
//   event.target.
// }

// var ttIds = document.querySelectorAll('*[tt-id]');
// ttIds.forEach( el => {
//   el.addEventListener('mouseover', showTT);
// });
// console.log(ttIds);

Alpine.store('changeURL', {
  execute(element, attribute ,url){
    element.setAttribute(attribute, url);
  },
})

Alpine.store('selectDiselectFeature', {
  ckboxDisplay: 'none',
  qtyPostDraft: null,
  qtyPostPublished: null,
  showAllPost(cat = null) {
    this.category == undefined ? (this.category = document.getElementById('content').getAttribute('active')) : this.hideAllPost();
    cat != undefined ? (this.category = cat) : null;
    document.getElementById(this.category).style.display = 'block';
    document.getElementById('active-content').value = this.category;
    document.querySelector('div[for=' + this.category + ']').classList.add('active-content');
  },
  hideAllPost() {
    document.getElementById(this.category).style.display = 'none';
    this.toogle(false);
    document.querySelector('div[for=' + this.category + ']').classList.remove('active-content');
  },
  initialization() {
    this.qtyPostDraft = document.querySelectorAll('#draft .list-post');
    this.qtyPostPublished = document.querySelectorAll('#published .list-post');

    this.content = document.getElementById('content');

    let content = this.content;
    if (content.getAttribute('mousedownHandler') == 'false') {
      content.setAttribute('mousedownHandler', 'true');
      content.addEventListener('mousedown', (e) => {
        if (this.ckboxDisplay == 'none') {
          var to = setTimeout(this.showCkBox.bind(this, e), 500);
          content.onclick = null;
        }
        else {
          var to = setTimeout(() => {
            this.toogle(false);
            this.hideCkBox();
          }, 500);
          content.onclick = (e) => e.preventDefault();
        }
        var clsTimeoutHandler = function () {
          clearTimeout(to);
          if (content.getAttribute('mouseupHandler') == 'true') {
            content.setAttribute('mouseupHandler', false);
            content.removeEventListener('mouseup', clsTimeoutHandler);

          }
        }.bind(this);

        if (content.getAttribute('mouseupHandler') == 'false') {
          content.setAttribute('mouseupHandler', true);
          content.addEventListener('mouseup', clsTimeoutHandler);
        }
      });
    }

    this.showAllPost();

    // jika ingin otomatis selected All/not jika pindah category, taruh ini di dalam @showAllPost
    // alert(document.getElementById('toogle-switch').checked);
    let checked = document.getElementById('toogle-switch').checked;
    if (checked) {
      this.toogle(checked);
    }
    // this.toogle(document.getElementById('toogle-switch').checked);
  },
  showCkBox() {
    this.selectBoxHandler = this.selectBox.bind(this);
    let content = this.content;
    if (content.getAttribute('clickHandler') == 'false') {
      content.setAttribute('clickHandler', 'true');
      document.getElementById('content').addEventListener('click', this.selectBoxHandler);
    }
    document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach(el => el.style.display = 'block');
    this.ckboxDisplay = 'block';
  },
  hideCkBox() {
    let content = this.content;
    if (content.getAttribute('clickHandler') == 'true') {
      content.setAttribute('clickHandler', 'false');
      document.getElementById('content').removeEventListener('click', this.selectBoxHandler);
    }
    document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach(el => el.style.display = 'none');
    this.ckboxDisplay = 'none';
  },
  selectBox(e) {
    e.preventDefault();

    e.target.type == 'checkbox' ? setTimeout(() => e.target.checked = !e.target.checked, 0) : (() => {
      let input = this.getTheCheckBox(e.target);
      input.checked = !input.checked;
    })();
    let sum = this.getCheckedQty();
    if (sum[1].length == sum[0].length) {
      this.toogle(true);
    }
    else if (sum[1].length == 0) {
      this.toogle(false);
    }
    else if (sum[1].length < sum[0].length) {
      document.getElementById('toogle-switch').checked = false;
    }
  },
  toogle(v) {
    document.getElementById('toogle-switch').checked = v;
    if (v) {
      this.selectAll();
      if (this.ckboxDisplay == 'none') {
        this.showCkBox();
      }
    } else {
      this.deselectAll();
      this.hideCkBox();
    }
  },
  selectAll() {
    document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach(el => el.checked = true);
  },
  deselectAll() {
    document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach(el => el.checked = false);
  },

  // Fungsi Pendukung
  getCheckedQty() {
    // return [qty, fill];
    return this.category == 'draft' ?
      [this.qtyPostDraft, [].filter.call(document.querySelectorAll('#draft .list-post'), el => this.getTheCheckBox(el).checked)] :
      [this.qtyPostPublished, [].filter.call(document.querySelectorAll('#published .list-post'), el => this.getTheCheckBox(el).checked)];
  },
  getTheCheckBox(el) {
    let targetBox = el.nodeName == 'A' ? el :
      el.parentElement.nodeName == 'A' ? el.parentElement :
        el.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement :
          el.parentElement.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement.parentElement :
            el.parentElement.parentElement.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement.parentElement.parentElement : null;
    return targetBox.previousSibling.previousSibling.nodeName == 'INPUT' ? targetBox.previousSibling.previousSibling : targetBox.parentElement.querySelector('.list-post-checklist');
  },
});

Alpine.store('previewThumbnail', {
  show(imgFile, imgTag) {
    // console.log('foo');
    const FR = new FileReader();
    FR.addEventListener('load', () => {
      document.querySelector(imgTag).src = FR.result;
    }, false);
    FR.readAsDataURL(imgFile.files[0]);
  }
});

Alpine.store('search', {
  modal: document.getElementById('modal-search'),
  inputText: document.getElementById('search-input'),
  open(e) {
    this.modal.classList.remove('hidden');
    this.keyupHandler = this.keyupHandler.bind(this);
    this.modal.addEventListener('keyup', this.keyupHandler);
    this.inputText.value = "";
    this.inputText.focus();
    e.preventDefault();
  },
  close() {
    this.modal.classList.add('hidden');
    this.modal.removeEventListener('keyup', this.keyupHandler);
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
          // console.log(e.target)
          e.target.nextElementSibling.focus();
          break;

        case "ArrowUp":
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
    if (e.key == 'ArrowUp' || e.key == 'ArrowDown' || e.key == 'Escape' || e.key == 'Tab' ){
      return undefined;
    }
    Alpine.store('delay').delay(500, () => {
        fetch('/post/search', {
          method:'post',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'key' : this.inputText.value,
          }),
        })
        .then(rsp => rsp.json())
        .then(rst => {
          document.querySelectorAll('#modal-search > div > a').forEach(list => list.remove());
          for (let i = 0; i < 4; i++) {
            let ratingValue = 40 / 2 // rst.posts[i].ratingValue/2
            let star1 = ratingValue - 10 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 10 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
            let star2 = ratingValue - 20 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 20 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
            let star3 = ratingValue - 30 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 30 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
            let star4 = ratingValue - 40 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 40 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
            let star5 = ratingValue - 50 >= 0 ? "<span class='star orange'></span>" : (ratingValue - 50 >= -5 ? "<span class='star orange-to-black'></span>" : "<span class='star black'></span>")
            var str = `<div>          
                        <div>
                          <div>
                            <img loading="lazy" src="/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg" alt="" class="scale-11 transition-05">
                          </div>
                          <div>
                            <h6 class="md:text-md lg:text-lg">${rst.posts[i].title}</h6>
                            <p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">${rst.posts[i].simpleDescription}</p>
                          </div>
                          <div>
                            <div>
                              <div>
                                ${star1}
                                ${star2}
                                ${star3}
                                ${star4}
                                ${star5}
                              </div>
                              <p class="text-dsm">${ratingValue * 2}</p>
                            </div>
                          </div>
                        </div>
                      </div>`;
            let list = document.createElement('a');
            list.classList.add('list-post-container');
            list.href = `/post/show/${rst.posts[i].uuid}`;
            list.innerHTML = str;
            document.querySelector('#modal-search div').appendChild(list);
          }
          if (rst.posts.length > 4) {
            var str = ` <div class="more_result">
                            ${rst.posts.length} posts found.
                          </div>`;
            let more = document.createElement('a');
            more.classList.add('list-post-container');
            more.href = `javascript:void`;
            more.innerHTML = str;
            document.querySelector('#modal-search div').appendChild(more);
          }
        });
    });
  },
});

Alpine.store('delay', {
  delay(t, callback) {
    clearTimeout(this.to);
    this.to = setTimeout(callback, t);
  }
})

Alpine.store('setStarRating', {
  run(container, value){
    container.innerHTML = '';
    this.ratingValue(container, value);
  },
  ratingValue(container, value){
    value = value/2;
    value - 10 >= 0 ? this.createStar(container, 'orange') : (value - 10 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
    value - 20 >= 0 ? this.createStar(container, 'orange') : (value - 20 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
    value - 30 >= 0 ? this.createStar(container, 'orange') : (value - 30 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
    value - 40 >= 0 ? this.createStar(container, 'orange') : (value - 40 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;
    value - 50 >= 0 ? this.createStar(container, 'orange') : (value - 50 >= -5 ? this.createStar(container, 'orange-to-black') : this.createStar(container, 'black')) ;      
    container.nextElementSibling.innerHTML = value
  },
  createStar(container, color){
    let el = document.createElement('span');
    el.classList.add('star', color);
    container.appendChild(el);
  }
});

Alpine.start();


