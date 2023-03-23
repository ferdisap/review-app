// const ViewPostImg = {
//   img: document.querySelector('.img-post-display'),
//   circle: document.querySelector('circle'),
//   circleAll: document.querySelectorAll('circle'),
//   nextimg() {
//     if (this.img.nextElementSibling != null) {
//       this.img.classList.add('hidden');
//       this.img.nextElementSibling.classList.remove('hidden');
//       this.img = this.img.nextElementSibling;

//       this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circle.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circle = this.circle.nextElementSibling;
//     }
//   },
//   previmg() {
//     if (this.img.previousElementSibling != null) {
//       this.img.classList.add('hidden');
//       this.img.previousElementSibling.classList.remove('hidden');
//       this.img = this.img.previousElementSibling;

//       this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circle.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circle = this.circle.previousElementSibling;
//     }
//   },
//   deleteEl(el) {
//     this.circleAll[el.getAttribute('circle')].remove();
//     el.remove();
//   },
// }

// Alpine.store('viewPostImg', ViewPostImg);

// const ViewPostImg_first = {
//   circle: function () { return document.createElementNS('http://www.w3.org/2000/svg', 'circle') },
//   svg: function () { return document.createElementNS('http://www.w3.org/2000/svg', 'svg') },
//   circleContainer: document.querySelector('.circle-container'),
//   qtyImg: 0,
//   init() {
//     let active = document.querySelector('div[active]').getAttribute('active');
//     let imgActive = document.getElementById(`img${active}`);
//     this.active ?? (this.active = active);
//     this.imgActive ?? (this.imgActive = imgActive);
//     console.log('this.imgActive:', window.imgActive = this.imgActive);
//     if (this.imgActive != undefined){
//       imgActive.classList.remove('hidden');
//       this.imgActive = imgActive;
//     }

//     // tes new algorithm
//     // let imgAll = document.querySelectorAll('.post-img-container');
//     // this.imgActive ?? (this.imgActive = imgAll[0]);
//     // end tes new algorithm

//     this.slider();

//     return active;
//   },
//   onload() {
//     this.qtyImg += 1;
//     Alpine.store('delay').delay(500, () => {
//       let svg = this.editSvg();
//       this.circleContainer.innerHTML = '';
//       this.circleContainer.appendChild(svg);
//     })
//   },
//   editSvg() {
//     let active = this.active ?? null;
//     let qtyCircle = 0;
//     let svg = this.svg();

//     for (let i = 0; i < this.qtyImg; i++) {
//       qtyCircle += 1;
//       let circle = this.circle();
//       circle.setAttribute('fill', `rgba(0,0,0,${active == i ? 0.9 : 0.2})`);
//       circle.setAttribute('stroke', 'none');
//       circle.setAttribute('cy', '6.5');
//       circle.setAttribute('cx', String(6 + (18 * qtyCircle)));
//       circle.setAttribute('r', '6');
//       svg.appendChild(circle);
//     }

//     svg.setAttribute('height', '13px');
//     svg.setAttribute('width', String(12 + (18 * qtyCircle)));
//     svg.setAttribute('viewBox', `0 0 ${12 + (18 * qtyCircle)} 13`);

//     return svg;
//   },

//   getCircleActive() {
//     let arr = [];
//     document.querySelectorAll('.post-img-container > img').forEach(el => {
//       arr.push(el.id);
//     });
//     let crcAct = document.querySelector(`circle:nth-child(${arr.indexOf(this.imgActive.id) + 1})`);
//     // console.log('imgActive', arr.indexOf(this.imgActive.id));
//     // console.log('crcAct', crcAct);
//     this.circleActive = crcAct;
//     // return crcAct;
//   },

//   nextimg() {
//     // console.log(this.circleActive == undefined ? 'foo' : 'bar');
//     this.circleActive ?? this.getCircleActive();
//     if (this.imgActive.nextElementSibling != null) {
//       this.imgActive.classList.add('hidden');
//       this.imgActive.nextElementSibling.classList.remove('hidden');
//       this.imgActive = this.imgActive.nextElementSibling;

//       this.circleActive.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circleActive.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circleActive = this.circleActive.nextElementSibling;
//       // console.log(this.circleActive);
//     }
//   },
//   previmg() {
//     this.circleActive ?? this.getCircleActive();
//     if (this.imgActive.previousElementSibling != null) {
//       this.imgActive.classList.add('hidden');
//       this.imgActive.previousElementSibling.classList.remove('hidden');
//       this.imgActive = this.imgActive.previousElementSibling;

//       this.circleActive.setAttribute('fill', 'rgba(0,0,0,0.2)');
//       this.circleActive.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
//       this.circleActive = this.circleActive.previousElementSibling;
//     }
//   },

//   slider() {
//     let imgContainer = document.querySelector('div[x-data=viewPostImg]');
//     imgContainer.addEventListener('touchstart', (e) => {
//       this.clientX = e.touches[0].clientX;
//     });
//     imgContainer.addEventListener('touchmove',(e) => {
//       Alpine.store('delay').delay(50, () => {
//         (e.touches[0].clientX - this.clientX) <= 50 ? this.nextimg() : this.previmg();
//       });
//     });
//   }
// }

