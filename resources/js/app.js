// import './bootstrap';
// import './inputValue.js'


import Alpine from 'alpinejs';

window.Alpine = Alpine;

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

Alpine.store('changeSRC', {
  formats: [],
  regex: /\.\w+$/gm,
  execute(el,src){
    if (typeof this.formats[0] == 'undefined'){
      return el.src =  window.location.origin + "/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg";
    }  
    el.src = src + this.formats[0];
    this.formats.shift();
    el.addEventListener('error', function(){
      changeSRC(el, src, this.formats);
    });
  },
  setFormats(formats = []){
    this.formats = formats;
  },
  // changeSRC(){
    // let imgs = document.querySelectorAll('.thumbnail-img');
    //     imgs.forEach(img => {  
    //       let src = img.src.replace(regex, '');
    //       let imgFormats = formats.slice();
    //       img.addEventListener('error', function(){
    //         changeSRC(this, src, imgFormats);
    //       });
  // }
});

Alpine.start();


