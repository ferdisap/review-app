// import './bootstrap';
// import './inputValue.js'


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('paginationURL',{
  chgURL(e, url){
    e.preventDefault();
    url = (new URL(url));
    url.searchParams.set('active', Alpine.store('selectDiselectFeature').category);
    window.location.href = url;
  }
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
    if(checked){
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
    console.log('foo');
    const FR = new FileReader();
    FR.addEventListener('load', () => {
      document.querySelector(imgTag).src = FR.result;
    }, false);
    FR.readAsDataURL(imgFile.files[0]);
  }
});

Alpine.store('search', {
  open(){
    modal = document.getElementById('modal-search');
    modal.classList.remove('hidden');
    modal.addEventListener('keydown', keydownHandler);
  },
  close(){
    modal = document.getElementById('modal-search');
    modal.classList.add('hidden');
    modal.removeEventListener('keydown', keydownHandler);
  },
  keydownHandler(){
    document.querySelectorAll("#modal-search *[tabindex='0']");
  },

  

  init(){

  }
});

Alpine.start();