const ViewPostImg = {
  imgAll: [],
  async init() {
    for (let i = 0; i < 5; i++) {
      let img = await this.loadImg.execute(i);
      if (img){
        switch (i) {
          case 0:
            // show Img
            img.classList.remove('hidden');
            this.imgActive = img;        
          default:
            // getting all image
            this.imgAll.push(img);
            break;
        }
      }
    }

    // set circle 5ea
    this.setCircle();

    // run touch sliding
    this.slider();
  },
  /**
   * run touch sliding for changing the image
   */
  slider() {
    let imgContainer = document.querySelector('div[x-data=viewPostImg]');
    imgContainer.addEventListener('touchstart', (e) => {
      this.clientX = e.touches[0].clientX;
    });
    imgContainer.addEventListener('touchmove', (e) => {
      Alpine.store('delay').delay(50, () => {
        (e.touches[0].clientX - this.clientX) <= 50 ? this.setImg(true) : this.setImg(false);
      });
    });
  },

  /**
   * next or previous post image show
   * @param {Bool} next 
   */
  setImg(next = true) {
    this.imgActive.classList.remove('scale-150');

    //hide img
    this.imgActive.classList.add('hidden');
    
    // hide circle
    let imgIndex = Array.prototype.indexOf.call(this.imgActive.parentNode.children, this.imgActive);
    let currentCircle = document.querySelector(`span[id=circle${/[0-9]/.exec(imgIndex)[0]}]`);
    currentCircle.classList.remove('black');

    if (eval(`this.imgActive.${next ? 'nextElementSibling' : 'previousElementSibling'}`) == null) {
      //show img
      eval(`this.imgActive = this.imgActive.parentElement.${next ? 'firstChild' : 'lastChild'}`);
      this.imgActive.classList.remove('hidden');
      // show circle
      currentCircle = document.querySelector(`span[id=circle${/[0-9]/.exec(this.imgActive.id)[0]}]`);
      currentCircle.classList.add('black');
    } else {
      //show img
      eval(`this.imgActive.${next ? 'nextElementSibling' : 'previousElementSibling'}.classList.remove('hidden')`);
      eval(`this.imgActive = this.imgActive.${next ? 'nextElementSibling' : 'previousElementSibling'}`);
      //show circle
      eval(`currentCircle.${next ? 'nextElementSibling' : 'previousElementSibling'}.classList.add('black')`);
    }
  },

  /**
   * set the circle of available iamge 
   * runned by init(), there are 5ea circle
   */
  setCircle() {
    //create circle
    let circle = document.createElement('span');
    circle.classList.add('circle');

    // set the circle black or gray
    this.imgAll.forEach((el, n) => {
      var circle = document.createElement('span');
      circle.classList.add('circle');
      circle.classList.add('gray');
      if (this.imgActive.id == el.id) {
        circle.classList.add('black');
      }
      circle.id = 'circle' + n;

      // append the circle to the container
      let circleContainer = document.querySelector('div[x-data=viewPostImg] div.circle-container');
      circleContainer.appendChild(circle);
    })
  },

  needZoom: true,
  zoom(target, img = null) {
    if (target.tagName != 'IMG') {
      img.classList.remove('scale-150');
      this.needZoom = true;
      return;
    }
    if (this.needZoom) {
      target.classList.add('scale-150');
      this.needZoom = false;
    } else {
      target.classList.remove('scale-150');
      this.needZoom = true;
    }
  },

  loadImg: {
    createImg(idImg = null) {
      let img = document.createElement('img');
      img.setAttribute('x-on:click', 'zoom($el)');
      img.setAttribute('x-on:click.outside', 'zoom(event.target, $el)');
      img.setAttribute('class', "hidden shadow-lg postImg-show animate1s transition-05");
      img.setAttribute('alt', document.querySelector('main > div > h1').innerText);
      idImg != null ? img.setAttribute('id', `img${idImg}`) : null;
      return img;
    },
    setImgSrc(img, blob) {
      let urlCreator = window.URL || window.webkitURL;
      var imageUrl = urlCreator.createObjectURL(blob);
      img.src = imageUrl;
      return img;
    },
    async execute(indexImg = null) {
      if (indexImg == null){
        return Promise.resolve(false);
      }
      let imgCont = document.querySelector('.post-img-container');
      let a = fetch(`http://127.0.0.1:8000/postImages/${sessionStorage.getItem('post_author_username')}/display/${sessionStorage.getItem('post_uuid')}_400_images.${indexImg}.jpg`).
        then(async (rsp) => {
          if (rsp.ok) {
            let blob = await rsp.blob();
            let img = this.createImg(indexImg);
            this.setImgSrc(img, blob);
            imgCont.appendChild(img);
            return img;
          } 
          else {
            return false;
          }
        });
        return a;

    }
  }

}

Alpine.data('viewPostImg', () => (ViewPostImg));