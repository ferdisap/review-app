// import './bootstrap';
// import './inputValue.js'


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('paginationURL',{
  chgURL(e, url){
    e.preventDefault();
    url = (new URL(url));
    // url.searchParams.set('active', $store.selectDiselectFeature.category);
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


// Alpine.store('update', {

//   url: null,

//   status: {
//     error: false,
//   },

//   css: {
//     css_basic: ' text-sm  py-2 px-3 border-gray-300 rounded-md shadow-sm',
//     error_css: ' ring-2 ring-offset-2 ring-pink-400 focus:border-pink-500 focus:ring-pink-500 focus:outline-none',
//     noerror_css: ' focus:ring-sky-500 focus:border-sky-500 focus:outline-none focus:ring-2',
//   },

//   data: function(form_id){
//     let form = document.querySelector(`#${form_id}`);
//     let formData = new FormData(form);
//     let data = {};
//     for(const [key, val] of formData.entries()){
//       eval(`data.${key} = '${val}'`)
//     }
//     this.url = form.action;
//     return data;
//   },

//   fetch: async function(form_id){
//     let data = this.data(form_id);
//     let url = this.url; 
//     const rsp = await fetch(url, {
//       method: data._method,
//       mode: 'cors',
//       cache: 'no-cache',
//       credentials: 'same-origin',
//       headers: {
//         'Content-Type' : 'application/json',
//         '_token' : data._token,
//         'X-Requested-With' : 'XMLHttpRequest'
//       },
//       redirect: 'follow',
//       body: JSON.stringify(data),
//     });
//     return this.rsp = rsp.json();
//   },

//   run: async function(form_id){
//     let response = await this.fetch(form_id);
//     this.rst = response;
//     // if(this.rst.errors){
//     //   this.status.error = true
//     //   this.setCSS('old_password') // 'old password harusnya diambil dari this.rst
//     // }
//     // console.log(this.rst);
//     // response.then(rst => this.rst = rst)
//     // console.log(this.rst, 'rstnya');
//   },

//   setCSS: function(input_name){
//     const el = document.querySelector(`#${input_name}`);
//     el.classList = this.css.css_basic + this.css.error_css;
//   },

//   rsp: null,
//   rst: null,


// })

// Alpine.store('fill_input', {
//   // fetch: function(param){
//   //   let form = param.parentNode.querySelector('form');
//   //   let formData = new FormData(form);
//   //   for (const [key, val] of formData.entries()){
//   //     console.log(`${key} => ${val}`);
//   //   }
//   // },
//   // bar: function(){
//   //   alert('bar');
//   // }

//   getFormData: function(el){
//     let form = el.querySelector('form');
//     let formData = new FormData(form);
//     for (const [key, val] of formData.entries()){
//       console.log(`${key} => ${val}`);
//     }
//   }

// })

// Alpine.store('changeSRC', {
//   execute(img, altSRC = '/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg', altExtension = [] ){
//     // const altExtension = ['.png', '.gif', '.bmp',];
//     const regex = /\.\w+$/gm;
//     let pathWithoutExtension = img.src.replace(regex, '');

//     function setSRC(){
//       if (typeof altExtension[0] == 'undefined'){
//         // img.src =  window.location.origin + '/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg';
//         img.src =  window.location.origin + altSRC;
//         return img.removeEventListener('error', setSRC);
//       }
//       img.src = pathWithoutExtension + altExtension[0];
//       altExtension.shift();
//     }

//     img.addEventListener('error', setSRC);
//   },
// });

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

Alpine.start();


